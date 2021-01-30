<?php


namespace App\Http\Middleware;


use Yao\Facade\Session;

class IsLogin
{
    public function handle($request, $next)
    {
        if (Session::get('user')) {
            return redirect('/');
        }
        return $next($request);
    }

}