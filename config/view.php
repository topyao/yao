<?php

return [

    //模板引擎类型 twig,smarty
    'type' => 'smarty',

    'twig' => [
        //模板调试
        'debug' => false,
        //模板缓存
        'cache' => false,
        //模板缓存路径
        'cache_dir' => env('storage_path') . 'view',
        //模板后缀
        'suffix' => 'html',
    ],
    'smarty' => [
        //模板调试
        'debug' => false,
        //模板缓存
        'cache' => false,
        //模板缓存路径
        'cache_dir' => env('storage_path') . 'view',
        //模板后缀
        'suffix' => 'html',
        //左右边界
        'left_delimiter' => '{{',
        'right_delimiter' => '}}',
    ]

];
