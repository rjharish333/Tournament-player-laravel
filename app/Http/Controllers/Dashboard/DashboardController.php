<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;

class DashboardController extends Controller
{
    public function index(){

        $teams = $this->getTeams();

        $user = Auth::user();

    	return view ('dashboard.dashboard', compact('teams', 'user'));

    }

    public function updateActiveTeam(Request $request){

            
        $this->validate($request, [
          'team' => 'required'
       ]);

        $update = array(
                    'active_team' => $request->team === 'all' ? null : strtolower($request->team)
                );

        User::find(Auth::id())->update($update);

        return redirect()->route('regions.index')->with('success','Team activated successfully');

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

  
}
