<?php


namespace App\Events;


use Yao\Facade\Request;

class End
{
    public function trigger()
    {
        //[debug] 这里可以使用事件，获取注册到该位置的事件执行
        if (defined('START_TIME')) {
            $timeConsuming = round(microtime(true) - START_TIME, 4) . 's';
            echo '框架运行时间：' . $timeConsuming . '<br>';
        }
        if (defined('START_MEMORY_USAGE')) {
            $usedMemory = round(((memory_get_usage() - START_MEMORY_USAGE) / 1024 / 1024), 2) . 'MB';
            echo '框架消耗内存：' . $usedMemory;
        }
        \Yao\Facade\Log::write('Visitors', '用户访问信息', 'notice', ['Method' => Request::method(), 'url' => Request::url(true), 'ip' => Request::ip(), 'referer' => Request::server('http_referer'), 'UA' => Request::header('user_agent'), 'time' => $timeConsuming, 'mem' => $usedMemory]);
    }
}