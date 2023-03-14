<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sport;
use Illuminate\Support\Facades\Auth;

class SportController extends Controller
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

        $data = Sport::where('status', 1)->orderBy('sport_name', 'asc')->paginate();

        $icon = 'fas fa-futbol';

        return view('sports.index', compact('data', 'icon'));
    }

    public function create(){

        $icon = 'fas fa-futbol';
        
        return view('sports.create', compact('icon'));
    }

    public function store(Request $request){

            
        $this->validate($request, [
          'sport' => 'required'
       ]);

        $date = date('Y-m-d h:m:s');

        $insert = array(
                    'sport_name' => strtolower($request->sport),
                    'created_at' => $date
                );

        Sport::create($insert);

        return redirect()->route('sports.index')->with('success','Sport added successfully');

    }

    public function edit($id){
            
        $icon = 'fas fa-futbol';

        $data = Sport::find($id);

        return view('sports.create', compact('icon', 'data'));
        
    }

    public function update(Request $request, $id){

            $this->validate($request, [
              'sport' => 'required',
           ]);

            $update = array(
                        'sport_name' => strtolower($request->sport),
                    );

            Sport::where('id', $id)->update($update);

         return redirect(url("/sports"))->with('success','Sport updated successfully');
    }

    public function destroy($id){

        Sport::find($id)->delete();

        return back()->with('success', 'Sport deleted successfully');
        
    }
}
