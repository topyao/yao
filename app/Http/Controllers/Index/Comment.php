<?php


namespace App\Http\Controllers\Index;


use App\Http\Controller;
use App\Models\Comments;

class Comment extends Controller
{
    public function create(Comments $comments)
    {
        $comment = $this->request->post(['comment', 'note_id','name' => 'zhangsan']);
        try {
            $id = $comments->add($comment);
        } catch (\Exception $e) {
            return ['status' => 0, 'message' => 'InvalidArgument.'];
        }
        return ['status' => 1, 'message' => 'Success', 'id' => $id];
    }
}