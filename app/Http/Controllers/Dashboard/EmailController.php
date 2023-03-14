<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function index(){

        $teams = $this->getTeams();

        $user = Auth::user();

        $icon = "fa fa-envolope";

        return view ('send_emails.index', compact('teams', 'user', 'icon'));

    }

    public function sendEmail(Request $request)
    {

        // dd($request->all());
        $request->validate([
            'email_send_type' => 'required',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $details = [
            'email_send_type' => $request->email_send_type,
            'team' => $request->team??0,
            'subject' => $request->subject,
            'message' => $request->message,
        ];
        
        $job = (new \App\Jobs\SendQueueEmail($details))
                ->delay(now()->addSeconds(2)); 

        dispatch($job);

        return back()->with('success', 'Email send successfully');
    }

    private function getTeams(){

        $teams = Team::where("status", 1);

        if(Auth::user()->role_id !== 1)
        {
            $teams = $teams->where('created_by', Auth::id());
        }

        $teams = $teams->get();

        return $teams;
    }
}
