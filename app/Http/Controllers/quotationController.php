<?php

namespace App\Http\Controllers;

use App\Models\quotation;
use App\Models\employee;
use Illuminate\Http\Request;
use Image;
use Storage;
use DB;
use App\Models\currency;
use App\Models\project;
use App\Models\position;
use App\Models\user;
use Auth;
use App\Models\notification;
use Session;
use App\Models\employee_quotation;
use App\Models\client;
use File;
class quotationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $quotations=quotation::all();
		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		$clients=client::all();
		return view('admin.quotation.saved-qoutations',['clients'=>$clients,'quotations'=>$quotations,'employee'=>$employee]);
    }


	//// set as  project //////////
	public function setProject(Request $r)
    {
		$quotation=quotation::find($r->quotation_id);
		if($quotation->set_project==true){
			return response()->json(['message' => "Done"], 200);
		}
		$quotation->set_project=true;
		$quotation->save();

        $quotation= json_decode(json_encode($quotation), true);

		$project=project::create($quotation);
		$employees=employee_quotation::where('quotation_id',$quotation['id'])->get();
		foreach ($employees as $employee){
			 $projects=[];
			 $projects[]=$project->id;
		 	 $employee_in=employee::find($employee->employee_id);
			 ////
		     $notification=new notification;
			 $notification->user_id=$employee_in->id;
			 $notification->text="You have been added to the project (".$project->project_name.")";
			 $notification->type="tech";
			 $notification->link="/project/tasks/".$project->id;
			 $notification->save();
			 //////
			 $employee_in->projects()->attach($projects,['expected_hours'=>$employee->expected_hours,'backup_hours'=>$employee->backup_hours]);
		}

		return response()->json(['message' => "Done"], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		$clients=client::all();
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		$currencies=currency::all();
		$employees=[];
		foreach(employee::all() as $e){
			if($e->user->role_id != 1){
				$e->position=position::find($e->position_id)->part_project;
				$user=user::find($e->user_id);
				if($user->role_id!=1){
					$employees[]=$e;
					}
			}
		}
		return view('admin.quotation.project-calculator',["clients"=>$clients,"currencies"=>$currencies,'employee'=>$employee,'employees'=>$employees]);
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
			'project_name' => 'required|unique:quotations|max:255|unique:projects',
			'client_id' => 'required',
			]);
		//////// employee array

		$quotation=quotation::create($request->except(['set','employees','back','hours','image']));

		$employees=json_decode($request->employees);
		$hours=json_decode($request->hours);
		$back=json_decode($request->back);

		for ($i=0;$i<count($employees);$i++){
			 $quotations=[];
			 $quotations[]=$quotation->id;
		 	 $employee_in=employee::find($employees[$i]);

			 $employee_in->quotations()->attach($quotations,['expected_hours'=>$hours[$i],'backup_hours'=>$back[$i]]);
		}

		////

		 $client=client::find($request->client_id);
		 if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $quotation->id.$img->getClientOriginalName();
                    $quotation->image=$filename;
                    $location = storage_path('app/public/quotation/') . $filename;
                    Image::make($img)->save($location);
                }
		$quotation->save();
		$client->quotations()->save($quotation);
		if($request->set=="1"){

		if($quotation->set_project==true){
			return response()->json(['message' => "Done"], 200);
		}
		$quotation->set_project=true;
		$quotation->save();

        $quotation= json_decode(json_encode($quotation), true);

		$project=project::create($quotation);
		$employees=employee_quotation::where('quotation_id',$quotation['id'])->get();
		foreach ($employees as $employee){
			 $projects=[];
			 $projects[]=$project->id;
		 	 $employee_in=employee::find($employee->employee_id);
			 $notification=new notification;
			 $notification->user_id=$employee_in->id;
			 $notification->text="You have been added to the project (".$project->project_name.")";
			 $notification->type="tech";
			 $notification->link="/project/tasks/".$project->id;
			 $notification->save();
			 $employee_in->projects()->attach($projects,['expected_hours'=>$employee->expected_hours,'backup_hours'=>$employee->backup_hours]);
		}
		}


		return response()->json(['quotation' => $quotation], 200);
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

		$quotation=quotation::find($id);
		// quotation->tasks
		// quotation->employees
		$work_hours=DB::select("select sum(hours) as all_hours from employee_quotation where quotation_id=".$quotation->id);
		if(count($work_hours)==0){
			$quotation->work_hours=0;
			}
		else{
			$quotation->work_hours=$work_hours[0]->all_hours;
		}
		$over=$quotation->expected_hours-$quotation->work_hours;
		$quotation->over=0;
		if($over<0){
			$quotation->over=$over*-1;
		}
		return $quotation;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function edit(quotation $quotation)
    {

        $employee=employee::where('user_id',Auth::user()->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		$currencies=currency::all();
		$my_employees=[];
		$employees=[];
		$employee_id=[];
        foreach ($quotation->employees as $e){

            $pivot=DB::select("select * from employee_quotation where quotation_id=".$e->pivot->quotation_id." and employee_id=".$e->pivot->employee_id);
			$e->expected_hours=$pivot[0]->expected_hours;
			$e->backup_hours=$pivot[0]->backup_hours;
			$my_employees[]=$e;
			$employee_id[]=$e->id;
		}
		foreach(employee::all() as $e){
			if(!in_array($e->id,$employee_id) && $e->user->role_id!=1){
                $e->position=position::find($e->position_id)->part_project;
				$user=user::find($e->user_id);
				if($user->role_id!=1){
                    $employees[]=$e;
                }

			}
		}
		$currency=currency::find($quotation->currency_id);
        $selectedClients=client::find( $quotation->client_id);

        $clients=client::where("id","!=", $quotation->client_id)->get();


		$quotation->priceSY=$quotation->price*$currency->sp_value;
		$quotation->currency=$currency;
		return view('admin.quotation.edit',["my_employees"=>$my_employees,"quotation"=>$quotation,"clients"=>$clients,"currencies"=>$currencies,'employee'=>$employee,'employees'=>$employees,'selectedClients'=>$selectedClients]);
        //
    }
  public function addEmployeeQua(Request $r){

	  $employee=employee::find($r->id);

	  Session::push('employees', $employee);

	  return Session::get('employees');
  }
   public function drop($id,$q){

	  DB::select("delete from employee_quotation where employee_id=".$id." and quotation_id=".$q);

	  return redirect("/admin/quotation/$q/edit");
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
		$quotation=quotation::find($request->quotation_id);
		$input = $request->except(['set','quotation_id','employees','back','hours','image']);
		$quotation->fill($input)->save();

		//////// employee array


		$employees=json_decode($request->employees);
		$hours=json_decode($request->hours);
		$back=json_decode($request->back);

		for ($i=0;$i<count($employees);$i++){
			$employee_in=employee::find($employees[$i]);
			$found_it=DB::select("select * from employee_quotation where employee_id=".$employee_in->id." and quotation_id=".$quotation->id);
			if(count($found_it)==0){
			 $quotations=[];
			 $quotations[]=$quotation->id;

			 $employee_in->quotations()->attach($quotations,['expected_hours'=>$hours[$i],'backup_hours'=>$back[$i]]);
			}
		}

		////

		 $client=client::find($request->client_id);
         $quotation->client_id = $request->client_id;

		 if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $quotation->id.$img->getClientOriginalName();
                    $quotation->image=$filename;
                    $location = storage_path('app/public/quotation/') . $filename;
                    Image::make($img)->save($location);
                }
		$quotation->save();
		$client->quotations()->save($quotation);


		if($request->set=="1" && $quotation->set_project==false){

				if($quotation->set_project==true){
					return response()->json(['message' => "Done"], 200);
				}
				$quotation->set_project=true;
				$quotation->save();

				$quotation= json_decode(json_encode($quotation), true);

				$project=project::create($quotation);
				$employees=employee_quotation::where('quotation_id',$quotation['id'])->get();
				foreach ($employees as $employee){
					 $projects=[];
					 $projects[]=$project->id;
					 $employee_in=employee::find($employee->employee_id);
				 $notification=new notification;
			 $notification->user_id=$employee_in->id;
			 $notification->text="You have been added to the project (".$project->project_name.")";
			 $notification->type="tech";
			 $notification->link="/project/tasks/".$project->id;
			 $notification->save();
					 $employee_in->projects()->attach($projects,['expected_hours'=>$employee->expected_hours,'backup_hours'=>$employee->backup_hours]);
				}
		}
		return response()->json(['quotation' => $quotation], 200);

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\quotation  $quotation
     * @return \Illuminate\Http\Response
     */
    public function destroy(quotation $quotation)
    {
		$quotation->delete();
		File::delete(storage_path('app/public/quotation/' . $quotation->image));
		return response()->json(['quotation' => $quotation], 200);
        //
    }
}
