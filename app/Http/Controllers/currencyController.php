<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Models\user;
use Auth;
use App\Models\currency;
use Illuminate\Http\Request;
use Image;

use Storage;

class currencyController extends Controller
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
		$currencies=currency::all();
		return view('admin.currency',['currencies'=>$currencies,'employee'=>$employee]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		return view('currency.create');
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
			'us_value' => 'required',
			'sp_value' => 'required',
			]);
		
		 $currency=currency::create($request->all());
		 
		 if( $request->hasFile('image'))
                { 
                    $img = $request->file('image'); 
                    $filename =  $currency->id.$img->getClientOriginalName();
                    $$currency->image=$filename;
                    $location = storage_path('app/public/currency/') . $filename;
                    Image::make($img)->save($location);
                } 
		$currency->save();
		
		return redirect()->route('currency.index');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(currency $currency)
    {
		return view('currency.edit',["currency"=>$currency]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, currency $currency)
    {
		$input = $request->all();
		$currency->fill($input)->save();
		if( $request->hasFile('image'))
                { 
                    $img = $request->file('image'); 
                    $filename =  $currency->id.$img->getClientOriginalName();
					File::delete( storage_path('app/public/currency/' . $currency->image));
                    $currency->image=$filename;
                    $location = storage_path('app/public/currency/') . $filename;
                    Image::make($img)->save($location);
                } 
		$currency->save();
		
		return response()->json(['currency' => $currency], 200);
		
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(currency $currency)
    {
		$currency->delete();
		//File::delete(storage_path('app/public/currency/' . $currency->image));
		return response()->json(['currency' => $currency], 200);
        //
    }
}
