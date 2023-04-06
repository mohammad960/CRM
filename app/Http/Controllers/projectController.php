<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\notification;
use Illuminate\Http\Request;
use Image;
use Storage;
use DB;
use App\Models\employee;
use App\Models\user;
use Auth;
use App\Models\currency;
use App\Models\employee_project;
use App\Models\client;
use App\Models\position;
use App\Models\task;
use File;
class projectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= task::where('employee_id',$employee->id)->orderBy('created_at','desc')->get();
		$employee->attendances= $employee->attendances;
        $projects=project::all();
		 $arr = array();
        foreach($projects as $d){
             $arr[] = array(
			 'id' => $d->id,
                'project_name' => $d->project_name,
                'start_date' => $d->start_date,
				'end_date' => $d->end_date,
				'price' =>$d->price,
                'admin_hours' => $d->admin_hours,
				'expected_hours' => $d->expected_hours,
				'image' =>$d->image,
				'client' =>client::withTrashed()->where('id', $d->client_id)->first()->compnay_name,

            );
        }
		$clients=client::all();
		$projects=$arr;
		$currency=currency::all();
		return view('admin.projects',['clients'=>$clients,'currency'=>$currency,'projects'=>$projects,'employee'=>$employee]);
    }
    public function pagination_ajax(Request $r)
    {
        $start = $r->get('start');
        $length = $r->get('length');
        $search = $r->get('search');

        /* Get [Some-Data] from DB */
        /* Obj */
        $data = project::select('*')
        ->where('project_name','like','%'.$search['value'].'%')
        ->skip($start)
        ->take($length)
        ->get();

        /* To send (data) to ->(view.index).
            I need to convert from Obj to [Arr-of-Arr]. */
        $arr = array();
        foreach($data as $d){
             $arr[] = array(
                'project_name' => $d->project_name,
                'start_date' => $d->start_date,
				'end_date' => $d->end_date,
				'price' =>$d->price,
                'admin_hours' => $d->admin_hours,
				'expected_hours' => $d->expected_hours,
				'image' =>$d->image,
				'client' =>client::withTrashed()->where('id', $d->client_id)->first()->compnay_name,

                'action' => "
                            <a href='project/".$d->id."/edit' style='color:#377CDB;'><i class='fas fa-edit'></i>Edit</a>

                            ",
                'delete' => "<a href='project/".$d->id."/destroy' style='color:#DC3545;'><i class='fas fa-trash'></i>Delete</a>"
            );
        }
        /* The count of [All-Data] */
        $total_members = project::count();
        $count = DB::select("select * from projects where project_name like '%".$search['value']."%'");
        $recordsFiltered = count($count);
        /* Send Data [JSON] */
        $data = array(
            'recordsTotal' => $total_members,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        );
        echo json_encode($data);
    }

	//// assigne employee //////////
	public function addEmployee(Request $r)
    {
		$project=[];
        $project[]=$r->project_id;
		$employee=employee::find($r->employee_id);
		$employee->projects()->attach($project);


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
		$currencies=currency::all();
		return view('project.create',["clients"=>$clients,"currencies"=>$currencies]);
        //
    }
  public function currentProject()
    {

		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		if(isset($_GET['start']) || isset($_GET['end'])){
			if(isset($_GET['start']) && str_contains($_GET['start'],'-'))
			$projects=project::where('status',"=",'In Progress')->where('start_date','>',$_GET['start'])->get();
			if(isset($_GET['end']) && str_contains($_GET['end'],'-'))
			$projects=project::where('status',"=",'In Progress')->where('end_date','<',$_GET['end'])->get();
			if(isset($_GET['end']) && str_contains($_GET['end'],'-') && isset($_GET['start']) && str_contains($_GET['start'],'-'))
			$projects=project::where('status',"=",'In Progress')->where('start_date','>',$_GET['start'])->where('end_date','<',$_GET['end'])->get();
		}
		else{
			$projects=project::where('status',"=",'In Progress')->get();

		}
		$all_projects=[];

		foreach($projects as $p){
			$pivot=DB::select("select * from employee_project where project_id=".$p->id);
			$p->hours=0;
			$p->current_cost=0;
			foreach ($pivot as $pi){
				$e=employee::find($pi->employee_id);
				$p->hours=$p->hours+$pi->hours;
				if($pi->hours > ($pi->expected_hours*60)){
					$pi->backup_hours=$pi->hours-($pi->expected_hours*60);
					$pi->hours=$pi->expected_hours*60;
				}
				else{
					$pi->backup_hours=0;
				}

				$p->current_cost=($pi->hours*($e->hour_cost/60))+($pi->backup_hours*($e->over_price/60))+$p->current_cost;

			}
			$p->current_cost=intval($p->current_cost/currency::find($p->currency_id)->sp_value);
			$p->all_hours=60*$p->expected_hours;
			$p->all_hours_cost=$p->hours+$p->backup_hours;
			$p->timeline=($p->all_hours_cost/$p->all_hours)*100;
			$p->hours="(".(intval($p->hours/60))." H  : ".($p->hours%60)." m)";
			$p->backup_hours="(".(intval($p->backup_hours/60))." H  : ".($p->backup_hours%60)." m)";
			$p->all_hours_cost="(".(intval($p->all_hours_cost/60))." H  : ".($p->all_hours_cost%60)." m)";
			$p->all_hours=(intval($p->all_hours/60));
			$p->style="success";
			if($p->timeline >60){
					$p->style="warning";
				}
			if($p->timeline >95){
					$p->style="danger";

				}
			$all_projects[]=$p;
		}

		return view('admin.current-projects',['employee'=>$employee,'all_projects'=>$all_projects]);
        //
    }

 public function drop(Request $r){
	  $e= DB::select("select *  from employee_project where employee_id=".$r->employee_id." and project_id=".$r->project_id);
	  $state=0;
	  if($e[0]->enable==0){
		  $state=1;
	  }
	  DB::select("update employee_project set enable=".$state." where employee_id=".$r->employee_id." and project_id=".$r->project_id);
		$notification=new notification;
		$notification->user_id=$r->employee_id;
		$project=project::find($r->project_id);
		$notification->text="You have been removed from project (".$project->project_name.")";
		$notification->type="tech";
		$notification->link="/";
		$notification->save();

	  return back();
  }

	public function report(){
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$projects=project::all();
		$all_projects=[];
		$auto_projects = [];
		foreach($projects as $p){
			$pivot=DB::select("select * from employee_project where project_id=".$p->id);
			foreach ($pivot as $pi){
				$e=employee::find($pi->employee_id);
				$p->hours=$p->hours+$pi->hours;
				if($p->hours > ($p->expected_hours*60)){
					$p->backup_hours=$p->hours-($p->expected_hours*60);
					$p->hours=$p->hours-$pi->hours;
				}
				else{
					$p->backup_hours=0;
				}
				$task_hours=DB::select("select sum(hours) as hours from tasks  where project_id=".$p->id." and employee_id=".$e->id);
				$pi->hours=$task_hours[0]->hours;
				$pi->work_hours=$pi->expected_hours;
				$pi->backup=0;
				if($pi->hours==0){
					$pi->salary=0;
				}
				else{

						if(($pi->expected_hours*60) < $pi->hours){
							$pi->backup=$pi->hours/60-$pi->expected_hours;
							$pi->work_hours=$pi->expected_hours;
						}
						$pi->salary=($pi->backup*$e->over_price)+($pi->work_hours*$e->hour_cost);
						$pi->work_hours=$pi->work_hours*60;
						$pi->backup=$pi->backup*60;

					}


				$p->current_cost=$pi->salary+$p->current_cost;
			}

			$p->all_hours=$p->backup_hours+(60*$p->expected_hours);
			$p->all_hours_cost=$p->hours+$p->backup_hours;
			$p->timeline=($p->all_hours_cost/$p->all_hours)*100;
			$p->hours="(".(intval($p->hours/60))." H  : ".($p->hours%60)." m)";
			$p->backup_hours="(".(intval($p->backup_hours/60))." H  : ".($p->backup_hours%60)." m)";
			$p->all_hours_cost="(".(intval($p->all_hours_cost/60))." H  : ".($p->all_hours_cost%60)." m)";
			$p->all_hours=(intval($p->all_hours/60));
			$p->style="success";
			if($p->timeline >60){
					$p->style="warning";
				}
			if($p->timeline >95){
					$p->style="danger";

				}
			$all_projects[]=$p;
			$auto_projects[] = $p->project_name;
		}
		$employees=employee::all();
		return view('admin.projects-report',['employees'=>$employees,'employee'=>$employee,'all_projects'=>$all_projects, 'auto_projects'=>$auto_projects]);
	}

	public function bydate(){

		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();

		return view('admin.reportBydate',['employee'=>$employee]);
	}



	public function employee(){

		$employee=employee::where('user_id',Auth::user()->id)->first();
		$employees=employee::all();
		$employees_table=[];

		foreach($employees as $e){
		if($e->user->role_id!=1){
			 $projects=[];
			$e->all_excpected=0;
			$e->all_back=0;
			 foreach($e->projects as $p){

				$project_employee=DB::select("select * from employee_project where employee_id=".$e->id." and project_id=".$p->id);
				$p->excpected=$project_employee[0]->expected_hours;
				$p->back=$project_employee[0]->backup_hours;
				$e->all_excpected=$e->all_excpected+$p->excpected;
				$e->all_back=$e->all_back+$p->back;
				$projects[]=$p;
			 }
			 $e->projects=$projects;
			 $employees_table[]=$e;
		}
		}
		return view('admin.report-employee',['employees'=>$employees_table,'employee'=>$employee]);
	}

	public function Ecard(){

		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();

		return view('admin.reportEmployeeCard',['employee'=>$employee]);
	}


	public function attendance(){

		$employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$employees=employee::all();

		return view('admin.report-attendance',['employee'=>$employee, 'employees'=>$employees]);
	}

	public function cproject($id){

		$employee=employee::where('user_id',Auth::user()->id)->first();
		$project=project::find($id);
		$clients=client::where('id',$project->client_id)->first();
		// project->tasks
		// project->employees
		$project->employees=$project->employees;
		$work_hours=DB::select("select sum(hours) as all_hours from employee_project where project_id=".$project->id);
		if(count($work_hours)==0){
			$project->work_hours=0;
			}
		else{
			$project->work_hours=$work_hours[0]->all_hours;
		}
		$over=$project->expected_hours-$project->work_hours;
		$project->over=0;
		if($over<0){
			$project->over=$over*-1;
		}
		$project->employees=$project->employees;
		$employee_details=[];
		$project->cost=0;
		$employee_id=[];
		foreach($project->employees as $e){
			$details=DB::select("select * from employee_project where employee_id=".$e->id." and project_id=".$id);
			$e->expected_hours=$details[0]->expected_hours;
			$e->backup_hours=$details[0]->backup_hours;
			$project->cost=$project->cost+intval(($e->expected_hours*($e->over_price))+($e->backup_hours*($e->over_price)));

			$e->work_hours=$details[0]->hours;
			$e->timeline=($e->work_hours/($e->expected_hours*60))*100;
			$e->enable=$details[0]->enable;

			$e->style="success";
			if($e->timeline >60){
					$e->style="warning";
				}
			if($e->timeline >95){
					$e->style="danger";

				}
			if($e->work_hours > (60*$e->expected_hours)){
				$e->work_hours=$e->expected_hours*60;
				$e->back_work_hours=$details[0]->hours-($e->expected_hours*60);
			}
			else{
				$e->back_work_hours=0;
			}
			$e->cost=intval(($e->work_hours*($e->hour_cost/60))+($e->back_work_hours*($e->over_price/60)));

			$e->work_hours="(".(intval($e->work_hours/60))." H  : ".($e->work_hours%60)." m)";
			$e->back_work_hours="(".(intval($e->back_work_hours/60))." H  : ".($e->back_work_hours%60)." m)";

			$e->position=position::find($e->position_id)->part_project;
			$employee_details[]=$e;
			$employee_id[]=$e->id;
		}


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

		$details_task=[];
		$project->work_hours="(".(intval($project->work_hours/60))." H  : ".($project->work_hours%60)." m)";

		$project->tasks=DB::select("select * from tasks where project_id=".$project->id." order by start_date");

		foreach($project->tasks as $e){
			$emp=employee::find($e->employee_id);
			$e->employee_name=$emp->first_name." ".$emp->last_name;
			$e->employee_image=$emp->image;
			$e->position=position::find($emp->position_id)->part_project;
			$details_task[]=$e;
		}
		$project->tasks=$details_task;
		$project->employee_details=$employee_details;
		$employees=[];
		foreach(employee::all() as $e){
		  if(!in_array($e->id,$employee_id) && $e->user->role_id!=1){
			$e->position=position::find($e->position_id)->part_project;
			$user=user::find($e->user_id);
			if($user->role_id!=1){
					$employees[]=$e;
					}
		  }
		}
		$currency=currency::all();

		$project->priceSY=$project->cost;
		$project->cost=$project->priceSY/(currency::orderBy('created_at', 'desc')->first()->sp_value);

		return view('admin.cproject',['project'=>$project,"clients"=>$clients,"currencies"=>$currency,'employee'=>$employee,'employees'=>$employees]);
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
			'project_name' => 'required|unique:projects|max:255',
			'client_id' => 'required',
			]);

			$input = $request->all();
			$project=project::where('project_name',$request->project_name)->first();
			$project->fill($input)->save();
		 $client=client::find($request->client_id);
		 if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $project->id.$img->getClientOriginalName();
                    $project->image=$filename;
                    $location = storage_path('app/public/quotation/') . $filename;
                    Image::make($img)->save($location);
                }
		$project->save();
		$client->projects()->save($project);
		return redirect()->route('project.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $employee=employee::where('user_id',user::find(Auth::user()->id)->id)->first();
		$project=project::find($id);
		// project->tasks
		// project->employees



		$project->employees=$project->employees;
		$work_hours=DB::select("select sum(hours) as all_hours from employee_project where project_id=".$project->id);
		if(count($work_hours)==0){
			$project->work_hours=0;
			}
		else{
			$project->work_hours=$work_hours[0]->all_hours;
		}
		$over=$project->expected_hours-$project->work_hours;
		$project->over=0;
		if($over<0){
			$project->over=$over*-1;
		}
		$project->employees=$project->employees;
		$employee_details=[];

		foreach($project->employees as $e){
			$details=DB::select("select * from employee_project where employee_id=".$e->id." and project_id=".$id);
			$e->expected_hours=$details[0]->expected_hours;
			$e->backup_hours=$details[0]->backup_hours;
			$e->work_hours=$details[0]->hours;
			$e->timeline=($e->work_hours/($e->expected_hours*60))*100;


			$e->style="success";
			if($e->timeline >60){
					$e->style="warning";
				}
			if($e->timeline >95){
					$e->style="danger";

				}
			if($e->work_hours > (60*$e->expected_hours)){
				$e->work_hours=$e->expected_hours*60;
				$e->back_work_hours=$details[0]->hours-($e->expected_hours*60);
			}
			else{
				$e->back_work_hours=0;
			}

			$e->work_hours="(".(intval($e->work_hours/60))." H  : ".($e->work_hours%60)." m)";
			$e->back_work_hours="(".(intval($e->back_work_hours/60))." H  : ".($e->back_work_hours%60)." m)";

			$employee_details[]=$e;
		}


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

		$details_task=[];
		$project->work_hours="(".(intval($project->work_hours/60))." H  : ".($project->work_hours%60)." m)";

		$project->tasks=DB::select("select * from tasks where project_id=".$project->id." order by start_date desc");

		foreach($project->tasks as $e){
			$emp=employee::find($e->employee_id);
			$e->employee_name=$emp->first_name." ".$employee->last_name;
			$e->employee_image=$emp->image;
			$details_task[]=$e;
		}
		$project->tasks=$details_task;
		$project->employee_details=$employee_details;
		$employees=employee::all();
		$project->priceSY=$project->cost*(currency::orderBy('created_at', 'desc')->first()->sp_value);

		return view('admin.project',['employees'=>$employees,'employee'=>$employee,'project'=>$project]);
    }

            public function mytask($id)
                {
		            try{
				$employee=employee::where('user_id',Auth::user()->id)->first();
				$project=project::find($id);
				$info=DB::select("select * from employee_project where project_id= ".$project->id." and employee_id =".$employee->id);

				$info[0]->style="success";
				$info[0]->overtime=0;
				$info[0]->remaining=($info[0]->hours/(60*$info[0]->expected_hours))*100;
				if($info[0]->hours >$info[0]->expected_hours){
					$info[0]->overtime=$info[0]->hours-$info[0]->expected_hours;
				}
				if(($info[0]->hours/(60*$info[0]->expected_hours))*100 > 60){
					$info[0]->style="warning";
				}
				if(($info[0]->hours/(60*$info[0]->expected_hours))*100 > 90){
					$info[0]->style="danger";
				}

				$dateFrom=\Carbon\Carbon::createFromFormat('Y-m-d',$project->start_date);
				$dateTo=\Carbon\Carbon::createFromFormat('Y-m-d',$project->end_date);
				$now=\Carbon\Carbon::createFromFormat('Y-m-d', date("Y-m-d", time()));
				$project->style="success";
				if($dateTo > $now){
						$diff=$dateFrom->diffInDays($dateTo);
						$diff_now=$dateFrom->diffInDays($now);
						$project->remaining=($diff_now/$diff)*100;
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
				if($info[0]->hours > (60*$info[0]->expected_hours)){
					$info[0]->back_work_hours=$info[0]->hours-($info[0]->expected_hours*60);
						$info[0]->hours=60*$info[0]->expected_hours;

					}
					else{
						$info[0]->back_work_hours=0;
					}
				$project->info=$info[0];

				$info[0]->hours="(".(intval($info[0]->hours/60))." H  : ".($info[0]->hours%60)." m)";
				$info[0]->back_work_hours="(".(intval($info[0]->back_work_hours/60))." H  : ".($info[0]->back_work_hours%60)." m)";
				$project->employees=$project->employees;
				$tasks=task::where('employee_id',$employee->id)->where('project_id',$project->id)->get();
				$in_task=task::where('employee_id',$employee->id)->where('project_id',$project->id)->where('status','start')->get();
				$have_task=task::where('employee_id',$employee->id)->where('status','start')->get();
				$pid = $id;
		}catch(\Exception $e){
			return redirect("/");
		}
		$employee->have_task=false;
	   if(count($have_task)!=0 ){
		   if($have_task[0]->project_id != $project->id){
		   $employee->message_task='You starting new task in '.project::find($have_task[0]->project_id)->project_name;
		   $employee->have_task=true;
		   }

	  }
		return view("employees.Project",["in_task"=>$in_task,"employee"=>$employee,"tasks"=>$tasks,"project"=>$project, 'pid'=>$pid]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(project $project)
    {
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= task::where('employee_id',$employee->id)->orderBy('created_at','desc')->get();
		$employee->attendances= $employee->attendances;
        $projects=project::all();
		 $arr = array();
        foreach($projects as $d){

             $arr[] = array(
			 'id' => $d->id,
                'project_name' => $d->project_name,
                'start_date' => $d->start_date,
				'end_date' => $d->end_date,
				'price' =>$d->price,

                'admin_hours' => $d->admin_hours,
				'expected_hours' => $d->expected_hours,
				'image' =>$d->image,
				'client' =>client::withTrashed()->where('id', $d->client_id)->first()->compnay_name,

            );
        }
		//$clients=client::all();

        $selectedClients=client::find( $project->client_id);

        $clients=client::where("id","!=", $project->client_id)->get();

		$projects=$arr;
		$currency=currency::find($project->currency_id);
		$client=client::find($project->client_id);
		$project->currency=$currency;
		$project->client=$client;
		$currency=currency::all();

		return view('admin.projects',["project"=>$project,"clients"=>$clients,"currencies"=>$currency,"projects"=>$projects,"employee"=>$employee,"selectedClients"=>$selectedClients]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, project $project)
    {
		$input = $request->all();
		$project->fill($input)->save();
		$client=client::find($request->client_id);
		if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $project->id.$img->getClientOriginalName();
					File::delete( storage_path('app/public/quotation/' . $project->image));
                    $project->image=$filename;
                    $location = storage_path('app/public/quotation/') . $filename;
                    Image::make($img)->save($location);
                }
		$project->save();
		$client->projects()->save($project);
		return redirect()->route('project.index');

        //
    }
 public function update_employee(Request $request)
    {
		$project=project::find($request->project_id);
		$input = $request->except(['set','project_id','employees','back','hours','image']);
		$project->fill($input)->save();

		//////// employee array


		$employees=json_decode($request->employees);
		$hours=json_decode($request->hours);
		$back=json_decode($request->back);

		for ($i=0;$i<count($employees);$i++){
			$employee_in=employee::find($employees[$i]);
			$found_it=DB::select("select * from employee_project where employee_id=".$employee_in->id." and project_id=".$project->id);
			if(count($found_it)==0){
			 $projects=[];
			 $projects[]=$project->id;

			 $employee_in->projects()->attach($projects,['expected_hours'=>$hours[$i],'backup_hours'=>$back[$i]]);
			}
		}

		////

		 $client=client::find($request->client_id);
		 if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $project->id.$img->getClientOriginalName();
                    $project->image=$filename;
                    $location = storage_path('app/public/project/') . $filename;
                    Image::make($img)->save($location);
                }
		$project->save();
		$client->projects()->save($project);

		return response()->json(['project' => $project], 200);

        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */


  /*  public function destroy(project $project)
    {
		$project->delete();
		//File::delete(storage_path('app/public/project/' . $project->image));
		return response()->json(['project' => $project], 200);
        //
    }

*/

    public function destroy( $id)
    {

        $project=project::find($id);
		$project->delete();

		return redirect()->back();
        //
    }

    public function restore( $id)
    {
        $project= project::withTrashed()->where('id',$id)->first();
        $project->restore();
        return redirect()->back();

    }

    public function trashed()
    {
        $project= project::onlyTrashed()->get();

         return view('admin.trashed_project')->with('projects',$project);
    }




}
