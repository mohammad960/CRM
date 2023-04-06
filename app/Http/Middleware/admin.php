<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;
use App\Models\notification;
class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		
		if(!Auth::check()){
		
				return redirect()->route('login');
			
		}
		
		if(Auth::user()->role_id != 1 ){
				return redirect()->route('login');
			}
		config(['global.notifications' => notification::where("user_id",Null)->where('type',Auth::user()->notification)->get()]);	
         return $next($request);
    }
}
