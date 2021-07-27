<?php

namespace App\Http\Middleware;

use Closure;

class authuser
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
        if( !session()->has('user_id') || !session()->has('login_token') || !session()->has('role_id') ){
            return redirect('login');
        }
        return $next($request);
    }
}
