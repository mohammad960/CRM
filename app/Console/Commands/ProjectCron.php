<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\project;
use App\Models\notification;
class ProjectCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'project:cron';

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
		 $projects=project::where('status','!=','finished')->get();
		 foreach ($projects as $p){
			$dateTo=\Carbon\Carbon::createFromFormat('Y-m-d',$p->end_date);
			$now=\Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d", time()));
			$diff_now=$dateTo->diffInDays($now);
			\Log::info($diff_now);
			 if($diff_now<=3){
				       foreach($p->employees as $e){
				 		$notification=new notification;
						$notification->user_id=$e->id;
						$notification->text="The deadline of (".$p->project_name.") project is ".$diff_now." days ahead";
						$notification->type="tech";
						$notification->link="/";
						$notification->save();
					   }
			 }
		 } 
        return 0;
    }
}
