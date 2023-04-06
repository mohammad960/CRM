<?php

namespace App\Http\Controllers;

use App\Models\attendance;
use App\Models\employee;
use App\Models\project;
use App\Models\client;
use App\Models\user;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;
class attendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$attendance=attendance::where('employee_id',$employee->id)->where('status','start')->first();
		$old_attend='none';
		$new_attend='block';

		$projects= [];
		foreach($employee->projects as $p){
			$info=DB::select("select * from employee_project where project_id= ".$p->id." and employee_id =".$employee->id);
			if($info[0]->enable==1 && $p->status=="In Progress"){
			$dateFrom=\Carbon\Carbon::createFromFormat('Y-m-d',$p->start_date);
			$dateTo=\Carbon\Carbon::createFromFormat('Y-m-d',$p->end_date);
			$now=\Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d", time()));
			$info[0]->hours_style="success";
			$info[0]->over_style="success";
			if($info[0]->hours > (60*$info[0]->expected_hours)){
				$info[0]->back_work_hours=$info[0]->hours-($info[0]->expected_hours*60);
				if (($info[0]->back_work_hours/60) > $info[0]->backup_hours ){
					$info[0]->over_style="danger";
				}
				$info[0]->hours=60*$info[0]->expected_hours;
				$info[0]->hours_style="danger";
			}
			else{
				$info[0]->back_work_hours=0;
			}
			$info[0]->hours="(".(intval($info[0]->hours/60))." H  : ".($info[0]->hours%60)." m)";
			$info[0]->back_work_hours="(".(intval($info[0]->back_work_hours/60))." H  : ".($info[0]->back_work_hours%60)." m)";
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

		$hour='';
		$id='';
		$date_day=date('Y-m');
		$all_work_task=DB::select("select sum(hours) as hours from tasks where employee_id=".$employee->id." and date_day like '%".$date_day."%'");

		$employee->my_work=0;
		$employee->over_work=0;
		if(count($all_work_task) > 0){
			$employee->my_work=intval($all_work_task[0]->hours/60);
			if($employee->my_work > $employee->target_hours){
				$employee->over_work=intval($employee->my_work-$employee->target_hours);
				$employee->my_work=$employee->target_hours;
			}
		}

		if($attendance){
			$hour=$attendance->start_date;
			$id=$attendance->id;
			$old_attend='block';
			$new_attend='none';
		}
		return view('employees.attendance',['employee'=>$employee,'attendance'=>$attendance,'hour'=>$hour,'id'=>$id,'old_attend'=>$old_attend,'new_attend'=>$new_attend, 'pid'=>-1]);
        //
    }
	public function attendance(){
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$date_day=date('Y-m-d');
		if(isset($_GET['date_today'])){
			$date_day=$_GET['date_today'];

		}

		$attendances=attendance::where('date_day',$date_day)->orderBy('start_date','asc')->get();
		$employees=employee::all();
		$all=[];
		foreach($attendances as $a){
			$e=employee::find($a->employee_id);
			$a->name=$e->first_name." ".$e->last_name;
			$a->image=$e->image;
			if (array_key_exists($a->name,$all)){
				if($a->status=="start"){
					$all[$a->name]->style="success";
					$all[$a->name]->status="present";
				}
				$arr_start=$all[$a->name]->array_start;
				$arr_start[]=$a->start_date;
				$arr_end=$all[$a->name]->array_end;
				$arr_end[]=$a->end_date;
				$all[$a->name]->array_start=$arr_start;
				$all[$a->name]->array_end=$arr_end;
				}
				else{
				$a->style="";

				if($a->status=="start"){
					$a->style="success";
					$a->status="present";
				}
				$a->status="present";
				$a->eid= $e->id;
				$a->array_start=[$a->start_date];
				$a->array_end=[$a->end_date];
				$all[$a->name]=$a;
}
				}
	       foreach($employees as $e){
			   $e->name=$e->first_name." ".$e->last_name;

			   if($e->user->role_id==2){
				   if (!array_key_exists($e->name,$all)){

					   $a=new attendance;
					   $a->eid = $e->id;
					   $a->status="absent";
					   $a->style="danger";
					   $a->array_start=[" -"];
					   $a->image=$e->image;
					   $a->name=$e->name;
						$a->array_end=[" -"];
					   $all[$a->name]=$a;
				   }
			   }
		   }

			return view('admin.attendance',['date_day'=>$date_day,'all'=>$all,'employee'=>$employee]);


	}
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$attendances=attendance::where('employee_id',$employee->id)->where('status','start')->get();
		if(count($attendances) > 0){
			return response()->json(['message' => 'this employee have attendance'], 400);
		}
		$attendance=new attendance;
		$attendance->start_date=Carbon::now();
		$attendance->date_day=date('Y-m-d');
		$attendance->employee_id=$employee->id;
		$attendance->status="start";
		$attendance->save();
		$employee=employee::find($employee->id);
		$employee->attendances()->save($attendance);
		return response()->json(['message' => "Done"], 200);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function show(attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function edit(attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
		$attendance=attendance::find($id);
		$attendance->end_date=Carbon::now();
		$attendance->status="end";
		$diff = $attendance->end_date->diffInMinutes($attendance->start_date);
		$attendance->hours=$diff;
		$attendance->save();
		return response()->json(['message' => "Done"], 200);
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(attendance $attendance)
    {
        //
    }
}
