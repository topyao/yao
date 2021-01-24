<?php


namespace App\Http\Controllers\Index;


use App\Models\Comments;
use App\Models\Notes;
use Yao\Facade\Request;

class Note
{

    public function __construct()
    {
        $this->notesModel = new Notes();
        $this->commentsModel = new Comments();
    }

    public function read($id)
    {
        if (Request::isMethod('get')) {
            try {
                $note = $this->notesModel->oneNote($id);
                $comments = $this->commentsModel->read($id, 1, 10);
                if (!empty($note['tags'])) {
                    $note['tags'] = explode(',', $note['tags']);
                }
                $hots = $this->notesModel->hots();
            } catch (\Exception $e) {
                return view('index/404');
            }
            if (false === $note) {
                return view('index/404');
            }
            return view('index/notes/read', compact(['note', 'hots','comments']));
        }
        return $this->_comment($id);
    }


    private function _comment($id)
    {
        $comment = Request::post(['name', 'email', 'site', 'comment', 'note_id']);
        if ($this->commentsModel->add($comment)) {
            return redirect(url('list', [$id]), 302);
        }
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
        $data = Request::post(['title', 'text', 'tags']);
        try {
            $this->notesModel->insert($data);
        } catch (\Exception $e) {
            return '新增失败';
        }
        return redirect('/notes');
    }


    public function edit($id = null)
    {
        if ('chengyao' == Request::get('pass')) {
            if (Request::isMethod('get')) {
                $note = $this->notesModel->oneNote($id);
                return view('index/notes/edit', compact(['note']));
            }
            $note = Request::post(['title', 'text', 'tags']);
            $note['update_time'] = date('Y-m-d h:i:s');
            if ($this->notesModel->update($id, $note)) {
                return redirect('/notes');
            } else {
                return view('index/404');
            }
        } else {
            return redirect('/');
        }
    }
}