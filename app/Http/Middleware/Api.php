<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Api
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

//        if ($request->server('HTTP_ACCESS_KEY') !== null) {
//            $api_key = "Bearer iowl3HM3OPNYPdk6H497w1OEGbWxVauua6akOJib";
//            if ($request->server('HTTP_ACCESS_KEY') != $api_key) {
//                return response()->json([
//                    'status' => 401,
//                    'message' => "Unauthorized, the api key provided is wrong.",
//                ], 401);
//            } else {
                return $next($request);
//            }
//        } else {
//            return response()->json([
//                'status' => 401,
//                'message' => "Unauthorized, you don't have access to this server.",
//            ], 401);
//        }
    }
}
