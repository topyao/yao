<?php

namespace App\Http\Middleware;

class Login
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);
        return $response;
    }
}
