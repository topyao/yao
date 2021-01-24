<?php


namespace App\Http\Controllers\Index;


use App\Models\Comments;
use App\Models\Notes;
use Yao\Container;
use Yao\Facade\Request;

class Note
{

    public function read($id, Notes $notes, Comments $comments)
    {
        if (Request::isMethod('get')) {
            try {
                $note = $notes->oneNote($id);
                $comments = $comments->read($id, 1, 10);
                if (!empty($note['tags'])) {
                    $note['tags'] = explode(',', $note['tags']);
                }
                $hots = $notes->hots();
            } catch (\Exception $e) {
                return view('index/404');
            }
            if (false === $note) {
                return view('index/404');
            }
            return view('index/notes/read', compact(['note', 'hots', 'comments']));
        }
        return Container::instance()->invoke('_comment', $id);
    }


    private function _comment($id, Comments $comments)
    {
        $comment = Request::post(['name', 'email', 'site', 'comment', 'note_id']);
        if ($this->$comments->add($comment)) {
            return redirect(url('list', [$id]), 302);
        }
    }

    public function list($page, Notes $note)
    {
        $notes = $note->list(['id', 'title', 'text'], $page, 15);
        $hots = $note->hots();
        return view('index/notes/list', compact(['notes', 'hots']));
    }

    public function create(Notes $notes)
    {
        if (Request::isMethod('get')) {
            return view('index/notes/add');
        }
        $data = Request::post(['title', 'text', 'tags']);
        try {
            $notes->insert($data);
        } catch (\Exception $e) {
            return '新增失败';
        }
        return redirect('/notes');
    }


    public function edit($id,Notes $notes)
    {
        if ('chengyao' == Request::get('pass')) {
            if (Request::isMethod('get')) {
                $note = $notes->oneNote($id);
                return view('index/notes/edit', compact(['note']));
            }
            $note = Request::post(['title', 'text', 'tags']);
            $note['update_time'] = date('Y-m-d h:i:s');
            if ($notes->update($id, $note)) {
                return redirect('/notes');
            } else {
                return view('index/404');
            }
        } else {
            return redirect('/');
        }
    }
}