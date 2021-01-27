<?php


namespace App\Http\Controllers\Index;


use App\Http\Controller;
use App\Http\Validate\LoginCheck;
use App\Models\Users;
use Yao\Facade\Request;
use Yao\Facade\Session;

class User extends Controller
{

    public function login(Users $users)
    {
        if (Request::isMethod('get')) {
            return view('index/users/login');
        }
        $user = Request::post(['username', 'password']);
        $result = $this->validate(LoginCheck::class, $user);
        if ($result) {
            if ($users->login($user)) {
                Session::set('user', $user);
                redirect('/');
            } else {
                return view('index/error', ['message' => '用户名或者密码错误!']);
            }
        } else {
            return view('index/error', ['message' => $result]);
        }
    }
}