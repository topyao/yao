<?php

namespace App\Models;

use Yao\Facade\Db;
use Yao\Database\Model;
use Endroid\QrCode\QrCode;

class Notes extends Model
{
    public function oneNote($id)
    {
        $note = $this->field(['title', 'id', 'text', 'hits', 'tags', 'create_time'])
            ->where(['id' => $id])
            ->find();
        $note['qrcode'] = base64_encode((new QrCode('https://www.chengyao.xyz' . url('read', [$note['id']])))->writeString());
        $note = $note->toArray();
        if (!empty($note)) {
            $this->where(['id' => $id])
                ->update(['hits' => $note['hits'] + 1]);
        }
        return $note;
    }

    public function total()
    {
        return $this->value('count("*")');
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

    public function create($data)
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
            ->limit($limit, ($page - 1) * $limit)
            ->select()
            ->toArray();
    }

    public function search($kw, $limit, $offset)
    {
        return Db::query("SELECT * FROM notes WHERE `title` LIKE ? OR MATCH(`title`,`text`) AGAINST(? IN BOOLEAN MODE) LIMIT {$offset},{$limit}", ["%{$kw}%", "{$kw}"]);
    }

    public function searchCount($kw)
    {
        return Db::query("SELECT count(*) FROM notes WHERE `title` LIKE ? OR MATCH(`title`,`text`) AGAINST(? IN BOOLEAN MODE)", ["%{$kw}%", "{$kw}"])[0]['count(*)'];

    }

}