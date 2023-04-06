<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\currency;
use App\Models\project;
use App\Models\salary;
use App\Models\task;
use Illuminate\Http\Request;
use App\Models\user;
use Auth;
use DB;
use App\Models\notification;
class salaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    
    public function index()
    {
        //
        $employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
        $employees = employee::all();
		$date_day=date('Y-m');
		if(isset($_GET['date'])){
			$date_day=$_GET['date'];
			
		}
		$salary=salary::where('date',$date_day)->get();
		$res=[];
		$all_amount=0;
		$currency=currency::orderBy('updated_at','desc')->first();
		
		foreach($salary as $s){
			$s->employee=employee::find($s->employee_id);
			$s->hours_minute="(".(intval($s->hours/60))." H  : ".($s->hours%60)." m)";
			$s->hours_minute_over="(".(intval($s->over_hours/60))." H  : ".($s->over_hours%60)." m)";
			$all_amount=$all_amount+$s->amount;
			$s->style="success";
			if($s->hours > $s->employee->target_hours*60){
				$s->style="danger";
			}
			
			$res[]=$s;
		}
        return view('admin.salaries',['currency'=>$currency,"all_amount"=>$all_amount,"salary"=>$res,'employees'=>$employees, 'employee'=>$employee]);
    }
    //////// function to get all task for salary ////////
    public function tasks(Request $r){
        $employee=employee::where('user_id',Auth::user()->id)->first();
		$tasks=task::where('salary_id',$r->salary_id)->where('project_id',$r->project_id)->where('employee_id',$r->employee_id)->get();
		
        return $tasks;
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
        //
    }
	/////////// add bonus ////
  public function bonus(Request $request)
    {
		$salary=salary::find($request->id_v);
		$salary->bonus=$request->bonus;
		if($request->type=="-"){
			$salary->amount=$salary->amount-$request->bonus;
			$salary->bonus="-".$request->bonus;
			$notification=new notification;
			$notification->user_id=$salary->employee_id;
			$notification->text=$request->bonus." s.p is deducted from you";
			$notification->type="fin";
			$notification->link="/";
			$notification->save();
		}
		else{
			$salary->amount=$salary->amount+$request->bonus;
			$notification=new notification;
			$notification->user_id=$salary->employee_id;
			$notification->text=$request->bonus." s.p bonus is added to you";
			$notification->type="fin";
			$notification->link="/";
			$notification->save();
		}
		$salary->save();
		return redirect()->route('salary.index');
        //
    }
	
	/////////// get details for employee salary in date //////////////
	public function salary_employee(Request $r){
		$employee=employee::find($r->employee_id);
		$salary=salary::where('employee_id',$employee->id)->where('id',$r->salary_id)->first();
		$projects=[];
		$all_hours=0;
		$tasks=DB::Select('select project_id,employee_id,sum(hours) as hours from tasks where employee_id='.$employee->id.' and salary_id='.$r->salary_id.' group by project_id,employee_id,salary_id');
		foreach($tasks as $task){
			$project=project::find($task->project_id);
			$project->work_hours=$task->hours;
			$pivot=DB::select("select * from employee_project where project_id=".$project->id." and employee_id=".$employee->id);
			$extra_hours=($pivot[0]->expected_hours*60)-$task->hours;
			if($extra_hours < 0){
				$project->extra_hours=$extra_hours*-1;
				$project->work_hours=$pivot[0]->expected_hours*60;
			}
			
			$project->extra_hours="(".(intval($project->extra_hours/60))." H  : ".($project->extra_hours%60)." m)";
			$project->work_hours="(".(intval($project->work_hours/60))." H  : ".($project->work_hours%60)." m)";
		
			$projects[]=$project;
			$all_hours=$all_hours+$task->hours;
		}
		$over_hours=0;
		if($employee->target_hours*60 < $all_hours){
			$over_hours=$all_hours-($employee->target_hours*60);
		}
		$all_hours="(".(intval($all_hours/60))." H  : ".($all_hours%60)." m)";
		$over_hours="(".(intval($over_hours/60))." H  : ".($over_hours%60)." m)";
		
		
	    $data = array(
		'salary' => $salary,
            'employee' => $employee,
            'projects' => $projects,
            'all_hours' => $all_hours,
			'over_hours' => $over_hours,
        );
        return $data;
		
	}
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
		$salary=salary::find($id);
		$salary->tasks= $salary->tasks;
		
		return $salary;
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function edit(salary $salary)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, salary $salary)
    {
		$input = $request->all();
		$salary->fill($input)->save();
     
		
		return response()->json(['salary' => $salary], 200);
        //
    }
	
	///////////////// accepted overtime /////////////////


    public function salary_overtime(Request $request)
    {
		$salary=salary::find($request->id);
		$salary->over_hours=$request->c_hours*60;
		$notification=new notification;
		$notification->user_id=$salary->employee_id;
		$notification->text=$request->c_hours." hours overtime have been approved";
		$notification->type="fin";
		$notification->link="/";
		$notification->save();
		$e=employee::find($salary->employee_id);
		$salary->amount=(($e->over_price/60)*$salary->over_hours)+(($e->hour_cost/60)*$salary->hours);
		$salary->save();
		return redirect()->route('salary.index');
    }
	








///////////////////////// pay //////////////////////
   public function pay(Request $request)
    {
		$salary=salary::find($request->salary_id);
		$salary->status="paid";

		$notification=new notification;
		$notification->user_id=$salary->employee_id;
		$notification->text="Your Salary For ".$salary->date." is paid";
		$notification->type="fin";
		$notification->link="/";
		$notification->save();
	
		$salary->save();
		
		return redirect()->route('salary.index');
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\salary  $salary
     * @return \Illuminate\Http\Response
     */
    public function destroy(salary $salary)
    {
        //
    }
}
