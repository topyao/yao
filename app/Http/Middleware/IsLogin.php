<?php


namespace App\Http\Middleware;


use Yao\Facade\Session;
use Yao\Http\Middleware;

class IsLogin extends Middleware
{
    public function handle($request, $next)
    {
        if (Session::get('user')) {
            return redirect('/');
        }
        return $next($request);
    }

}