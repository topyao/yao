<?php


namespace App\Models;


use Yao\Facade\Db;

class Notes
{
    public function oneNote($id)
    {
        $note = Db::name('notes')
            ->field(['title', 'id', 'text', 'hits', 'tags', 'create_time'])
            ->where(['id' => $id])
            ->find()
            ->toArray();
        Db::name('notes')
            ->where(['id' => $id])
            ->update(['hits' => $note['hits'] + 1]);
        return $note;
    }


    public function hots($limit = 8)
    {
        return Db::name('notes')
            ->field(['title', 'id'])
            ->order(['hits' => 'DESC', 'update_time' => 'DESC', 'create_time' => 'DESC'])
            ->limit($limit)
            ->select()
            ->toArray();
    }


    public function delete($id)
    {
        return Db::name('notes')->whereIn(['id' => $id])->delete();
    }

    public function insert($data)
    {
        return Db::name('notes')->insert($data);
    }

    public function update($id, $data)
    {
        return Db::name('notes')->where(['id' => $id])->update($data);
    }

    public function list($fields, $page, $limit)
    {
        return Db::name('notes')
            ->field($fields)
            ->order(['`create_time`' => 'DESC', 'hits' => 'DESC'])
            ->limit(($page - 1) * $limit, $limit)
            ->select()
            ->toArray();
    }

}