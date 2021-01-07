<?php

namespace App\Index\Middleware;

class Login
{
    public function handle($request, \Closure $next)
    {
        $response = $next($request);

        return $response;
    }
}
