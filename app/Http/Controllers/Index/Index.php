<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller};
use Yao\Cache\Setter;

class Index extends Controller
{
//    protected $middleware = [
//        Login::class => ['index']
//    ];

    public function index(Setter $setter)
    {
        $stat = $setter->get('stat');
        return view('index/index', compact(['stat']));
    }

    public function log()
    {
        $file = env('storage_path') . 'logs/Exception/' . date('Ym') . '/' . date('d') . '.log';
        $log = [];
        if (file_exists($file)) {
            $log = file($file);
        }
        return view('index/log', ['log' => $log]);
    }
}
