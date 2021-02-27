<?php


namespace App\Models;


use Yao\Database\Model;
use Yao\Facade\Db;

class Comments extends Model
{

    private const NUMBER_OF_PAGES = 5;

    public function add($data)
    {
        return $this->insert($data);
    }

    public function read($id, $page = 1, int $order = 0)
    {
        $orders = ['create_time DESC', 'hearts DESC,create_time DESC'];
        $order = $orders[$order] ?? $orders[0];
        $limit = self::NUMBER_OF_PAGES;
        $offset = ($page - 1) * $limit;
        $comments = Db::query("select c.id,replace(c.comment,'{狗头}','<img src=\"/static/img/dog.gif\" style=\"width:1.5em;height:1.5em\">') as comment,UNIX_TIMESTAMP(create_time) create_time,c.name,count(f.user_id) hearts from comments c left join hearts f on c.id = f.comment_id where note_id = ? AND parent_id IS NULL group by c.id order by {$order} limit {$offset},{$limit}", [$id]);
        $ids = array_reduce($comments, function ($ids, $comment) {
            $ids[] = $comment['id'];
            return $ids;
        });
        $ids = $ids ? '(' . implode(',', $ids) . ')' : '(null)';
        $sub_comments = Db::query("select c.id,c.parent_id,replace(c.comment,'{狗头}','<img src=\"/static/img/dog.gif\" style=\"width:1.5em;height:1.5em\">') as comment,UNIX_TIMESTAMP(create_time) create_time,c.name,count(f.user_id) hearts from comments c left join hearts f on c.id = f.comment_id where parent_id in {$ids} group by c.id order by {$order}", [$id]);
        return ['top' => $comments, 'sub' => $sub_comments];
//        dump($sub_comments);
//        return Db::query("select c.id,replace(c.comment,'{狗头}','<img src=\"/static/img/dog.gif\" style=\"width:1.5em;height:1.5em\">') as comment,UNIX_TIMESTAMP(create_time) create_time,c.name,count(f.user_id) hearts from comments c left join hearts f on c.id = f.comment_id where note_id = ? group by c.id order by {$order} limit {$offset},{$limit}", [$id]);
    }

    public function has($field, $value)
    {
        return !$this->where([$field => $value])->find()->isEmpty();
    }

    public function count($id)
    {
        return $this->where(['note_id' => $id])->count('*');
    }

}