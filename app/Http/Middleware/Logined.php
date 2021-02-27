<?php


namespace App\Http\Middleware;

use Yao\Contracts\Middleware;
use Yao\Facade\Session;

class Logined implements Middleware
{
    public function handle($request, \Closure $next)
    {
        if (Session::has('user.id')) {
            return view('index/error', ['message' => '已经登录了']);
        }
        return $next($request);
    }

}