<?php

namespace App\Models;

use Yao\Facade\Db;
use Yao\Database\Model;
use Endroid\QrCode\QrCode;
use Yao\Facade\Session;

class Notes extends Model
{
    public function oneNote($id)
    {
        $note = $this->field(['title', 'id', 'text', 'hits', 'tags', 'UNIX_TIMESTAMP(`create_time`) create_time', 'user_id'])
            ->where(['id' => $id])
            ->find()
            ->throwWhenEmpty(true);
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
        $this->where(['id' => $id, 'user_id' => Session::get('user.id')])->delete();
        return true;
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
            ->order(['create_time' => 'DESC'])
            ->limit($limit, ($page - 1) * $limit)
            ->select()
            ->toArray();
    }

    public function search($kw, $limit, $offset)
    {
        return Db::query("SELECT title,text,hits,id,UNIX_TIMESTAMP(`create_time`) create_time FROM notes WHERE `title` LIKE ? OR MATCH(`title`,`text`) AGAINST(? IN BOOLEAN MODE) ORDER BY create_time LIMIT {$offset},{$limit}", ["%{$kw}%", "{$kw}"]);
    }

    public function searchCount($kw)
    {
        return Db::query("SELECT count(*) FROM notes WHERE `title` LIKE ? OR MATCH(`title`,`text`) AGAINST(? IN BOOLEAN MODE)", ["%{$kw}%", "{$kw}"])[0]['count(*)'];

    }

}