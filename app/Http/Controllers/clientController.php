<?php

namespace App\Http\Controllers;

use App\Models\client;
use Illuminate\Http\Request;
use App\Models\employee;
use App\Models\user;
use Auth;
use Image;
use Storage;
use File;
use DB;
class clientController extends Controller
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
		$clients=client::all();
		$arr = array();
        foreach($clients as $d){
             $arr[] = array(
			      'id' => $d->id,
                'compnay_name' => $d->compnay_name,
                'country' => $d->country,
				'working_domain' => $d->working_domain,
				 'position' => $d->position,
                'name' => $d->first_name." ".$d->last_name,
				'company_phone' => $d->company_phone,

            );
        }
		$clients=$arr;
		return view('admin.clients',['clients'=>$clients,'employee'=>$employee]);
    }

 public function pagination_ajax(Request $r)
    {
        $start = $r->get('start');
        $length = $r->get('length');
        $search = $r->get('search');

        /* Get [Some-Data] from DB */
        /* Obj */
        $data = client::select('*')
        ->where('compnay_name','like','%'.$search['value'].'%')
        ->skip($start)
        ->take($length)
        ->get();

        /* To send (data) to ->(view.index).
            I need to convert from Obj to [Arr-of-Arr]. */
        $arr = array();
        foreach($data as $d){
             $arr[] = array(
                'compnay_name' => $d->compnay_name,
                'country' => $d->country,
				'working_domain' => $d->working_domain,
				 'position' => $d->position,
                'name' => $d->first_name." ".$d->last_name,
				'company_phone' => $d->company_phone,
                'action' => "
                            <a href='client/".$d->id."/edit' style='color:#377CDB;'><i class='fas fa-edit'></i>Edit</a>

                            ",
                'delete' => "<a href='client/".$d->id."/destroy' style='color:#DC3545;'><i class='fas fa-trash'></i>Delete</a>"
            );
        }
        /* The count of [All-Data] */
        $total_members = client::count();
        $count = DB::select("select * from clients where compnay_name like '%".$search['value']."%'");
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
		return view('client.create');
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
			'compnay_name' => 'required|unique:clients|max:255',
			'phone' => 'required',
			]);

		 $client=client::create($request->all());

		 if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $client->id.$img->getClientOriginalName();
                    $client->image=$filename;
                    $location = storage_path('app/public/client/') . $filename;
                    Image::make($img)->save($location);
                }
		$client->save();

		return redirect()->route('client.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		$client=client::find($id);
		// $client->projects
		return $client;
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(client $client)
    {
		$employee=employee::where('user_id',Auth::user()->id)->first();
		$employee->projects=$employee->projects;
		$employee->tasks= $employee->tasks;
		$employee->attendances= $employee->attendances;
		$clients=client::all();
		return view('admin.clients',['clients'=>$clients,'employee'=>$employee,'client'=>$client]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, client $client)
    {
		$input = $request->all();
		$client->fill($input)->save();
		if( $request->hasFile('image'))
                {
                    $img = $request->file('image');
                    $filename =  $client->id.$img->getClientOriginalName();
					File::delete( storage_path('app/public/client/' . $client->image));
                    $client->image=$filename;
                    $location = storage_path('app/public/client/') . $filename;
                    Image::make($img)->save($location);
                }
		$client->save();

		return redirect()->route('client.index');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {

        $client=client::find($id);
		$client->delete();
		//File::delete(storage_path('app/public/client/' . $client->image));
		return redirect()->back();
        //
    }

    public function restore( $id)
    {
        $client= client::withTrashed()->where('id',$id)->first();
        $client->restore();
        return redirect()->back();

    }

    public function trashed()
    {
        $clients= client::onlyTrashed()->get();

         return view('admin.trashed')->with('clients',$clients);
    }

}
