<?php


namespace App\Http\Controllers\Index;


use App\Http\Middleware\Login;
use App\Models\Comments;
use App\Models\Notes;
use Yao\Facade\Db;
use Yao\Facade\Request;

class Note
{

    public $middleware = [
        'edit' => Login::class,
    ];

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
        return $this->_comment($id, new Comments());
    }


    private function _comment($id, Comments $comments)
    {
        $comment = Request::post(['name', 'email', 'site', 'comment', 'note_id']);
        if ($comments->add($comment)) {
            return redirect(url('list', [$id]), 302);
        }
    }

    public function list($page, Notes $note)
    {
        $numberOfPages = 15;
        $total = Db::name('notes')->count('*');
        $totalPage = ceil($total / $numberOfPages);
        $paginate = $this->_paginate($page, $totalPage, $numberOfPages);

        $notes = $note->list(['id', 'title', 'text'], $page, $numberOfPages);
        $hots = $note->hots();
        return view('index/notes/list', compact(['notes', 'hots', 'totalPage', 'paginate']));
    }

    private function _paginate($page, $totalPage, $numberOfPages)
    {

        if ($page < 1 || $page > $totalPage) {
            return view('index/404');
        }

        $pages = [];
        for ($i = 1; $i >= 0; $i--) {
            if ($page - 1 - $i > 0) {
                $pages[$page - 1 - $i] = $page - 1 - $i;
            }
        }
        $pages[$page] = (int)$page;
        for ($i = 0; $i <= 1; $i++) {
            if ($page + 1 + $i <= $totalPage) {
                $pages[$page + 1 + $i] = $page + 1 + $i;
            }
        }
        $pages[key($pages)] = '首页';
        end($pages);
        $pages[key($pages)] = '尾页';
        $paginate = '';
        foreach ($pages as $page => $name) {
            $paginate .= '<li><a href="/notes/' . $page . '.html">' . $name . '</a></li>';
        }
        return $paginate;
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


    public function edit($id, Notes $notes)
    {
        if (Request::isMethod('get')) {
            $note = $notes->oneNote($id);
            return view('index/notes/edit', compact(['note']));
        }
        $note = Request::post(['title', 'text', 'tags']);
        $note['update_time'] = date('Y-m-d h:i:s');
        if ($notes->update($id, $note)) {
            return redirect(url('read', [$id]));
        } else {
            return view('index/404');
        }
    }

    public function search(Notes $notes)
    {
        $keyword = Request::get('kw');
        $hots = $notes->hots();
        $notes = $notes->search($keyword);

        $page = Request::get('p', 1);
        $numberOfPages = 15;
        $total = Db::name('notes')->whereLike(['title' => '%' . $keyword . '%'])->count('*');
        $totalPage = ceil($total / $numberOfPages);
        $paginate = $this->_paginate($page, $totalPage, $numberOfPages);
        return view('index/notes/list', compact(['notes', 'hots', 'keyword', 'paginate', 'totalPage']));
    }
}