<?php


namespace App\Http;

class Provider extends \Yao\Provider
{
    public function services()
    {
        return [
            //线上环境可以删除
            \Yao\Services\Development::class
        ];
    }
}
