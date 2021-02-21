<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller};
use App\Models\Notes;
use Yao\Facade\Cache;

class Index extends Controller
{
    public function index(Notes $notes)
    {
        $stat = Cache::get('stat');
        return view('index/index', compact(['stat']));
    }
}
