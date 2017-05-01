<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class LeaderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            foreach (Auth::user()->roles as $role){
                if(strtolower($role->permission)=='leader'){
                    return $next($request);
                }
            }
        }
        Auth::logout();
        return redirect()->route('login');

    }
}
