<?php

namespace App\Http\Controllers\Index;

use App\Http\{Controller, Traits\Paginate};
use App\Models\Notes;

class Index extends Controller
{

    use Paginate;

    public function index(Notes $notes)
    {
        $file = './stat.txt';
        if (!file_exists($file)) {
            file_put_contents($file, 1);
        }
        $stat = file_get_contents($file) ?: 1;
        file_put_contents($file, ++$stat);
        return view('index/index', compact(['stat']));
    }
}
