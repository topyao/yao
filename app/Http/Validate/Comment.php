<?php


namespace App\Http\Validate;


use App\Http\Validate;

class Comment extends Validate
{
//comment', 'note_id', 'name' => 'zhangsan'

    protected array $rule = [
        'comment' => ['required' => true, 'length' => [10,200]],
        'note_id' => ['required'=> true]
    ];

    protected array $notice = [
        'comment' => ['require' => '评论必填!', 'length' => '长度为10-200'],
        'note_id' => ['require'=> '缺少note_id']
    ];
}