<?php

namespace App\Http\Middleware;

use Yao\Facade\Session;

class Login
{
    public function handle($request, \Closure $next)
    {
        if(!Session::get('user')){
            return view('index/error');
        }
        $response = $next($request);
        return $response;
    }
}
