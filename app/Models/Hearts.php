<?php


namespace App\Models;


use Yao\Database\Model;

class Hearts extends Model
{
    public function add($id, $user_id)
    {
        $this->insert(['comment_id' => $id, 'user_id' => $user_id]);
    }

    public function has($id, $user_id)
    {
        return !$this->where(['comment_id' => $id, 'user_id' => $user_id])->find()->isEmpty();
    }

    public function remove($id, $user_id)
    {
        $this->where(['comment_id' => $id, 'user_id' => $user_id])->delete();
    }
}