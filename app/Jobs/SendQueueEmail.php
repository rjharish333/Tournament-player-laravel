<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use App\Models\User;

class SendQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $input['subject'] = $this->details['subject'];
        $input['content'] = $this->details['message'];
        $email_send_type = $this->details['email_send_type'];
        $team = $this->details['team'];

        if($email_send_type === 'all')
        {
            $data = User::all();
        }
        else
        {
            $data = User::where('team_id', $team)->get();
        }


        foreach ($data as $key => $value) {
            $input['email'] = $value->email;
            $input['name'] = $value->first_name;
            // dd($input);
            \Mail::send('email.template', $input, function($message) use($input){
                $message->to($input['email'], $input['name'])
                    ->subject($input['subject']);
            });
        }
    }
}
