<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller};
use App\Models\Notes;
use Yao\Facade\Cache;

class Index extends Controller
{
    public function index(Notes $notes)
    {
        try {
            $stat = (int)Cache::get('stat');
            Cache::set('stat', ++$stat);
        } catch (\Exception $e) {
            $stat = 0;
        }
        return view('index/index', compact(['stat']));
    }
}
