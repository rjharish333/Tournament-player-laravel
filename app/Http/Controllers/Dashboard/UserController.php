<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Team;
use App\Models\Region;
use App\Models\Role;
use App\Models\Country;
use App\Models\Sport;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    private $team;

    public function __construct()
    { 

        $this->middleware(function ($request, $next) {

            $this->team = Auth::user()->activeTeam ? Auth::user()->activeTeam->team_name : "";
            $this->team_id = Auth::user()->active_team;

            return $next($request);
        });
    }

    public function index(Request $request){

    	$region = $search = "";

        $team = $this->team;
        $team_id = $this->team_id;

        $regions = $this->getRegions();

    	$users = User::with('region', 'team', 'getCountry')
                    ->where('role_id', '!=', 1)
                    ->orderBy('users.created_at', 'desc');
        if($team_id)
        {
            $users = $users->where('team_id', $team_id);
        }

        if(Auth::user()->role_id != 1)
        {
            $users = $users->where('created_by', Auth::id());
        }

        $search = $request->search;

        if ($request->has('region') && !empty($request->region)) {
        	
        	$region = $request->region;

        	$users = $users->where('region_id', $region);
        }

        // dd($district);

        if (!empty($search)) {
            
            $users = $users->where(function($query) use($search) {
                            $query->orWhere('first_name', 'LIKE', "%$search%");
                            $query->orWhere('last_name', 'LIKE', "%$search%");
                            $query->orWhere('email', 'LIKE', "%$search%");
                            $query->orWhere('phone', 'LIKE', "%$search%");
                            $query->orWhere('city', 'LIKE', "%$search%");
                    });
        }
            
        $users = $users->paginate();

     	return view('users.index', compact('users', 'regions', 'team', 'region', 'search'));

     }//end index function

     public function create(){

     	$title = "Add Member";

     	$team = $this->team;
        $regions = $this->getRegions();

        $countries = Country::get();

     	return view('users.create', compact('title', 'team', 'regions', 'countries'));

     }//end create function

     public function store(Request $request){
        // dd($request->all());
     	$request->validate([
            'region' => 'required',
            'region_country' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6',
            'dob' => 'required',
            'member_category' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'member_of_golf_club' => 'required',
            'golf_club_name' => 'required_if:member_of_golf_club,1',
            'city' => 'required',
            'pga_status' => 'required',
            'pga_country' => 'required_if:pga_status,1',
            'tour_membership' => 'required',
            'postal_code' => 'required',
            'street' => 'required'
        ]);

        $pass = Hash::make($request->password);

     	$date = date('Y-m-d h:m:s');

        $data = array(
                        'team_id' =>  Auth::user()->active_team,
                        'region_id' =>  $request->region,
                        'region_country' =>  $request->region_country,
                        'first_name' =>  $request->first_name,
                        'last_name' =>  $request->last_name,
                        'email' =>  $request->email,
                        'phone' =>  $request->phone,
                        'dob' =>  $request->dob,
                        'password' =>  $pass,
                        'pga_status' =>  $request->pga_status,
                        'pga_country' =>  $request->pga_status == "1" ? $request->pga_country : null,
                        'tour_membership' =>  $request->tour_membership,
                        'member_category' =>  $request->member_category,
                        'gender' =>  $request->gender,
                        'country' =>  $request->country,
                        'member_of_golf_club' =>  $request->member_of_golf_club,
                        'golf_club_name' =>  $request->member_of_golf_club == "1" ?$request->golf_club_name : null,
                        'city' =>  $request->city,
                        'postal_code' =>  $request->postal_code,
                        'street' =>  $request->street,
                        'comment' =>  $request->comment??'',
                        'created_by' =>  Auth::id(),
                        'created_at' => $date
                    );
        // dd($data);

        $id = User::create($data);

        if ($id) {
        	
        	return redirect()->route('members.index')->with('success','Member added successfully');
        }
         
       return back()->with('error','Some Error Occured');

     }//end store function

     public function edit($id){

        $title = "Update Member";

        $data = User::find($id);
        $team = $this->team;
        $regions = $this->getRegions();
        $countries = Country::get();

        return view('users.create', compact('title', 'team', 'regions', 'data', 'countries'));

     }//end edit function

     public function update(Request $request, $id){

     	$request->validate([
            'region' => 'required',
            'region_country' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            // 'phone' => 'required',
            'email' => 'required|email|unique:users,email,'. $id.',id',
            'dob' => 'required',
            'member_category' => 'required',
            'gender' => 'required',
            'country' => 'required',
            'member_of_golf_club' => 'required',
            'golf_club_name' => 'required_if:member_of_golf_club,1',
            'city' => 'required',
            'pga_status' => 'required',
            'pga_country' => 'required_if:pga_status,1',
            'tour_membership' => 'required',
            'postal_code' => 'required',
            'street' => 'required'
        ]);

        $data = array(
                        'team_id' =>  Auth::user()->active_team,
                        'region_id' =>  $request->region,
                        'region_country' =>  $request->region_country,
                        'first_name' =>  $request->first_name,
                        'last_name' =>  $request->last_name,
                        'email' =>  $request->email,
                        // 'phone' =>  $request->phone,
                        'dob' =>  $request->dob,
                        'member_category' =>  $request->member_category,
                        'gender' =>  $request->gender,
                        'pga_status' =>  $request->pga_status,
                        'pga_country' =>  $request->pga_status == "1" ? $request->pga_country : null,
                        'tour_membership' =>  $request->tour_membership,
                        'country' =>  $request->country,
                        'member_of_golf_club' =>  $request->member_of_golf_club,
                        'golf_club_name' =>  $request->member_of_golf_club == "1" ?$request->golf_club_name : null,
                        'city' =>  $request->city,
                        'postal_code' =>  $request->postal_code,
                        'comment' =>  $request->comment??'',
                        'street' =>  $request->street,
                        'created_by' =>  Auth::id()
                    );

        User::find($id)->update($data);
    	
    	return redirect()->route('members.index')->with('success','Member updated successfully');

     }//end update function

     public function destroy($id){

     	$dlt = DB::table('users')->where('id', $id)
                    ->delete();

        return redirect()->route('members.index')->with('success','Member deleted successfully');

     }//end function destroy

     public function changeStatus($id){

     	$user = DB::table('users')
     				->where('fld_uid', $id)
     				->first();

     	if ($user->status === 1) {
     		
     		$update = DB::table('users')->where('fld_uid', $id)->update(['status' => 0]);
     	}else{

     		$update = DB::table('users')->where('fld_uid', $id)->update(['status' => 1]);
     	}

        return back()->with('success','Status Changed Successfully');

     }//end function changeStatus

     public function changePassword(Request $request){
      	
      	$validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

    	if ($validator->fails())
	    {
	        return response()->json(['status' => 400, 'success' => false, 'message'=>$validator->errors()]);
	    }

	    $user = User::find($request->user_id);

	    $user->fld_password = Hash::make($request->password);

	    $user->save();

	    return response()->json(['status' => 200, 'success' => true, 'message' => 'Password Changed Successfully']);
    }// end changePassword

    public function import(Request $request){

      $date = date('Y-m-d h:m:s');

      $file = $request->users_csv;

      $users = $this->csvToArray($file);

      $csvInsert = array();

      $pass = Hash::make(123456);

      // dd($users);
      foreach ($users as $key => $value) {
          
        $state = strtoupper($value['state']);
        $district = ucfirst($value['district']);

        // check reord exist for given email & mobile number
        $check = User::orwhere('fld_email', $value['email'])
                    ->orwhere('fld_contact', $value['mobile'])
                    ->count();

        if($check > 0)
        {
            continue;
        }

        // check state exist 
        $stateData = $this->getStateByName($state);

        if(!$stateData)
        {
            $stateData = State::create(['fld_state_name' => $state, 'created_at' => $date]);
        }

        // check state exist 
        $distData = $this->getDistrictByName($district);

        if(!$distData)
        {
            District::create([
                    'fld_state_id' => $stateData->fld_sid,
                    'fld_state_name' => $stateData->fld_state_name,
                    'fld_district_name' => $district,
                    'created_at' => $date
                ]);
        }

          $insert = array(
            'fld_username' => $value['username'],
            'fld_fname' =>  $value['first_name'],
            'fld_lname' =>  $value['last_name'],
            'fld_email' =>  $value['email'],
            'fld_contact' =>  $value['mobile'],
            'fld_state_id' =>  $stateData->fld_sid,
            'fld_password' =>  $pass,
            'fld_role' =>  7,
            'fld_bill_upload' =>  0,
            'fld_district' =>  $district,
            'created_at' => $date
          );

            User::create($insert);
        }
          
        return back()->with('success','Users inserted successfully');

    }//end function

    public function csvToArray($filename = '', $delimiter = ',')
    {
        if (!file_exists($filename) || !is_readable($filename))
            return false;

        $header = null;
        $data = array();
        if (($handle = fopen($filename, 'r')) !== false)
        {
            while (($row = fgetcsv($handle, 1000, $delimiter)) !== false)
            {
                if (!$header)
                    $header = $row;
                else
                    $data[] = array_combine($header, $row);
            }
            fclose($handle);
        }

        return $data;
    }//end function

    private function getRegions(){

        $regions = Region::where("status", 1)
                    ->get();

        return $regions;
    }

	private function getTeams(){

		$teams = Team::where("status", 1);

        if(Auth::user()->role_id != 1)
        {
            $teams = $teams->where('created_by', Auth::id());
        }

        $teams = $teams->get();

        return $teams;
	}

	private function getRoles(){

		$roles = Role::where("status", 1)
        			->get();

        return $roles;
	}
}
