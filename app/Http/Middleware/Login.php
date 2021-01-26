<?php

namespace App\Http\Middleware;

use Yao\Facade\Session;

class Login
{
    public function handle($request, \Closure $next)
    {
        if(!Session::get('user')){
            return view('index/404');
        }
        $response = $next($request);
        echo 'yyy';
        return $response;
    }
}
