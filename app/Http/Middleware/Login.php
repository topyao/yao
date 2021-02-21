<?php

namespace App\Http\Middleware;

class Login
{
    public function handle($request, \Closure $next)
    {
//        echo 'login';
        $response = $next($request);
//        echo 'dfdf';
        return $response;
    }
}
