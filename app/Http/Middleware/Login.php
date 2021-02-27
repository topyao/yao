<?php

namespace App\Http\Middleware;

use Yao\Facade\Session;

class Login
{
    public function handle($request, \Closure $next)
    {
        if (Session::has('user.id')) {
            $response = $next($request);
            return $response;
        }
        return view('index/error', ['message' => '没有登录']);
    }
}
