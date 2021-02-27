<?php


namespace App\Http\Controllers\Index;


use App\Http\Controller;
use App\Http\Middleware\Login;
use App\Http\Traits\Paginate;
use App\Models\Comments;
use App\Models\Notes;
use Yao\Facade\Session;

class Note extends Controller
{

    use Paginate;

    protected $middleware = [
        Login::class => [
            'edit', 'create'
        ]
    ];

    private const NUMBER_OF_PAGES = 8;

    public function read($id, Notes $notes, Comments $comments)
    {
        $order = $this->request->get('order', 0);
        try {
            $note = $notes->oneNote($id);
            $comments_count = $comments->count($id);
            $comments = $comments->read($id, 1, $order);
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
        return view('index/notes/read', compact(['note', 'hots', 'comments', 'comments_count']));
    }


    public function list(Notes $notes)
    {
        $page = (int)$this->request->get('p', 1);
        $totalPage = ceil($notes->total() / self::NUMBER_OF_PAGES);
        $paginate = $this->_paginate($page, $totalPage, self::NUMBER_OF_PAGES);
        $hots = $notes->hots();
        $notes = $notes->list(['id', 'title', 'text'], $page, self::NUMBER_OF_PAGES);
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
        $note = $notes->oneNote($id);
        if ($note['user_id'] !== Session::get('user.id')) {
            return view('index/error', ['message' => '没有权限']);
        }
        if ($this->request->isMethod('get')) {
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
        $totalPage = ceil($count / self::NUMBER_OF_PAGES);
        $page = (int)$this->request->get('p', 1);
        $notes = $notes->search($keyword, self::NUMBER_OF_PAGES, ($page - 1) * 8);
        $paginate = $this->_paginate($page, $totalPage, self::NUMBER_OF_PAGES);
        return view('index/notes/list', compact(['notes', 'hots', 'keyword', 'paginate', 'totalPage']));
    }
}