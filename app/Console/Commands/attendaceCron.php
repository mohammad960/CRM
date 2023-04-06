<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\attendance;
use App\Models\notification;
use App\Models\employee;
use App\Models\user;
class attendaceCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attendace:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
		$now=\Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d", time()));
		$today = new \Carbon\Carbon();
		if($today->dayOfWeek == \Carbon\Carbon::FRIDAY)
		{
			return 0;
		}
		$employees=employee::all();
		foreach($employees as $e){
			$attendaces=attendance::where('date_day',$now)->where('employee_id',$e->id)->get();
			if(count($attendaces)==0){
						$notification=new notification;
                        $user=user::find($e->user_id);
						if($user->role_id != "1"){
							$notification->text=$e->first_name." ".$e->last_name." did not attend untill now (".$now.")";
							$notification->type="tech";
							$notification->link="/";
							$notification->save();
						}
			}
		}
        return 0;
    }
}
