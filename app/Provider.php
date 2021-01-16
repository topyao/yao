<?php


namespace App;

class Provider extends \Yao\Provider\Provider
{
    public function services()
    {
        return [
            //线上环境可以删除
            \Yao\Provider\Services\Development::class
        ];
    }
}
