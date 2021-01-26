<?php

namespace App\Http\Controllers\Index;

class Index
{

    public function index(\App\Models\Notes $note)
    {
        $notes = $note->list(['id', 'title', 'text'], 1, 15);
        $hots = $note->hots();
        return view('index/index', compact(['notes', 'hots']));
    }
}
