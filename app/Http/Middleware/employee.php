<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\notification;
use Auth;
class employee
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
		if(Auth::user()->role_id == 1 ){
			
				  return redirect()->route('admin.dash');
			}
		config(['global.notifications' => notification::where("user_id",Auth::user()->id)->get()]);
        return $next($request);
    }
}
