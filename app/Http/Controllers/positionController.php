<?php

namespace App\Http\Controllers;

use App\Models\position;
use App\Models\department;
use Illuminate\Http\Request;
use Image;
use Storage;
use App\Models\employee;
use App\Models\user;
use Auth;
use DB;
class positionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$positions=DB::select('select positions.*,departments.name from positions left join departments on positions.department_id=departments.id where positions.deleted_at is null');
		$departments=department::all();
		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;

		return view('admin.positions',['departments'=>$departments,'positions'=>$positions,'employee'=>$employee]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('position.create');
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


		$position=position::create($request->all());
		return redirect()->route('position.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\position  $position
     * @return \Illuminate\Http\Response
     */
    public function show(position $position)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\position  $position
     * @return \Illuminate\Http\Response
     */
    public function edit(position $position)
    {
		$position->dep_name=department::find($position->department_id)->name;
		$positions=DB::select('select positions.*,departments.name from positions left join departments on positions.department_id=departments.id');
		$departments=department::all();
		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		return view('admin.positions',['departments'=>$departments,'positions'=>$positions,'employee'=>$employee,"position"=>$position]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\position  $position
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, position $position)
    {
		$input = $request->all();
		$position->fill($input)->save();
		return redirect()->route('position.index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\position  $position
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $position=position::find($id);
		$position->delete();
        return redirect()->back();
        //
    }



    public function trashed()
    {

        $position= position::onlyTrashed()->get();

       $position=DB::select('select positions.*,departments.name from positions left join departments on positions.department_id=departments.id where positions.deleted_at is not null');

        return view('admin.trashed_position')->with('position',$position);
    }

    public function restore($id)
    {
        $position= position::withTrashed()->where('id',$id)->first();
        $position->restore();

        return redirect()->back();
    }
}
