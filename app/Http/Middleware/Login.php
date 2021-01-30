<?php

namespace App\Http\Middleware;

use Yao\Facade\Session;

class Login
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        return $response;
    }
}
