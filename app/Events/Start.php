<?php

namespace App\Events;

class Start
{
    public function trigger()
    {
        define('START_TIME', microtime(true));
        define('START_MEMORY_USAGE', memory_get_usage());
    }
}