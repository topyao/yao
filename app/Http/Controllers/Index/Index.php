<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use App\Models\Notes;

class Index extends Controller
{

    public function index(Notes $notes)
    {
        $hots = $notes->hots();
        $notes = $notes->list(['id', 'title', 'text'], 1, 15);
        return view('index/index', compact(['notes', 'hots']));
    }

    public function test(Notes $notes)
    {
        $notes->where(['a' => 1])->select();
    }
}
