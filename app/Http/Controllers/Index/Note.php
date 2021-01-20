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
        $note = $this->notesModel->oneNote($id);
        if (false === $note) {
            return redirect('/');
        }
        return view('index/notes/read', $note);
    }

    public function list($fields = null)
    {
        return $this->notesModel->list();
    }

    public function create()
    {
        if (Request::isMethod('get')) {
            return view('index/notes/create');
        }
        $data = Request::post();
        try {
            $insertId = $this->notesModel->insert($data);
        } catch (\Exception $e) {
            return '新增失败';
        }
    }

}