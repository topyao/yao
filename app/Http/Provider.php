<?php


namespace App\Http;

use Yao\Services\Development;

class Provider extends \Yao\Provider
{
    public function services()
    {
        return [
            Development::class
        ];
    }
}
