<?php

return [
    'default' => env('database.default', 'mysql'),

    'mysql' => [
        //主机地址
        'host' => env('database.host', 'localhost'),
        //数据库用户名
        'user' => env('database.user', 'user'),
        //数据库密码
        'pass' => env('database.pass', 'pass'),
        //数据库名
        'dbname' => env('database.dbname', 'dbname'),
        //端口
        'port' => env('database.port', 3306),
        //额外设置
        'options' => env('database.options', [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]),
        //编码
        'charset' => env('database . charset', 'utf8mb4'),
        //数据表前缀
        'prefix' => ''
    ],

    'pgsql' => [
        //主机地址
        'host' => env('database.host', 'localhost'),
        //数据库用户名
        'user' => env('database.user', 'user'),
        //数据库密码
        'pass' => env('database.pass', 'pass'),
        //数据库名
        'dbname' => env('database.dbname', 'dbname'),
        //端口
        'port' => env('database.port', 5432),
        //额外设置
        'options' => env('database.options', [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]),
        //编码
        'charset' => env('database . charset', 'utf8mb4'),
        //数据表前缀
        'prefix' => ''
    ]
];
