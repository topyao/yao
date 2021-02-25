<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller};
use Yao\Facade\Cache;

class Index extends Controller
{
//    protected $middleware = [
//        Login::class => ['index']
//    ];

    public function index()
    {
        $stat = Cache::get('stat');
        return view('index/index', compact(['stat']));
    }

    public function log()
    {
        $file = env('storage_path') . 'logs/Exception/' . date('Ym') . '/' . date('d') . '.log';
        $log = file($file);
        return view('index/log',['log' => $log]);
    }
}
