<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityType;
use App\Models\VolunteerTask;
use App\Models\SelectionType;
use App\Models\Team;
use App\Models\Activity;
use App\Models\ActivityAttendees;

class ActivityController extends Controller
{

    public function index(Request $request){

        $start_date = $end_date = $activity_type = $team_id = "";
        $icon = 'fa fa-calendar';

        $team_id = Auth::user()->active_team;

        $activity_types = ActivityType::orderBy('name')->get();
        $team = Team::find($team_id);
        $data = Activity::orderBy('created_at', 'desc');

        $search = $request->search;

        if ($request->has('activity_type') && !empty($request->activity_type)) {
            
            $activity_type = $request->activity_type;

            $data = $data->where('activity_type', $activity_type);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            
            $start_date = date($request->start_date);
            $end_date = date($request->end_date);

            $data = $data->whereBetween('start_date', [$start_date, $end_date]);
        }

        if ($request->has('team_id') && $request->team_id !=='all') {
            
            $data = $data->where('team_id', $team_id);
        }

        // dd($district);

        if (!empty($search)) {
            
            $data = $data->where(function($query) use($search) {
                            $query->orWhere('title', 'LIKE', "%$search%");
                    });
        }

        if(Auth::user()->role_id !== 1)
        {
            $data = $data->where('user_id', Auth::id());
        }

        $data = $data->paginate();

        return view ('activities.index', compact('icon', 'team', 'activity_types', 'data', 'search', 'activity_type', 'team_id', 'start_date', 'end_date'));

    }

     public function show($id){

        $icon = 'fa fa-calendar';

        // $selection_types = SelectionType::where('status', 1)->orderBy('name')->get();
        $data = Activity::find($id);

        $checkOwnerAttend = ActivityAttendees::where('activity_id', $id)
                                        ->where('user_id', Auth::id())
                                        ->first();

         $attendeeCount = ActivityAttendees::where('activity_id', $id)
                                        ->where('status', 'attending')
                                        ->count();

        $nonattendeeCount = ActivityAttendees::where('activity_id', $id)
                                        ->where('status', 'not-attending')
                                        ->count();

        if($checkOwnerAttend)
        {
            $ownerStatus = $checkOwnerAttend->status;
        }
        else
        {
            $ownerStatus = false;
        }

        return view ('activities.show', compact('icon', 'data', 'ownerStatus', 'attendeeCount', 'nonattendeeCount'));

    }

    public function attending($id){

        $icon = 'fa fa-calendar';

        // $selection_types = SelectionType::where('status', 1)->orderBy('name')->get();
        $data = Activity::find($id);

        ActivityAttendees::where('activity_id', $id)
                                ->where('user_id', Auth::id())
                                ->delete();

        ActivityAttendees::create([
                                    'user_id' => Auth::id(),
                                    'activity_id' => $id,
                                    'team_id' => $data->team_id,
                                    'status' => 'attending',
                                ]);

        return redirect()->route('activity.show', $id)->with('success','Status updated successfully');

    }

    public function notAttending($id){

        $icon = 'fa fa-calendar';

        // $selection_types = SelectionType::where('status', 1)->orderBy('name')->get();
        $data = Activity::find($id);

        ActivityAttendees::where('activity_id', $id)
                                ->where('user_id', Auth::id())
                                ->delete();

        ActivityAttendees::create([
                                    'user_id' => Auth::id(),
                                    'activity_id' => $id,
                                    'team_id' => $data->team_id,
                                    'status' => 'not-attending',
                                ]);

        return redirect()->route('activity.show', $id)->with('success','Status updated successfully');

    }


    public function create(){

        $icon = 'fa fa-calendar';

        $selection_types = SelectionType::where('status', 1)->orderBy('name')->get();
        $activity_types = ActivityType::where('status', 1)->orderBy('name')->get();

        return view ('activities.create', compact('icon', 'activity_types', 'selection_types'));

    }

    public function store(Request $request){
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'activity_type' => 'required',
            'start_date' => 'required',
            'start_time' => 'required',
            'end_time' => 'required'
        ]);

        $end_date = $activity_repeated = $repeat_weekly_up_to = $register_start_date = $register_start_time = null;

        $activity_end_another_date = $repeat_activity = $coach_included_to_max_participants = $is_register_start_date = $waiting_list = $hide_unsubscribe_btn = $hide_register_status = $with_driving = $send_notification = $send_email = $with_volunteer_tasks = '0';

        $date = date('Y-m-d h:m:s');

        if($request->has('activity_end_another_date') && $request->activity_end_another_date === '1')
        {
            $activity_end_another_date = $request->activity_end_another_date;
            $end_date = $request->end_date;
        }

        if($request->has('repeat_activity') && $request->repeat_activity === '1')
        {
            $repeat_activity = $request->repeat_activity;
            $activity_repeated = $request->activity_repeated;
            $repeat_weekly_up_to = $request->repeat_weekly_up_to;
        }

        if($request->has('coach_included_to_max_participants') && $request->coach_included_to_max_participants === '1')
        {
            $coach_included_to_max_participants = $request->coach_included_to_max_participants;
        }

        if($request->has('is_register_start_date') && $request->is_register_start_date === '1')
        {
            $is_register_start_date = $request->is_register_start_date;
            $register_start_date = $request->register_start_date;
            $register_start_time = $request->register_start_time;
        }

        if($request->has('waiting_list') && $request->waiting_list === '1')
        {
            $waiting_list = $request->waiting_list;
        }
        
        if($request->has('hide_unsubscribe_btn') && $request->hide_unsubscribe_btn === '1')
        {
            $hide_unsubscribe_btn = $request->hide_unsubscribe_btn;
        }

        if($request->has('hide_register_status') && $request->hide_register_status === '1')
        {
            $hide_register_status = $request->hide_register_status;
        }

        if($request->has('with_driving') && $request->with_driving === '1')
        {
            $with_driving = $request->with_driving;
        }

        if($request->has('send_notification') && $request->send_notification === '1')
        {
            $send_notification = $request->send_notification;
        }

        if($request->has('send_email') && $request->send_email === '1')
        {
            $send_email = $request->send_email;
        }

        if($request->has('with_volunteer_tasks') && $request->with_volunteer_tasks === '1')
        {
            $with_volunteer_tasks = $request->with_volunteer_tasks;
        }

        $data = array(
                    'user_id' => Auth::id(),
                    'team_id' => Auth::user()->active_team, 
                    'title' => $request->title,  
                    'activity_type' => $request->activity_type,
                    'start_date' => $request->start_date,
                    'starting_time' => $request->starting_time,
                    'end_time' => $request->end_time,
                    'activity_end_another_date' => $activity_end_another_date,
                    'end_date' => $end_date,
                    'repeat_activity' => $repeat_activity,
                    'activity_repeated' => $activity_repeated,
                    'repeat_weekly_up_to' => $repeat_weekly_up_to,
                    'comments' => $request->comments,
                    'place' => $request->place,
                    'meeting_place' => $request->meeting_place,
                    'meeting_time' => $request->meeting_time,
                    'selection_type' => $request->selection_type,
                    'coach_included_to_max_participants' => $coach_included_to_max_participants,
                    'register_end_date' => $request->register_end_date,
                    'register_end_time' => $request->register_end_time,
                    'is_register_start_date' => $is_register_start_date,
                    'register_start_date' => $register_start_date,
                    'register_start_time' => $register_start_time,
                    'waiting_list' => $waiting_list,
                    'hide_unsubscribe_btn' => $hide_unsubscribe_btn,
                    'hide_register_status' => $hide_register_status,
                    'reminder_5_days_before_activity' => $request->reminder_5_days_before_activity,
                    'reminder_2_days_before_activity' => $request->reminder_2_days_before_activity,
                    'with_driving' => $with_driving,
                    'send_notification' => $send_notification,
                    'with_volunteer_tasks' => $with_volunteer_tasks,
                    'send_email' => $send_email,
                    'created_at' => $date
                );

        $id = Activity::create($data);
        // dd($id);
        if ($id) {

            if($with_volunteer_tasks === '1')
            {
                $volunteer_task1 = $request->volunteer_task1;
                $volunteer_task2 = $request->volunteer_task2;
                $volunteer_task3 = $request->volunteer_task3;

                if(!empty($volunteer_task1))
                {
                    VolunteerTask::create(['activity_id' => $id->id, 'name' => $volunteer_task1, 'created_at' => $date]);
                }

                if(!empty($volunteer_task2))
                {
                    VolunteerTask::create(['activity_id' => $id->id, 'name' => $volunteer_task2, 'created_at' => $date]);
                }

                if(!empty($volunteer_task3))
                {
                    VolunteerTask::create(['activity_id' => $id->id, 'name' => $volunteer_task3, 'created_at' => $date]);
                }
            }

            
            return redirect()->route('activities.index')->with('success','Activity added successfully');
        }
         
       return back()->with('error','Some Error Occured');
    }

    public function destroy($id){
        $activity = Activity::find($id);

        if(Auth::id() === $activity->user_id || Auth::user()->role_id == 1)
        {
            Activity::find($id)->delete();
            
            return redirect()->route('activities.index')->with('success','Activity deleted successfully');
        }

        return redirect()->route('activities.index')->with('error','You not allowed o delete this activity');

    }
}
