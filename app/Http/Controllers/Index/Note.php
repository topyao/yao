<?php


namespace App\Http\Controllers\Index;


use App\Models\Notes;
use Yao\Facade\Request;

class Note
{

    public function __construct()
    {
        $this->notesModel = new Notes();
    }

    public function read($id)
    {
        try {
            $note = $this->notesModel->oneNote($id);
            $hots = $this->notesModel->hots();
        } catch (\Exception $e) {
            return view('index/404');
        }
        if (false === $note) {
            return view('index/404');
        }
        return view('index/notes/read', compact(['note', 'hots']));
    }


    public function list($page = 1)
    {
        $notes = $this->notesModel->list(['id', 'title', 'text'], $page, 15);
        $hots = $this->notesModel->hots();
        return view('index/notes/list', compact(['notes', 'hots']));
    }

    public function create()
    {
        if (Request::isMethod('get')) {
            return view('index/notes/add');
        }
        $data = Request::post();
        try {
            $this->notesModel->insert($data);
        } catch (\Exception $e) {
            return '新增失败';
        }
        return redirect('/notes');
    }


    public function edit($id = null)
    {
        if (Request::isMethod('get')) {
            $note = $this->notesModel->oneNote($id);
            return view('index/notes/edit', compact(['note']));
        }
        $note = Request::post(['title', 'text']);
        $note['update_time'] = date('Y-m-d h:i:s');
        if ($this->notesModel->update($id, $note)) {
            return redirect('/notes');
        } else {
            return view('index/404');
        }
    }

}