<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller, Traits\Paginate};
use App\Models\Notes;
use Yao\Facade\Cache;

class Index extends Controller
{

    use Paginate;

    public function index(Notes $notes)
    {
        try {
            $stat = (int)Cache::get('stat');
        } catch (\Exception $e) {
            $stat = 0;
        }
        Cache::set('stat', ++$stat);
        return view('index/index', compact(['stat']));
    }
}
