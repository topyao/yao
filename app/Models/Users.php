<?php


namespace App\Models;


use Yao\Facade\Db;
use Yao\Model;

class Users extends Model
{
    public function login($user)
    {
        return Db::name('users')->where($user)->find()->toArray();
    }
}