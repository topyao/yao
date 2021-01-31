<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Http\Middleware\IsLogin;
use App\Http\Traits\Paginate;
use App\Http\Validate;
use App\Models\Notes;
use Yao\App;
use Yao\Container;
use Yao\Http\Request;

class Index extends Controller
{

    use Paginate;

    public $middleware = IsLogin::class;

    public function index(Notes $notes, Request $request)
    {
        $numberOfPages = 15;
        $page = $request->get('p', 1);
        $totalPage = ceil($notes->total() / $numberOfPages);
        $paginate = $this->_paginate($page, $totalPage, $numberOfPages);
        $hots = $notes->hots();
        $notes = $notes->list(['id', 'title', 'text'], $page, $numberOfPages);
        return view('index/index', compact(['notes', 'hots', 'paginate']));
    }

    public function test()
    {
        App::invokeMethod([\Test::class, 'do']);
    }
}
