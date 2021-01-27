<?php


namespace App\Http\Validate;


use App\Http\Validate;

class LoginCheck extends Validate
{
    protected array $rule = [
        'username' => ['required' => true, 'length' => [5, 20]],
        'password' => ['required' => true]
    ];

    protected array $notice = [
        'username' => ['required' => '用户名不能未空！', 'length' => '用户名长度只能在5到20之间！'],
        'password' => ['required' => '密码不能未空！']
    ];
}