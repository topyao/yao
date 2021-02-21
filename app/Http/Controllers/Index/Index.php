<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller, Middleware\Login};
use App\Models\Notes;
use Yao\Facade\Cache;

class Index extends Controller
{
//    protected $middleware = [
//        Login::class => ['index']
//    ];

    public function index(Notes $notes)
    {
        $stat = Cache::get('stat');
        return view('index/index', compact(['stat']));
    }
}
