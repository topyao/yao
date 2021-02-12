<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use Yao\Http\Request;

class Index extends Controller
{
    public function index(Request $request)
    {
        abort('可以开始了！', 200);
    }

    public function test()
    {
        dump($this->request->get());
    }

    public function check()
    {
        $this->validate();
        dump($this->app->get());
    }
}
