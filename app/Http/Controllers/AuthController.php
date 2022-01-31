<?php

namespace App\Http\Controllers;

use App\Mail\Login;
use App\Models\Trazas;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['data' => 'Credenciales incorrectas'], 401);
        }

        if (auth()->user()->active && isset(auth()->user()->email_verified_at)) {

            $diff = (new \DateTime(date('Y-m-d G:i:s', time())))->diff(new \DateTime(auth()->user()->last_time_passwors_change));

            if ($diff->format("%m") == 0) {
                $user = User::find(auth()->user()->id);
                $user->last_login = date('Y-m-d G:i:s', time());
                $user->save();

                $metadata = [];
                $metadata["action"] = "Login";
                $metadata["ip"] = request()->ip();
                $metadata["access_date"] = date('d-m-Y', time());
                $metadata["access_hours"] = date('G:i:s', time());
                $metadata["browser"] = request()->server('HTTP_USER_AGENT');
                $metadata["users_id"] = auth()->user()->id;

                try {
                    Mail::to(auth()->user()->email)->send(new Login(auth()->user(), $metadata));
                } catch (\Exception $e) {
                    $metadata["action"] = 'No se ah podido enviar el mensaje de inicio de sesion al usuario '.auth()->user()->email;
                }

                Trazas::create($metadata);

                return $this->respondWithToken($token);
            } else {
                return response()->json(['data' => 'Password expired', 'user_token' => auth()->user()->token], 203);
            }

        } else {
            return response()->json(['data' => 'El usuario no esta activo o no ah sido verificado'], 401);
        }
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(User::with(['roles'])->find(auth()->user()->id));
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL()*60,
            'user_data' => User::with('roles')->findOrFail(auth()->user()->id)
        ]);
    }

    public function current()
    {
        return auth()->user();
    }
}
