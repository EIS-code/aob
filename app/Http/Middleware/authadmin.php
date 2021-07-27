<?php

namespace App\Http\Middleware;

use Closure;
use Cookie;

class authadmin
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
        if(Cookie::has('login_token') && Cookie::has('admin_id') && Cookie::has('role_id')){
            session()->put('login_token',$request->cookie('login_token')); 
            session()->put('admin_id',$request->cookie('admin_id')); 
            session()->put('role_id',$request->cookie('role_id'));
        }
        if( !session()->has('admin_id') || !session()->has('login_token') || !session()->has('role_id') ){
            return redirect('admin');
        }
        return $next($request);
    }
}
