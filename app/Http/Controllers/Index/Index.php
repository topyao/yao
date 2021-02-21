<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller, Traits\Paginate};
use App\Models\Notes;

class Index extends Controller
{

    use Paginate;

//    public $middleware = [
//        Login::class => ['index'],
//        IsLogin::class => ['index']
//    ];

    public function index(Notes $notes)
    {
        $file = './stat.txt';
        if (!file_exists($file)) {
            file_put_contents($file, 1);
        }
        $stat = file_get_contents($file) ?: 1;
        file_put_contents($file, ++$stat);
        $numberOfPages = 15;
        $page = $this->request->get('p', 1);
        $totalPage = ceil($notes->total() / $numberOfPages);
        $paginate = $this->_paginate($page, $totalPage, $numberOfPages);
        $hots = $notes->hots();
        $notes = $notes->list(['id', 'title', 'text'], $page, $numberOfPages);
        return view('index/index', compact(['notes', 'hots', 'paginate', 'stat']));
    }

    public function test()
    {
        dump($this->request->server('path_info'));
    }
}
