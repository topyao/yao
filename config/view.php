<?php

return [

    //模板引擎类型 twig,smarty
    'default' => 'smarty',

    'twig' => [
        //模板调试
        'debug' => false,
        //模板缓存
        'cache' => false,
        //模板后缀
        'suffix' => 'html',
    ],
    'smarty' => [
        //模板调试
        'debug' => false,
        //模板缓存
        'cache' => false,
        //模板后缀
        'suffix' => 'html',
        //左右边界
        'left_delimiter' => '{{',
        'right_delimiter' => '}}',
    ]

];
