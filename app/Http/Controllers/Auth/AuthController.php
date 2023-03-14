<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use DB;

class AuthController extends Controller
{
    public function authenticate(Request $request)
      {

          $validator  = $request->validate([
            'username'         => 'required|min:3',
            'password'      => 'required|min:6'
          ]);

          $username = $request->username;
          $password = (int)$request->password;

          if($request->has('checkbox')){
            $remember = true;
           }else{
            $remember = false;
           }

           $user = User::where('fld_username', '=', $username)
                        ->where('fld_role', 4)
                        ->first();
           // check credentials
          if ($user) {
             
             $auth = Hash::check($password, trim($user->fld_password));

          }else{

              return response()->json(["status" => 400, "success" => false, "message" => 'Username is not exist', "data" => []]);

          }

          if ($auth) {
              // Authentication passed...

      		// Auth::loginUsingId($user->fld_uid);

      		$token = Str::random(32);

          $update = [
                      'fld_token' => $token, 
                      'fld_updated_at' => DB::raw('CURRENT_TIMESTAMP'),
                      'fld_dmf' => $request->fld_dmf,
                      'fld_dmodel' => $request->fld_dmodel,
                      'fld_dosver' => $request->fld_dosver
                    ];

	    	  User::where('fld_uid', $user->fld_uid)->update($update);

      		$data = array(
      					'user_id' => trim($user->fld_uid),
      					'username' => trim($user->fld_username),
      					'first_name' => trim($user->fld_fname),
                'last_name' => trim($user->fld_lname),
      					'bill_upload' => trim($user->fld_bill_upload),
                'token' => $token
      					);

            return response()->json(["status" => 200, "success" => true, "message" => 'Logged in successfull', "data" => $data]);

          } else {
            
            return response()->json(["status" => 400, "success" => false, "message" => 'Password is incorrect', "data" => $auth]);
          }

      }

      public function authCheck(Request $request){

        $user_id = $request->user_id;

        $user = User::find($user_id);

        if($user->fld_status === 0){

         return response()->json(["status" => 400, "success" => false, "message" => 'User Not Found', "data" => ['user_id' => $user_id]]); 
        }
        	
        return response()->json(["status" => 200, "success" => true, "message" => 'User Found successfull', "data" => ['user_id' => $user_id]]);
        
      }

      public function changePassword(Request $request){

        $user_id = $request->user_id;
        $password = $request->password;
        $confirm_password = $request->password_confirmation;

        if ($password === $confirm_password) {
          
          $user = User::find($user_id);

          $user->fld_password = Hash::make($password);

          $user->save();

          return response()->json(["status" => 200, "success" => true, "message" => 'Password Changed', "data" => ['user_id' => $user_id]]);
        }
          
        return response()->json(["status" => 400, "success" => false, "message" => 'Password not match', "data" => ['user_id' => $user_id]]);
      }

      public function logout(){

        $user = User::find($user_id);

        $user->fld_token = null;

        $user->save();

        return response()->json(["status" => 200, "success" => true, "message" => 'Logged out successfull', "data" => []]);
      }
}
