<?php

namespace App\Models;

use Yao\Database\Model;
use Yao\Facade\Db;

class Users extends Model
{
    public function login($user)
    {
        return Db::name('users')->where($user)->find()->throwWhenEmpty(true)->toArray();
    }

    public function one($condition)
    {
        return $this->where($condition)->find()->toArray();
    }
}