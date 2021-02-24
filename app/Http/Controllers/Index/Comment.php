<?php


namespace App\Http\Controllers\Index;


use App\Http\Controller;
use App\Models\Comments;
use App\Models\Hearts;

class Comment extends Controller
{
    public function create(Comments $comments)
    {
        $comment = $this->request->post(['comment', 'note_id', 'name' => '匿名用户']);
        try {
            $this->validate(\App\Http\Validate\Comment::class, $comment)->throwAble(true)->check();
            $id = $comments->add($comment);
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => $e->getMessage()];
        }
        return ['status' => 1, 'message' => 'Success', 'id' => $id];
    }

    public function heart($id, Hearts $hearts, Comments $comments)
    {
        if (!$comments->has('id', $id)) {
            return ['status' => -1, 'message' => '评论不存在'];
        }
        $user_id = $this->request->ip();
        if ($hearts->has($id, $user_id)) {
            $hearts->remove($id, $user_id);
            return ['status' => 0, 'message' => '取消喜欢成功!'];
        }
        $hearts->add($id, $user_id);
        return ['status' => 1, 'message' => '喜欢成功!'];
    }
}