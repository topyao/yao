<?php

return [
    //是否开启调试
    'debug' => env('app.debug', false),
    //是否记录日志
    'log' => env('app.log', false),
    //自动开启session
    'auto_start' => env('app.auto_start', false),
    //默认时区
    'default_timezone' => env('app.default_timezone', 'PRC'),
    //参数过滤
    'filter' => ['trim', 'htmlspecialchars'],

    'exception_view' => env('yao_path') . 'tpl' . DIRECTORY_SEPARATOR . 'exception.html',

    //类别名
    'alias' => [

    ],

    /**
     * 全局中间件
     */
    'middleware' => [

    ],

    /**
     * 事件
     */
    'events' => [
        'app_start' => [
            \App\Events\Start::class
        ],
        'response_sent' => [
            \App\Events\End::class
        ]
    ]
];
