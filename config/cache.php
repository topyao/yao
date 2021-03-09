<?php

return [
    //缓存类型
    'default' => 'redis',
    // redis缓存
    'redis' => [
        'host' => 'localhost',
        'port' => 6379,
        //默认db
        'default' => 0,
        'auth' => 'cheng',
        'timeout' => 10,
        'retry' => 1
    ],
    //文件缓存
    'file' => [

    ],
    //memcached缓存
    'memcached' => [

    ]
];