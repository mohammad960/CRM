<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\project;
use App\Models\client;
use App\Models\user;
use App\Models\currency;
use App\Models\position;
use App\Models\department;
use App\Models\salary;
use Auth;
use Carbon;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		
        return view('home');
    }
	public function responsibilities()
    {
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$projects=[];
		foreach($employee->projects as $p){
			$info=DB::select("select * from employee_project where project_id= ".$p->id." and employee_id =".$employee->id);
			if($info[0]->enable==1){
			$dateFrom=\Carbon\Carbon::createFromFormat('Y-m-d',$p->start_date);
			$dateTo=\Carbon\Carbon::createFromFormat('Y-m-d',$p->end_date);
			$now=\Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d", time()));
			$p->style="success";
			if($dateTo > $now){
				$diff=$dateFrom->diffInDays($dateTo);
				$diff_now=$dateFrom->diffInDays($now);
				$p->remaining=($diff_now/$diff)*100;
				if(($diff_now/$diff)*100 >60){
					$p->style="warning";
				}
				if(($diff_now/$diff)*100 >95){
					$p->style="danger";
					
				}
			}
			else{
				$p->remaining=100;
				$p->style="danger";
			}
			
			$p->info=$info[0];
			$p->employees=$p->employees;
			$projects[]=$p;
			}
		}
		$employee->projects=$projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
        return view('employees.responsibilities',['employee'=>$employee, 'pid'=>-1]);
    }
	public function statics()
    {
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		$win=project::where('status','Done')->get();
		$lost=project::where('status','!=','Done')->where('end_date','<',Carbon\Carbon::now())->get();
		
		return view('admin.home',['employee'=>$employee,"lost"=>count($lost),"win"=>count($win),'client'=>count(client::all()),'project'=>count(project::all())]);
	}

	public function notifications(){

		$employee=employee::where('user_id',Auth::user()->id)->first();
		if(Auth::user()->role_id==1){
			return view('admin.notifications',['employee'=>$employee, 'pid'=>-1]);
		}
		else{
		return view('employees.notifications',['employee'=>$employee, 'pid'=>-1]);
		}
	}
	public function reportProject(Request $r){

		$employee=employee::where('user_id',Auth::user()->id)->first();
		$project=project::where('id',$r->project_id)->first();
		if(!$project){
			return "";
		}
		$project->employees=$project->employees;
		$pivot=DB::select("select * from employee_project where project_id=".$project->id);
		
		$employees=[];
		$project->hours=0;
		$all_salary=0;
		foreach ($pivot as $pi){
			
			$e=employee::find($pi->employee_id);
			if(isset($r->start_date) and isset($r->end_date)){
				$project->start=$r->start_date;
				$project->end=$r->end_date;
				$task_hours=DB::select("select sum(hours) as hours from tasks  where project_id=".$project->id." and employee_id=".$e->id." and date_day between '".$r->start_date."' and '".$r->end_date."'");
				
			}
			else{
				$project->start=$project->start_date;
				$project->end=$project->end_date;
				$task_hours=DB::select("select sum(hours) as hours from tasks  where project_id=".$project->id." and employee_id=".$e->id);
			}
			$pi->hours=$task_hours[0]->hours;
			
			$pi->work_hours=$pi->hours/60;
			$pi->backup=0;
			if($pi->hours==0){
				$pi->salary=0;
			}
			else{
				$pi->style="success";
				if(($pi->expected_hours) < $pi->work_hours){
					$pi->style="danger";
					$pi->backup=($pi->work_hours)-($pi->expected_hours);
					$pi->work_hours=$pi->expected_hours;
				}
				$pi->salary=intval( ($pi->backup*$e->over_price)+($pi->work_hours*$e->hour_cost));
				$pi->work_hours=$pi->work_hours*60;
				$pi->backup=$pi->backup*60;
			
			}
			$all_salary=intval( $all_salary+$pi->salary);
			$pi->name=$e->first_name." ".$e->last_name;
			$pi->image=$e->image;
			$pi->timeline=($pi->hours/($pi->expected_hours*60))*100;
			
			$pi->style="success";
			if($pi->timeline >60){
					$pi->style="warning";
				}
			if($pi->timeline >95){
					$pi->style="danger";
					
				}
			$project->hours=$pi->hours+$project->hours;
			
			$project->style="success";
            $pi->hours="(".(intval($pi->work_hours/60))." H  : ".($pi->work_hours%60)." m)";
			$pi->back="(".(intval($pi->backup/60))." H  : ".($pi->backup%60)." m)";
			if((($project->expected_hours*60)-$project->hours) <0){
				$project->style="danger";
			}
			$employees[]=$pi;
		}
		$project->all_salary=$all_salary;
		$project->style_win="green";
		$project->win="won";
		$cur=currency::find($project->currency_id);
		$project->price_us_win=intval((($project->price*$cur->sp_value)-$project->all_salary)/$cur->sp_value);
		if(($project->price*$cur->sp_value)-$project->all_salary <0){
				$project->style_win="red";
				$project->win="lost";
			}
		$currencies=currency::all();
		$project->hours_minute="(".(intval($project->hours/60))." H  : ".($project->hours%60)." m)";
		$project->hours_un=($project->expected_hours*60)-$project->hours;
		
		$project->hours_minute_un="(".(intval($project->hours_un/60))." H  : ".($project->hours_un%60)." m)";
		$project->client=client::find($project->client_id)->compnay_name;
		return view('admin.reportBydate',['type'=>$r->type,'currencies'=>$currencies,'employees'=>$employees,'employee'=>$employee,'project'=>$project]);
	}
		public function Ecard(){

		$employee=employee::where('user_id',user::find(Auth::user()->id))->first();

		return view('admin.reportEmployeeCard',['employee'=>$employee]);
	}
	public function reportEmployee(Request $r){
		$user=employee::where('user_id',Auth::user()->id)->first();
		$employee=employee::where('id',$r->employee_id)->first();
		$position=position::find($employee->position_id);
		$employee->username=user::find($employee->user_id)->user_name;
		$department=department::find($position->department_id);
		$employee->position=$position->part_project;
		$employee->department=$department->name;
		$employee->start_date=$employee->start_job;
		$employee->end_date='Until Now';
		if(isset($r->start_date) and isset($r->end_date)){
			$employee->start_date=$r->start_date;
			$employee->end_date=$r->end_date;
			$salary=DB::select("select * from salaries where employee_id=".$employee->id." and date between '".$r->start_date."' and '".$r->end_date."'");
		}
		else{
			$salary=salary::where('employee_id',$employee->id)->get();
		}
		$employee->all_salary=0;
		foreach($salary as $s){
			$employee->all_salary=$s->amount+$employee->all_salary;
		}
		$projects=[];
		foreach($employee->projects as $project){
				$dateFrom=\Carbon\Carbon::createFromFormat('Y-m-d',$project->start_date);
				$dateTo=\Carbon\Carbon::createFromFormat('Y-m-d',$project->end_date);
				$now=\Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d", time()));
				$project->style="success";
				if($dateTo > $now){
						$diff=$dateFrom->diffInDays($dateTo);
						$diff_now=$dateFrom->diffInDays($now);
						$project->timeline=($diff_now/$diff)*100;
						if(($diff_now/$diff)*100 >60){
							$project->style="warning";
						}
						if(($diff_now/$diff)*100 >95){
							$project->style="danger";
							
						}
						

					}
				else{
						$project->remaining=100;
						$project->style="danger";
					}
				  $pivot=DB::select("select * from employee_project where project_id=".$project->id." and employee_id=".$employee->id);
				if(isset($r->start_date) and isset($r->end_date)){
					$task_hours=DB::select("select sum(hours) as hours from tasks  where project_id=".$project->id." and employee_id=".$employee->id." and date_day between '".$r->start_date."' and '".$r->end_date."'");
					$pivot[0]->hours=$task_hours[0]->hours;
				}
				  $project->work=intval($pivot[0]->hours/60)."H : ".intval($pivot[0]->hours%60)."m";
				  $project->over="0 H:0 m";
				  $project->work_style="success";
				  $project->back_style="success";
				  if($pivot[0]->hours > ($pivot[0]->expected_hours*60)) {
					  $project->work=$pivot[0]->expected_hours;
					  $project->work=$project->work."H : 0m";
					  $project->work_style="danger";
					  $project->over=$pivot[0]->hours-($pivot[0]->expected_hours*60);
					  if($project->over > $pivot[0]->backup_hours){
						  	  $project->back_style="danger";
					  }
					  $project->over=intval($project->over/60)."H :".intval($project->over%60)."m";
				  }
				  $projects[]=$project;
				 
		}
		$employee->projects=$projects;
		
		return view('admin.reportEmployeeCard',['type'=>$r->report_type,'salaries'=>$salary,'employee'=>$user,'e'=>$employee]);
	}
		public function inventory(){

		$employee=employee::where('user_id',Auth::user()->id)->first();
		$year=\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', now())->year;
		$all_salaries=[];
		
		if(isset($_GET['end_date']) || isset($_GET['start_date'])){
			$start_date=$_GET['start_date'];
			$end_date=$_GET['end_date'];
			$salary=salary::where('date','like','%'.$start_date.'%')->where('date','like','%'.$end_date.'%')->get();
			$all_projects=project::where('start_date','like','%'.$start_date.'%')->where('start_date','like','%'.$year.'%')->get();
		}
		else{
			$salary=salary::where('date','like','%'.$year.'%')->get();
			$all_projects=project::where('start_date','like','%'.$year.'%')->get();
		}
		$all_salary=0;
		$salaries=[];
		$all_amount=0;
		foreach($salary as $s){
				$employee=employee::find($s->employee_id);
				$s->name=$employee->first_name." ".$employee->last_name;
				$s->image=$employee->image;
				$s->hours=intval($s->hours/60)."H : ".intval($s->hours%60)." m";
				$all_salary=$all_salary+$s->amount;
				$s->over_hours=$s->over_hours/60;
				$salaries[]=$s;
			
		}
		$projects=[];
		foreach ($all_projects as $p){
			if($p->status=="finished"){
				$p->status="Winning";
			}
			$p->client=client::find($p->client_id)->compnay_name;
			$currency=currency::find($p->currency_id);
			$all_amount=$p->price+$all_amount;
			$projects[]=$p;
		}
		$style="won";
		if(count($projects)!=0){
			if($all_amount<$all_salary/$currency->sp_value){
			$style="lost";}
		}
		else{
				$currency=currency::all()[0];
			}
		
		return view('admin.annual_inventory',['style'=>$style,'currency'=>$currency,'projects'=>$projects,'all_salary'=>$all_salary,"all_amount"=>$all_amount,'salaries'=>$salaries,'employee'=>$employee]);
	}
	public function salary(){

		$employee=employee::where('user_id',Auth::user()->id)->first();
        $date_day=date('Y-m');
		if(isset($_GET['date'])){
			$date_day=$_GET['date'];
			
		}
		$salaries=salary::where('date',$date_day)->get();
		
		$total_amount=0;
		foreach($salaries as $s){
			$e=employee::find($s->employee_id);
			$s->name=$e->first_name." ".$e->last_name;
			$s->image=$e->image;	
			$s->over=0;
			$s->hours=$s->hours/60;
			if($s->hours > $e->target_hours){
				
				$s->over=$s->hours-$e->target_hours;
			}
			$s->hours=$s->hours*60;
			$s->hours=intval($s->hours/60)."H : ".intval($s->hours%60)." m";
			$s->hours=$s->hours."/".$e->target_hours;
			$total_amount=$total_amount+$s->amount;
		}
		$c=currency::orderBy('id','desc')->get()[0];
		$total_dollar=$total_amount/$c->sp_value;
		return view('admin.report-salary',["c"=>$c,'salaries'=>$salaries,'employee'=>$employee,'total_amount'=>$total_amount,'total_dollar'=>$total_dollar]);
	}
	
}
