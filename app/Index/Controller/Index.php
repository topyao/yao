<?php

namespace App\Index\Controller;

use Yao\{Http\Request};
use Yao\Facade\Route;

class Index
{
    public function index(Request $request)
    {
        abort('可以开始了', 200);
    }
}
