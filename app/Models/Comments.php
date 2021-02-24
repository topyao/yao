<?php


namespace App\Models;


use Yao\Database\Model;
use Yao\Facade\Db;

class Comments extends Model
{
    public function add($data)
    {
        return $this->insert($data);
    }

    public function read($id, $page = 1, $limit = 10)
    {
        return Db::query("select c.id,replace(c.comment,'{狗头}','<img src=\"/static/img/dog.gif\" style=\"width:1.5em;height:1.5em\">') as comment,create_time,c.name,count(f.user_id) hearts from comments c left join hearts f on c.id = f.comment_id where note_id = ? group by c.id order by hearts desc, create_time desc", [$id]);
    }

    public function has($field, $value)
    {
        return !$this->where([$field => $value])->find()->isEmpty();
    }

}