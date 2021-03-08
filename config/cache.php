<?php

return [

    //默认缓存类型
    'default' => 'redis',

    // redis缓存
    'redis' => [
        //主机
        'host' => '127.0.0.1',
        //端口
        'port' => 6379,
        //默认db
        'default' => 0,
        //连接超时时间
        'timeout' => 2,
        //认证用密码
        'auth' => 'cheng',
        //连接失败后重新连接的次数
        'retry' => 2
    ],

    //文件缓存
    'file' => [

    ],

    //memcached缓存
    'memcached' => [
        'host' => '127.0.0.1',
        'port' => 11211
    ]
];
