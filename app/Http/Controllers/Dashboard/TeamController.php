<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Team;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class TeamController extends Controller
{

    public function index(){

        $data = Team::where('status', 1)->orderBy('team_name', 'asc');

        if(Auth::user()->role_id != 1)
        {
            $data = $data->where('created_by', Auth::id());
        }

        $data = $data->paginate();
        $icon = 'fas fa-users';

    	return view('teams.index', compact('data', 'icon'));
    }

    public function create(){

        $regions = Region::where('status', 1)->orderBy('region_name', 'asc')->get();

        $icon = 'fas fa-users';
        
        return view('teams.create', compact('regions', 'icon'));
    }

    public function store(Request $request){

            
        $this->validate($request, [
          'team' => 'required',
          'region' => 'required'
       ]);

        $date = date('Y-m-d h:m:s');

        $insert = array(
                    'team_name' => $request->team,
                    'region_id' => $request->region,
                    'created_by' => Auth::id(),
                    'created_at' => $date
                );

        Team::create($insert);

        return redirect()->route('teams.index')->with('success','Team added successfully');

    }

    public function edit($id){
            
        $icon = 'fas fa-heartbeat';

        $regions = Region::where('status', 1)->orderBy('region_name', 'asc')->get();

        $data = Team::find($id);

        return view('teams.create', compact('regions', 'icon', 'data'));
        
    }

    public function update(Request $request, $id){

            $this->validate($request, [
              'team' => 'required',
              'region' => 'required'
           ]);

            $update = array(
                        'team_name' => $request->team,
                        'region_id' => $request->region,
                    );

            Team::where('id', $id)->update($update);

         return redirect(url("/teams"))->with('success','Team updated successfully');
    }

    public function destroy($id){

        Team::find($id)->delete();

        return back()->with('success', 'Team deleted successfully');
        
    }
}
