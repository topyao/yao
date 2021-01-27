<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;

class Index extends Controller
{

    public function index(\App\Models\Notes $note)
    {
        $notes = $note->list(['id', 'title', 'text'], 1, 15);
        $hots = $note->hots();
        return view('index/index', compact(['notes', 'hots']));
    }
}
