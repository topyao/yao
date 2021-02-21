<?php


namespace App\Http\Controllers\Index;


use App\Http\Controller;
use App\Http\Traits\Paginate;
use App\Models\Comments;
use App\Models\Notes;

class Note extends Controller
{

    use Paginate;

    public function read($id, Notes $notes, Comments $comments)
    {
        if ($this->request->isMethod('get')) {
            try {
                $note = $notes->oneNote($id);
                $comments = $comments->read($id, 1, 10);
                $hots = $notes->hots();
            } catch (\Exception $e) {
                return view('index/error', ['message' => '查询失败！']);
            }
            if (false === $note) {
                return view('index/error', ['message' => '结果为空！']);
            }
            if (!empty($note['tags'])) {
                $note['tags'] = explode(',', $note['tags']);
            }
            return view('index/notes/read', compact(['note', 'hots', 'comments']));
        }
        return $this->_comment($id, new Comments());
    }


    private function _comment($id, Comments $comments)
    {
        $comment = $this->request->post(['name', 'email', 'site', 'comment', 'note_id']);
        if ($comments->add($comment)) {
            return redirect(url('list', [$id]), 302);
        }
    }

    public function list(Notes $notes)
    {
        $page = $this->request->get('p');
        $numberOfPages = 8;
        $page = $this->request->get('p', 1);
        $totalPage = ceil($notes->total() / $numberOfPages);
        $paginate = $this->_paginate($page, $totalPage, $numberOfPages);
        $hots = $notes->hots();
        $notes = $notes->list(['id', 'title', 'text'], $page, $numberOfPages);
        return view('index/notes/list', compact(['notes', 'hots', 'paginate']));
    }


    public function create(Notes $notes)
    {
        if ($this->request->isMethod('get')) {
            return view('index/notes/add');
        }
        $data = $this->request->post(['title', 'text', 'tags']);
        try {
            $notes->create($data);
        } catch (\Exception $e) {
            return '新增失败';
        }
        return redirect('/');
    }


    public function edit($id, Notes $notes)
    {
        if ($this->request->isMethod('get')) {
            $note = $notes->oneNote($id);
            return view('index/notes/edit', compact(['note']));
        }
        $note = $this->request->post(['title', 'text', 'tags']);
        $note['update_time'] = date('Y-m-d h:i:s');
        if ($notes->update($id, $note)) {
            return redirect(url('read', [$id]));
        } else {
            return view('index/error');
        }
    }

    public function search(Notes $notes)
    {
        $keyword = $this->request->get('kw');
        if (empty($keyword)) {
            return view('index/error', ['message' => '关键词不存在！']);
        }
        $hots = $notes->hots();
        $count = $notes->searchCount($keyword);
        $numberOfPages = 8;
        $totalPage = ceil($count / $numberOfPages);
        $page = $this->request->get('p', 1);
        $notes = $notes->search($keyword, $numberOfPages, ($page - 1) * 8);
        $paginate = $this->_paginate($page, $totalPage, $numberOfPages);
        return view('index/notes/list', compact(['notes', 'hots', 'keyword', 'paginate', 'totalPage']));
    }
}