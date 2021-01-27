<?php


namespace App\Models;


use Yao\Facade\Db;

class Users
{
    public function login($user)
    {
        return Db::name('users')->where($user)->find()->toArray();
    }
}