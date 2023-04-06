<?php

namespace App\Http\Controllers;

use App\Models\department;
use Illuminate\Http\Request;
use Image;
use Storage;
use App\Models\employee;
use App\Models\user;
use Auth;
class departmentController extends Controller
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
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;

		$departments=department::all();
		return view('admin.departments',['departments'=>$departments,'employee'=>$employee]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('department.create');
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
		$validated = $request->validate([
			'name' => 'required|unique:departments|max:255',
			]);

		 $department=department::create($request->all());


		return redirect()->route('department.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(department $department)
    {
		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;

		$departments=department::all();
		return view('admin.departments',['department'=>$department,'departments'=>$departments,'employee'=>$employee]);

        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, department $department)
    {
		$input = $request->all();
		$department->fill($input)->save();

			return redirect()->route('department.index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department=department::find($id);
		$department->delete();
        return redirect()->back();
        //
    }



    public function trashed()
    {
        $department= department::onlyTrashed()->get();


        return view('admin.trashed_department')->with('department',$department);
    }

    public function restore($id)
    {
        $department= department::withTrashed()->where('id',$id)->first();
        $department->restore();

        return redirect()->back();
    }
}
