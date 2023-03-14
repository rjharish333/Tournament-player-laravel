<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Region;
use Illuminate\Support\Facades\Auth;

class RegionController extends Controller
{
    private $user;

    public function __construct()
    { 

        $this->middleware(function ($request, $next) {

            $this->user = Auth::user();

            if($this->user->role_id === 1){
               
               return $next($request);
            }
            redirect()->route('dashboard')->send();
        });
    }
    public function index(){

        $data = Region::where('status', 1)->orderBy('region_name', 'asc')->paginate();

        $icon = 'fas fa-globe-americas';

        return view('regions.index', compact('data', 'icon'));
    }

    public function create(){

        $icon = 'fas fa-globe-americas';
        
        return view('regions.create', compact('icon'));
    }

    public function store(Request $request){

            
        $this->validate($request, [
          'region' => 'required'
       ]);

        $date = date('Y-m-d h:m:s');

        $insert = array(
                    'region_name' => strtolower($request->region),
                    'created_at' => $date
                );

        Region::create($insert);

        return redirect()->route('regions.index')->with('success','Region added successfully');

    }

    public function edit($id){
            
        $icon = 'fas fa-globe-americas';

        $data = Region::find($id);

        return view('regions.create', compact('icon', 'data'));
        
    }

    public function update(Request $request, $id){

            $this->validate($request, [
              'region' => 'required',
           ]);

            $update = array(
                        'region_name' => strtolower($request->region),
                    );

            Region::where('id', $id)->update($update);

         return redirect(url("/regions"))->with('success','Region updated successfully');
    }

    public function destroy($id){

        Region::find($id)->delete();

        return back()->with('success', 'Region deleted successfully');
        
    }
}
