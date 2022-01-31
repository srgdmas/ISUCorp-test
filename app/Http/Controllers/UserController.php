<?php

namespace App\Http\Controllers;

use App\Mail\RecoverPassword;
use App\Mail\RegistrationUser;
use App\Models\Notification;
use App\Models\BillingUserConcepts;
use App\Models\OldsPasswords;
use App\Models\Permisos;
use App\Models\Trazas;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;


class UserController extends Controller
{
    const relations = ['billing_user_concepts' , 'roles', 'tipos_clientes', 'especialidades', 'provinces', 'promotor'];

    public function index()
    {
        return User::with(self::relations)->get();
    }

    public function get_promotors()
    {
        return User::whereIn('roles_id', [1,4])->get();
    }

    public function store(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return ['code' => 400, 'data' => 'Ya existe un usuario con ese email'];
        }

        $request->validate([
            'name' => 'max:255',
            'lastname' => 'max:255',
            'email' => 'required|unique:users|email',
        ]);

        try {
            $user = new User();
            $user->name = $request->name;
            $user->lastname = $request->lastname;
            $user->password = $request->password ? Hash::make($request->password) : Hash::make($this->gerateRandomPass());
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->mobile = $request->mobile;
            $user->colegiado = $request->colegiado;
            $user->proclinic_code = $request->proclinic_code;
            $user->observacion = $request->observacion;
            $user->promotor_id = $request->promotor;
            $user->provinces_id = $request->provinces_id;
            $user->especialidades_id = $request->especialidades_id;
            $user->tipos_clientes_id = $request->tipos_clientes_id;
            $user->roles_id = $request->roles_id ?? '6';
            $user->token = time() . rand((int)pow(10, 20), (int)pow(10, 30));
            $user->save();

            $billing_concepts = json_decode($request->billing_user_concepts,true);
            foreach($billing_concepts as $bill) {
                $bill['user_id'] = $user->id;
                BillingUserConcepts::create($bill);
            }

            (new \App\Models\Notification)->create('Bienvenido a ISU Corp '.$user->name.' '.$user->lastname,0,$user->id);

            $metadata = [];
            $metadata["action"] = "Creado usuario ".$user->name." ".$user->lastname;
            $metadata["ip"] = request()->ip();
            $metadata["access_date"] = date('d-m-Y', time());
            $metadata["access_hours"] = date('G:i:s', time());
            $metadata["browser"] = request()->server('HTTP_USER_AGENT');
            $metadata["users_id"] = $user->id;
            Trazas::create($metadata);

            $this->set_password($request);

            return ['code' => 201, 'data' => $user];

        } catch (\Exception $e) {
            return ['code' => 500, 'data' => $e->getMessage()];
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'max:255',
            'email' => 'email',
        ]);

        $user = User::find($id);
        if ($user->email !== $request->email) {
            if (User::where('email', $request->email)->exists()) {
                return ['code' => 500, 'data' => 'El correo ya está tomado. Debe especificar uno que no esté registrado'];
            }
        }


        if ($request->file('photo')) {
            $request->validate([
                'photo' => 'mimes:jpeg,jpg,png,gif|max:2048'
            ]);
            if ($user->photo_name){
                Storage::disk('users_avatars')->delete($user->photo_name);
            }
            $image = $request->photo;
            $path = $image->store(auth()->user()->id, 'users_avatars');
            $user->photo_name = $path;
            $user->photo = env('APP_URL') . '/img/users_avatars/' . $path;
        }


        try {

            dd($request->except(['roles', 'billing_user_concepts', 'promotor', 'provinces', 'especialidades', 'tipos_clientes', 'fullname']));
            $user->update($request->except(['roles', 'billing_user_concepts', 'promotor', 'provinces', 'especialidades', 'tipos_clientes', 'fullname']));
            dd($user);
            $user->save;

            $billing_concepts = json_decode($request->billing_user_concepts,true);
            foreach($billing_concepts as $bill) {
                $billing = BillingUserConcepts::findOrFail($bill['id']);
                $billing->update($bill);
            }

            $metadata = [];
            $metadata["action"] = "Actualizado usuario ".$user->name." ".$user->lastname;
            $metadata["ip"] = request()->ip();
            $metadata["access_date"] = date('d-m-Y', time());
            $metadata["access_hours"] = date('G:i:s', time());
            $metadata["browser"] = request()->server('HTTP_USER_AGENT');
            $metadata["users_id"] = auth()->user()->id;
            Trazas::create($metadata);

            return ['code' => 200, 'data' => $user];

        } catch (\Exception $e) {
            return ['code' => 500, 'data' => $e->getMessage()];
        }
    }

    public function delete($id)
    {
        if ($id != 1) {
            $user = User::with(['notifications'])->find($id);
            if ($user->photo_name){
                Storage::disk('users_avatars')->delete($user->photo_name);
            }
            Notification::destroy($user->notifications()->pluck('id'));
            OldsPasswords::where('users_id', $user->id)->delete();
            User::destroy($id);

            $metadata = [];
            $metadata["action"] = "Eliminado usuario ".$user->name." ".$user->lastname;
            $metadata["ip"] = request()->ip();
            $metadata["access_date"] = date('d-m-Y', time());
            $metadata["access_hours"] = date('G:i:s', time());
            $metadata["browser"] = request()->server('HTTP_USER_AGENT');
            $metadata["users_id"] = auth()->user()->id;
            Trazas::create($metadata);

            return ['code' => 200, 'data' => null];
        }
        return ['code' => 401, 'message' => 'Este usuario no puede ser eliminado'];
    }

    public function profile(Request $request)
    {

        if (auth()->user()) {
            $me = User::find(auth()->user()->id);
            if ($me->role === 2) {
                $user = User::with(self::relations)->find($me->id);
            } else {
                $user = User::with(self::relations)->find($me->id);
            };
            return ['code' => 200, 'data' => $user];
        }
        return ['code' => 400, 'data' => 'Debe autenticarse nuevamente'];
    }

    public function active_user(Request $request)
    {

        $valid = validator($request->only('password'), [
            'password' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => 'El campo contraseña es obligatorio.',
            ], 200);
        }

        $pass = OldsPasswords::where('users_id', $request->id)->get();

        if (count($pass) > 0) {
            foreach ($pass as $p) {
                if (Hash::check($request->password, $p->password)) {
                    return response()->json([
                        'error' => 'Esta contraseña ya fue usada previamente por udsted, por favor cree una nueva.',
                    ], 200);
                }
            }
        }

        $user = User::find($request->id);
        if(!isset($user->email_verified_at)) {
            $user->email_verified_at = date('Y-m-d G:i:s', time());
        }
        $user->password = Hash::make($request->password);
        $user->last_time_passwors_change = date('Y-m-d G:i:s', time());
        $user->save();

        $this->renewToken($user->id);

        OldsPasswords::create([
            'users_id' => $user->id,
            'password' => $user->password
        ]);

        $metadata = [];
        $metadata["action"] = "Modificada la contraseña del usuario ".$user->name." ".$user->lastname;
        $metadata["ip"] = request()->ip();
        $metadata["access_date"] = date('d-m-Y', time());
        $metadata["access_hours"] = date('G:i:s', time());
        $metadata["browser"] = request()->server('HTTP_USER_AGENT');
        $metadata["users_id"] = $user->id;
        Trazas::create($metadata);

        return ['code' => 200, 'data' => 'Contraseña modificada correctamente'];
    }

    public function change_password(Request $request)
    {

        $valid = validator($request->all(), [
            'id' => 'required',
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($valid->fails()) {
            return response()->json([
                'error' => 'Formulario incompleto.',
            ], 200);
        }

        $user_password = User::where('id', $request->id)->first();

        if (!Hash::check($request->old_password, $user_password->password)) {
            return response()->json([
                'error' => 'La contraseña antigua es incorrecta.',
            ], 201);
        }

        $pass = OldsPasswords::where('users_id', $request->id)->get();

        if (count($pass) > 0) {
            foreach ($pass as $p) {
                if (Hash::check($request->new_password, $p->password)) {
                    return response()->json([
                        'error' => 'Esta contraseña ya fue usada previamente por udsted, por favor cree una nueva.',
                    ], 201);
                }
            }
        }

        $user = User::find($request->id);
        if(!isset($user->email_verified_at)) {
            return response()->json([
                'message' => 'El usuario no ah sido verificado.',
            ], 401);
        }
        $user->password = Hash::make($request->new_password);
        $user->last_time_passwors_change = date('Y-m-d G:i:s', time());
        $user->save();

        OldsPasswords::create([
            'users_id' => $user->id,
            'password' => $user->password
        ]);

        $metadata = [];
        $metadata["action"] = "El usuario: ".$user->name." ".$user->lastname." ha modificado su contraseña.";
        $metadata["ip"] = request()->ip();
        $metadata["access_date"] = date('d-m-Y', time());
        $metadata["access_hours"] = date('G:i:s', time());
        $metadata["browser"] = request()->server('HTTP_USER_AGENT');
        $metadata["users_id"] = $user->id;
        Trazas::create($metadata);

        return ['code' => 200, 'message' => 'Contraseña modificada correctamente'];
    }

    public function renewToken($user_id)
    {
        $user = User::find($user_id);
        $user->token = time() . rand((int)pow(10, 20), (int)pow(10, 30));
        $user->save();
    }

    public function recover_password(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ( isset($user) ) {
            $metadata = [];
            $metadata["ip"] = request()->ip();
            $metadata["access_time"] = date('d-m-Y \a\ \l\a\s G:i:s', time());
            $metadata["user_agent"] = $request->server('HTTP_USER_AGENT');
            try {
                Mail::to($user->email)->send(new RecoverPassword($user, $metadata));
            } catch (\Exception $e) {
                return ['code' => 400, 'message' => 'El email no pudo ser enviado'];
            }
            return ['code' => 200, 'data' => $user];
        } else {
            return ['code' => 401, 'message' => 'El e-mail '.$request->email.' no está registrado en el sistema.'];
        }
    }

    public function set_password(Request $request)
    {
        try {
            $user = User::where('email', $request->email)->first();
            Mail::to($user->email)->send(new RegistrationUser($user));
        } catch (\Exception $e) {
            return ['code' => 200, 'data' => 'El email no pudo ser enviado'];
        }
        return ['code' => 200, 'data' => $user];
    }

    public function get_user(Request $request)
    {
        $user = User::where('token', $request->token)->first();
        if ($user) {
            return ['code' => 200, 'data' => $user];
        } else {
            return ['code' => 500, 'data' => 'No existe el usuario con esos datos. Por favor, contacte al administrador'];

        }
    }

    public function show($id)
    {
        try {
            $user = User::with(['client'])->where('token', $id)->firstOrFail();
        } catch (\Exception $e) {
            return ['code' => 500, 'data' => 'El usuario solicitado no está disponible en estos momentos. Por favor, contacte al administrador'];
        }
        return ['code' => 200, 'data' => $user];
    }

    public function deactivate(Request $request)
    {
        if (auth()->user()->role < 2) {
            $request->validate([
                'id' => 'required'
            ]);

            try {
                User::where('id', $request->id)->update(['active' => 0]);
            } catch (\Exception $e) {
                return ['code' => 500, 'data' => 'El usuario solicitado no está disponible en estos momentos. Por favor, contacte al administrador'];
            }

            return ['code' => 200, 'data' => true];
        } else {
            return ['code' => 500, 'data' => 'Usted no está autorizado a ejecutar esta acción'];
        }
    }

    public function activate(Request $request)
    {
        if (auth()->user()->role < 1) {
            $request->validate([
                'id' => 'required'
            ]);

            try {
                User::where('id', $request->id)->update(['active' => 1]);
            } catch (\Exception $e) {
                return ['code' => 500, 'data' => 'El usuario solicitado no está disponible en estos momentos. Por favor, contacte al administrador'];
            }
            return ['code' => 200, 'data' => true];
        } else {
            return ['code' => 500, 'data' => 'Usted no está autorizado a ejecutar esta acción'];
        }
    }

    public function newAdmin(Request $request)
    {
        if (User::where('email', $request->email)->exists()) {
            return ['code' => 500, 'data' => 'Ya existe un usuario con ese email'];
        }

        $request->validate([
            'name' => 'max:255',
            'lastname' => 'max:255',
            'email' => 'required|unique:users|email',
        ]);
        try {
            $user = new User();
            $user->name = $request->name;
            $user->password = $request->password ? Hash::make($request->password) : Hash::make('gmoney');
            $user->email = $request->email;
            $user->lastname = $request->lastname;
            $user->role = 1;
            $user->token = time() . rand((int)pow(10, 20), (int)pow(10, 30));
            $user->save();
            $this->recover_password($request);
        } catch (\Exception $e) {
            return ['code' => 500, 'data' => $e->getMessage()];
        }
        return ['code' => 200, 'data' => $user];
    }

    public function gerateRandomPass() {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ()/*-+!@#$%^&?"), 0, 10);
    }
}
