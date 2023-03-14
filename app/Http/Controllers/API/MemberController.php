<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Country;
use App\Models\Region;
use Validator;
use Mail;

class MemberController extends Controller
{
    public function register(Request $request){

        $validator = Validator::make($request->all(), [
            'region' => 'required',
            'region_country' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'street' => 'required',
            'postal_number' => 'required',
            'country' => 'required',
            'member_of_golf_club' => 'required',
            'golf_club_name' => 'required_if:member_of_golf_club,1',
            'city' => 'required',
            'pga_status' => 'required',
            'pga_country' => 'required_if:pga_status,1',
            'tour_membership' => 'required',
            'member_category' => 'required',
            'gender' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'comment' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required'
        ]);

        if ($validator->fails()) { 

          return response()->json(["status" => 400, "success" => false, "message" => $validator->errors()->first(), "data" => $request->all()]);
        }

        $pass = Hash::make($request->password);

        $date = date('Y-m-d h:m:s');

        $dob = $request->year . "-" . $request->month . "-" . $request->day;

        $dob = strtotime($dob);

        $dob = date('Y-m-d', $dob);  

        $token = bin2hex(random_bytes(32));

        $data = array(
                        'region_id' =>  $request->region,
                        'region_country' =>  $request->region_country,
                        'first_name' =>  $request->first_name,
                        'last_name' =>  $request->last_name,
                        'email' =>  $request->email,
                        'email_verified_token' =>  $token,
                        'phone' => (string)$request->phone,
                        'password' =>  $pass,
                        'dob' =>  $dob,
                        'member_category' =>  $request->member_category,
                        'country' =>  $request->country,
                        'member_of_golf_club' =>  $request->member_of_golf_club,
                        'pga_status' =>  $request->pga_status,
                        'tour_membership' =>  $request->tour_membership,
                        'golf_club_name' =>  $request->member_of_golf_club == "1" ?$request->golf_club_name : null,
                        'pga_country' =>  $request->pga_status == "1" ? $request->pga_country : null,
                        'gender' =>  $request->gender,
                        'city' =>  $request->city,
                        'postal_code' =>  $request->postal_number,
                        'street' =>  $request->street,
                        'comment' =>  $request->comment,
                        'created_at' => $date
                    );
        // dd($data);

        $user = User::create($data);

        if ($user) {

            $link  = url("/email-verify/" . $token);

            $data = array('name'=>$user->first_name ." ". $user->last_name, 'link' => $link);
            Mail::send('email.verify_email', $data, function($message) use($user) {
             $message->to($user->email, 'Tournament Players Team')->subject
                ('Verify Your Email Address');
             $message->from('tp@logicaldottech.com','Tournament Players Team');
            });

            return response()->json(["status" => 200, 'success' => true, 'message' => "Member added successfully, please check your email for verify your email address"]);
        }
      
      return response()->json(["status" => 400, 'success' => false, 'message' => "Some error occured"]);

    }

    public function getCountries(Request $request){

        $countries = Country::get();

        return response()->json(["status" => 200, 'success' => true, 'data' => $countries, 'message' => "Contries get successfully"]);

    }

    public function getRegions(Request $request){

        $regions = Region::where('status',1)->orderBy('region_name', 'asc')->get();

        return response()->json(["status" => 200, 'success' => true, 'data' => $regions, 'message' => "Contries get successfully"]);

    }
}
