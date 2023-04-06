<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\project;
use Illuminate\Http\Request;
use App\Models\employee_project;
class employeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
   /**
     * assign a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function assign(Request $request)
    {
		$employee=employee::find($request->employee_id);
		$project=project::find($request->project_id);
		$employee->projects()->attach($project);
		$employee_project=employee_project::where('project_id',$request->project_id)->where('employee_id',$request->employee_id)->first();
		$employee_project->expected_hours=$request->expected_hours;
		$employee_project->backup_hours=$request->backup_hours;
		$employee_project->save();
		$project->expected_hours=$request->expected_hours+$project->expected_hours;
		$project->backup_hours=$request->backup_hours+$project->backup_hours;
		$project->price=$employee->hour_cost*$project->expected_hours+$employee->over_price*$project->backup_hours+$project->price;
		$project->save();
        return response()->json(['message' => "Done"], 200); 
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$employee=employee::find($id);
		$employee->projects= $employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		return $employee;
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(employee $employee)
    {
        //
    }
}
