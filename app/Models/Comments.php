<?php


namespace App\Models;


use Yao\Facade\Db;

class Comments
{
    public function add($data)
    {
        return Db::name('comments')
            ->insert($data);
    }

    public function read($id, $page = 1, $limit = 10)
    {
        return Db::name('comments')
            ->where(['note_id' => $id])
            ->order(['id' => 'DESC'])
            ->limit(($page - 1) * $limit, $limit)
            ->select()
            ->toArray();
    }
}