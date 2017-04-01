<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
class AddminMiddleware
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
        if(Auth::user()->roles !=null){
            foreach(Auth::user()->roles as $role){
                if($role->permission=='admin'){
                    return $next($request);
                }
            }
        }
        return response("Insufficient Permission");

    }
}
