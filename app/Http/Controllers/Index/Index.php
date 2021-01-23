<?php

namespace App\Http\Controllers\Index;

use App\Models\Notes;

class Index
{
    public function __construct()
    {
        $this->notesModel = new Notes();
    }

    public function index($page = 1)
    {
        $notes = $this->notesModel->list(['id', 'title', 'text'], $page, 15);
        $hots = $this->notesModel->hots();
        return view('index/index', compact(['notes', 'hots']));
    }
}
