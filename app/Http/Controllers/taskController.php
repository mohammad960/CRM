<?php

namespace App\Http\Controllers;

use App\Models\task;
use App\Models\salary;
use Illuminate\Http\Request;
use Image;
use Storage;
use Auth;
use App\Models\project;
use App\Models\user;
use App\Models\employee;
use File;
use Carbon\Carbon;
use App\Models\employee_project;
class taskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
		$tasks=task::all();
		return view('task.index',['tasks'=>$tasks]);
    }
    public function getByEmployee(Request $request)
    {
        //
		$tasks=task::where('employee_id',$request->employee_id)->get();
		
		return view('task.index',['tasks'=>$tasks]);
    }

	
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('task.create');
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
	
		$employee=employee::where('user_id',Auth::user()->id)->first();
	
		$tasks=task::where('employee_id',$employee->id)->where('status','start')->get();
		if(count($tasks) > 0){
			return response()->json(['message' => 'this employee have task'], 400);
		}
		
		$task=new task;
		$task->employee_id=$employee->id;
		$task->project_id=$request->project_id;
		$task->status='start';
		$task->description=$request->description;
		$task->start_date=Carbon::now();
		$employee=employee::find($employee->id);
		$task->hour_cost=$employee->hour_cost;
		$task->over_price=$employee->over_price;
		$task->date_day=date('Y-m-d');
		
		
		//////////////
		$project=project::find($request->project_id);
		$employee->tasks()->save($task);
		$project->tasks()->save($task);
		$task->save();
		
		return response()->json(['task' => $task], 200);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(task $task)
    {
		return view('task.edit',["task"=>$task]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, task $task)
    {
		
		
		$tasks=task::where('id',$task->id)->where('hours','!=',0)->get();
		if(count($tasks) > 0){
			return response()->json(['message' => 'this task is finished'], 400);
		}
		$input = $request->all();
		$task->fill($input)->save();
		if( $request->hasFile('image'))
                { 
                    $img = $request->file('image'); 
                    $filename =  $task->id.$img->getClientOriginalName();
					File::delete( storage_path('app/public/task/' . $task->image));
                    $task->image=$filename;
                    $location = storage_path('app/public/task/') . $filename;
                    Image::make($img)->save($location);
                } 
		$task->status="end";
		$task->end_date=Carbon::now();
		$diff = $task->end_date->diffInMinutes($task->start_date);
		$task->hours=$diff;
	
		$employee_project=employee_project::where('project_id',$task->project_id)->where('employee_id',$task->employee_id)->first();
		$employee_project->hours=$employee_project->hours+$task->hours;
		$employee_project->save();
		
		////////////// salary ////////////
		$employee=employee::find($task->employee_id);
		$salary_month=salary::where('date',date('Y-m'))->where('employee_id',$task->employee_id)->where('status','!=','pay')->first();
		if(!$salary_month){
			$salary_month=new salary;
			$salary_month->employee_id=$task->employee_id;
			$salary_month->status='not paid';
			$salary_month->date=date('Y-m');
		}
		
		
		$salary_month->hours=$salary_month->hours+$diff;
		$diff_hours=($employee->target_hours*60)-$salary_month->hours;
		if($diff_hours<0){
				$salary_month->hours=$employee->target_hours*60;
				$salary_month->over_hours=$diff_hours*-1;
			}
			
		$salary_month->amount=($salary_month->hours*$task->hour_cost/60)+($salary_month->over_hours*$task->over_price/60);
		$salary_month->save();
		$task->salary_id=$salary_month->id;
		$task->save();
		$salary_month->tasks()->save($task);
		
		////////////////////////////////////////////////////////////////
		return redirect('/project/tasks/'.$task->project_id);
		
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(task $task)
    {
		$task->delete();
		File::delete(storage_path('app/public/task/' . $task->image));
		return response()->json(['task' => $task], 200);
        //
    }
}
