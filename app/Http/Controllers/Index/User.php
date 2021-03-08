<?php


namespace App\Http\Controllers\Index;


use App\Http\Controller;
use App\Http\Middleware\Logined;
use App\Http\Validate\LoginCheck;
use App\Models\Users;
use Yao\Facade\Session;

class User extends Controller
{

    protected $middleware = [
        Logined::class => [
            'login'
        ]
    ];

    public function login(Users $users)
    {
        if ($this->request->isMethod('get')) {
            return view('index/users/login');
        }
        $user = $this->request->post(['username', 'password']);
        $user['password'] = md5($user['password']);
        try {
            $this->validate(LoginCheck::class, $user)->check();
            $users->login($user);
        } catch (\Exception $e) {
            return view('index/error', ['message' => '用户名或者密码错误！']);
        }
        Session::set('user', $users->one($user));
        return redirect('/');
    }


    public function logout()
    {
        Session::destroy();
        return redirect($this->request->server('http_referer'));
    }

    public function create(Users $users)
    {
        if ($this->request->isMethod('get')) {
            return '';
        }
        $user = $this->request->post(['username', 'password']);
        $user['password'] = md5($user['password']);
        return $users->insert($user);
    }

}