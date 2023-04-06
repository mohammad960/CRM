<?php

namespace App\Http\Controllers;
use App\Models\employee;
use App\Models\salary;
use App\Models\employee_project;
use App\Models\task;
use App\Models\employee_quotation;

use App\Models\user;
use Auth;
use Illuminate\Http\Request;
use Image;
use Storage;
use Hash;
use File;
use DB;

use App\Models\role;
use App\Models\position;
use App\Models\department;;
class userController extends Controller
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
		$users=user::all();
		$roles=role::all();
		$positions=position::all();
		$departments=department::all();
		$arr=[];
		foreach($users as $d){
             $arr[] = array(
				'id' => $d->id,
                'user_name' => $d->user_name,
				'password' => $d->clear_password,
                'role' => role::find($d->role_id)->name,
				'target_hours' => $d->employee->target_hours,
				'start_job' =>$d->employee->start_job,
                'name' => $d->first_name." ".$d->last_name,
				'image' => $d->employee->image,
				'hour_cost' => $d->employee->hour_cost,
				'position_id' => (position::find($d->employee->position_id)) ? position::find($d->employee->position_id)->part_project :'',
                     );
        }
		return view('admin.users',['users'=>$arr,"departments"=>$departments,"positions"=>$positions,'employee'=>$employee]);
    }
	public function pagination_ajax(Request $r)
    {
        $start = $r->get('start');
        $length = $r->get('length');
        $search = $r->get('search');

        /* Get [Some-Data] from DB */
        /* Obj */
        $data = user::select('*')
        ->where('user_name','like','%'.$search['value'].'%')
        ->skip($start)
        ->take($length)
        ->get();

        /* To send (data) to ->(view.index).
            I need to convert from Obj to [Arr-of-Arr]. */
        $arr = array();
        foreach($data as $d){
             $arr[] = array(
                'user_name' => $d->user_name,
				'password' => $d->clear_password,
                'role' => role::find($d->role_id)->name,
				'target_hours' => $d->employee->target_hours,
				'start_job' =>$d->employee->start_job,
                'name' => $d->first_name." ".$d->last_name,
				'hour_cost' => $d->employee->hour_cost,
				'position_id' => position::find($d->employee->position_id)->part_project,
                'action' => "
                            <a href='user/".$d->id."/edit' style='color:#377CDB;'><i class='fas fa-edit'></i>Edit</a>

                            ",
                'delete' => "<a href='user/".$d->id."/destroy' style='color:#DC3545;'><i class='fas fa-trash'></i>Delete</a>"
            );
        }
        /* The count of [All-Data] */
        $total_members = user::count();
        $count = DB::select("select * from users where user_name like '%".$search['value']."%'");
        $recordsFiltered = count($count);
        /* Send Data [JSON] */
        $data = array(
            'recordsTotal' => $total_members,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        );
        echo json_encode($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$roles=role::all();
		$positions=position::all();
		$departments=department::all();
		return view('user.create',['roles'=>$roles,'positions'=>$positions,'departments'=>$departments]);
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
			'user_name' => 'required|unique:users|max:255',
			'password' => 'required',
			]);

		$user=new user();
		$user->user_name=$request->user_name;
		$user->role_id=$request->role_id;
		$user->clear_password=$request->password;
		$user->notification=$request->notification;
		$user->password=Hash::make($request->password);
		$user->save();

		$employee=employee::create($request->except(['notification','clear_password','user_name','role_id','password']));
		$employee->user_id=$user->id;
		 if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $employee->id.$img->getClientOriginalName();
					File::delete( storage_path('app/public/employee/' . $employee->image));
                    $employee->image=$filename;
                    $location = storage_path('app/public/employee/') . $filename;
                    Image::make($img)->save($location);
                }
		$employee->save();
		$user->employee()->save($employee);
		return redirect()->route('user.index');
        //
    }

   ///////////////
   public function changImage(Request $request){
	 try{
	   $employee=employee::where("user_id",Auth::user()->id)->first();
	   if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
					$old_image=$employee->image;
                    $filename =  $employee->id.$img->getClientOriginalName();

                    $employee->image=$filename;
                    $location = storage_path('app/public/employee/') . $filename;
                    Image::make($img)->save($location);
					File::delete( storage_path('app/public/employee/' . $old_image));
                }
		$employee->save();
	 }
	 catch(\Exception $e){
		 return back();
	 }
	return back();
   }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(user $user)
    {
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		$users=user::all();
		$roles=role::all();
		$positions=position::all();
		$departments=department::all();
		$employee_user=employee::where('user_id',$user->id)->first();
		$position=position::find($employee_user->position_id);
		$user->position=$position ? $position->part_project:'';
		$depart=department::find($employee_user->department_id);
		$user->department=$depart ? $depart->name:'';
		return view('admin.users',['employee_user'=>$employee_user,'users'=>$users,"departments"=>$departments,"positions"=>$positions,'employee'=>$employee,'user'=>$user]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {

		$validated = $request->validate([
			'user_name' => 'required|unique:users,id,'.$user->id.'|max:255',

			]);
		$input = $request->all();
		$user->user_name=$request->user_name;
		if(isset($request->password)){
			$user->password=Hash::make($request->password);
			$user->clear_password=$request->password;
		}
		$user->save();
		$employee=employee::where('user_id',$user->id)->first();
		$employee->fill($request->except(['clear_password','user_name','password','role_id']));
		 if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $employee->id.$img->getClientOriginalName();
                    $employee->image=$filename;
                    $location = storage_path('app/public/employee/') . $filename;
                    Image::make($img)->save($location);
                }
		$employee->save();

		return redirect()->route('user.index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $user=user::find($id);
		$user->delete();

		$employee=employee::where('user_id',$user->id)->first();

		$employee->delete();

        $employee_project=employee_project::where('employee_id',$employee->id);
        $employee_project->delete();
        $employee_quotation=employee_quotation::where('employee_id',$employee->id);

        $employee_quotation->delete();
        $salary=salary::where('employee_id',$employee->id);
        $salary->delete();

        $task=task::where('employee_id',$employee->id);
        $task->delete();
		//File::delete(storage_path('app/public/employee/' . $employee->image));
		 return redirect()->back();
        //
    }
    public function trashed()
    {
        $user= user::onlyTrashed()->with('employee.position')->get();
        $employee=employee::onlyTrashed()->with('position')->get();
       

         return view('admin.trashed_user')->with('user',$user)->with('employee',$employee);
    }

    public function restore($id)
    {
        $user= user::withTrashed()->where('id',$id)->first();
        $user->restore();
        $employee= employee::withTrashed()->where('id',$id)->first();
        $employee->restore();
        return redirect()->back();
    }

}
