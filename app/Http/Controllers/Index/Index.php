<?php

namespace App\Http\Controllers\Index;

use App\Models\Notes;
use Yao\{Http\Request};
use Yao\Facade\Db;

class Index
{

    public function index(Request $request)
    {
        abort('可以开始了！', 200);
    }
}
