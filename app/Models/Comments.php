<?php


namespace App\Models;


use Yao\Database\Model;
use Yao\Facade\Db;

class Comments extends Model
{
    public function add($data)
    {
        return Db::name('comments')
            ->insert($data);
    }

    public function read($id, $page = 1, $limit = 10)
    {
        return Db::query('select c.*,count(f.user_id) hearts from comments c left join hearts f on c.id = f.comment_id where note_id = ? group by c.id order by hearts desc, create_time desc', [$id]);
    }

}