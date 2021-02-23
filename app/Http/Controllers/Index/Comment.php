<?php


namespace App\Http\Controllers\Index;


use App\Http\Controller;
use App\Models\Comments;
use App\Models\Hearts;
use Yao\Facade\Session;

class Comment extends Controller
{
    public function create(Comments $comments)
    {
        $comment = $this->request->post(['comment', 'note_id', 'name' => 'zhangsan']);
        try {
            $id = $comments->add($comment);
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'InvalidArgument.'];
        }
        return ['status' => 1, 'message' => 'Success', 'id' => $id];
    }

    public function heart($id, Hearts $hearts)
    {
        $user_id = $this->request->ip();
        if ($hearts->has($id, $user_id)->isEmpty()) {
            $hearts->add($id, $user_id);
            return ['status' => 1, 'message' => '喜欢成功!'];
        }
        $hearts->remove($id, $user_id);
        return ['status' => 0, 'message' => '取消喜欢成功!'];
    }
}