<?php


namespace App\Models;


use Yao\Facade\Db;
use Yao\Model;

class Notes extends Model
{
    public function oneNote($id)
    {
        $note = $this->field(['title', 'id', 'text', 'hits', 'tags', 'create_time'])
            ->where(['id' => $id])
            ->find()
            ->toArray();
        if (!empty($note)) {
            $this->where(['id' => $id])
                ->update(['hits' => $note['hits'] + 1]);
        }
        return $note;
    }

    public function total()
    {
        return $this->count('*');
    }

    public function hots($limit = 8)
    {
        return $this->field(['title', 'id'])
            ->order(['hits' => 'DESC', 'update_time' => 'DESC', 'create_time' => 'DESC'])
            ->limit($limit)
            ->select()
            ->toArray();
    }


    public function delete($id)
    {
        return $this->whereIn(['id' => $id])->delete();
    }

    public function insert($data)
    {
        return $this->insert($data);
    }

    public function update($id, $data)
    {
        return $this->where(['id' => $id])->update($data);
    }

    public function list($fields, $page, $limit)
    {
        return $this->field($fields)
            ->order(['update_time' => 'DESC', '`create_time`' => 'DESC', 'hits' => 'DESC'])
            ->limit(($page - 1) * $limit, $limit)
            ->select()
            ->toArray();
    }

    public function search($kw)
    {
        return Db::query("SELECT * FROM notes WHERE `title` LIKE ? OR MATCH(`title`,`text`) AGAINST(? IN BOOLEAN MODE)", ["%{$kw}%", "{$kw}"]);
    }

}