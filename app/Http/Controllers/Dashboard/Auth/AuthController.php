<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Mail;

class AuthController extends Controller
{
    public function login(){

      if(Auth::check()){

        return redirect()->route('dashboard');
      }
    	return view('login');
    }

    public function authenticate(Request $request)
      {

        // return redirect()->route('dashboard');

          $validator  = $request->validate([
            'email'         => 'required|email',
            'password'      => 'required|min:6'
          ]);

          $email = $request->email;
          $password = $request->password;

          if($request->has('checkbox')){
            $remember = true;
           }else{
            $remember = false;
           }

           $user = User::where('email', '=', $email)
                        ->whereIn('role_id', [1,2])
                        ->first();
            // dd($user);

           // check credentials
          if ($user) {

             if(!$user->email_verified_at)
              {
                 return response()->redirectTo('email-verification')->with('error','Your email is not verified, please verify your email address to access your dashboard');
              }

              if($user->payment_status == 0)
              {

                $token = bin2hex(random_bytes(32));
                $user->stripe_token = $token;
                $user->save();

                $link  = url("/payment/" . $token);

                $data = array('name'=>$user->first_name ." ". $user->last_name, 'link' => $link);
                Mail::send('email.stripe_email', $data, function($message) use($user) {
                   $message->to($user->email, 'Tournament Players Team')->subject
                      ('Complete Your Payment');
                   $message->from('tp@logicaldottech.com','Tournament Players Team');
                });
                 return response()->redirectTo($link)->with('success','We have sent you a payment link, please complete the payment to complete your registration process.');
              }
             
             $auth = Hash::check($password, trim($user->password));

          }else{

              return back()->with('error','Email is wrong');

          }

          if ($auth) {
             
             // Authentication passed...

      		Auth::loginUsingId($user->id);

           return redirect()->route('dashboard');

          } else {
            
            return back()->with('error','Password is wrong');
          }


      }// end function

      public function emailVerify(){

        return view('email_verify');
      }

      public function postEmailVerify(Request $request){
      
        $validator  = $request->validate([
                       'email'         => 'required|email',
                    ]);

        $user = User::where('email', '=', $request->email)
                        ->whereIn('role_id', [1,2])
                        ->first();

        if ($user) {

          if($user->email_verified_at){
            return response()->redirectTo('login')->with('error','Your email is already verified, please login to access your dashboard');
          }

          $token = bin2hex(random_bytes(32));
          $user->email_verified_token = $token;
          $user->save();

          $link  = url("/email-verify/" . $token);

          $data = array('name'=>$user->first_name ." ". $user->last_name, 'link' => $link);
          Mail::send('email.verify_email', $data, function($message) use($user) {
             $message->to($user->email, 'Tournament Players Team')->subject
                ('Verify Your Email Address');
             $message->from('tp@logicaldottech.com','Tournament Players Team');
          });

          return back()->with('success', 'We sent you verifycatiom email link. please check your email and verify your email address');

        }

        return back()->with('error', 'Email not found');
      }

      public function tokenEmailVerify($token){

        $user = User::where('email_verified_token', '=', $token)
                        ->first();

        if($user){

          $date = date('Y-m-d h:m:s');

          $user->email_verified_token = null;
          $user->email_verified_at = $date;
          $user->save();

          return response()->redirectTo('login')->with('success','Your email is verified successfully please login to access your dashboard');
        }

        return response()->redirectTo('login')->with('error','Token is invalid');

      }

    public function changePassword(){
      
    	return view('password.change_password');
    }

    public function postChangePassword(Request $request){
      
    	$validator  = $request->validate([
                    'password' => 'required|string|min:6|confirmed',
                    'password_confirmation' => 'required',
                  ]);

	    $user = Auth::user();

	    $user->password = Hash::make($request->password);

	    $user->save();

	    return back()->with('success', 'Password successfully changed!');
    }

	public function logout(){

	Auth::logout();

	return redirect()->route('login');
	   
	}
}
