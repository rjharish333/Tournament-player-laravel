<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class tokenCheckMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('token');
        $user_id = $request->user_id;

        // if (!$user_id) {
            
        //     return response()->json(["status" => 400, 'success' => false, 'message' => "User ID not found", 'login_status' => 0]);
        // }

        if ($token) {

            $user = User::where('fld_token', $token)
                        ->whereIn('fld_role', [1,4])
                        ->first();

            if ($user) {

                return $next($request);
            }

            return response()->json(["status" => 400, 'success' => false, 'message' => "Token mismatch, user is not logged in", 'login_status' => 0]);
        }

        return response()->json(["status" => 400, 'success' => false, 'message' => "Token not found", 'login_status' => 0]);
    }
}
