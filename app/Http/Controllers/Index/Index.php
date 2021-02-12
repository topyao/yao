<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller, Middleware\IsLogin, Traits\Paginate};
use App\Models\Notes;

class Index extends Controller
{

    use Paginate;

    public $middleware = IsLogin::class;

    public function index(Notes $notes)
    {
        $numberOfPages = 15;
        $page = $this->request->get('p', 1);
        $totalPage = ceil($notes->total() / $numberOfPages);
        $paginate = $this->_paginate($page, $totalPage, $numberOfPages);
        $hots = $notes->hots();
        $notes = $notes->list(['id', 'title', 'text'], $page, $numberOfPages);
        return view('index/index', compact(['notes', 'hots', 'paginate']));
    }

    public function test()
    {
        dump($this->request->server('path_info'));
    }
}
