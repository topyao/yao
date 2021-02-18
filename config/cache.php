<?php

return [
    //缓存类型
    'default' => 'redis',
    // redis缓存
    'redis' => [
        'host' => 'localhost',
        'port' => 6379,
        'auth' => 'cheng',
    ],
    //文件缓存
    'file' => [

    ],
    //memcached缓存
    'memcached' => [
        'host' => 'localhost',
        'port' => 11211
    ]
];