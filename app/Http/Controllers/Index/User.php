<?php


namespace App\Http\Controllers\Index;


use Yao\Facade\Request;

class User
{
    public function login()
    {
        if(Request::isMethod('get')){
            return view('index/users/login');
        }
        $user = Request::post(['username','password']);

    }
}