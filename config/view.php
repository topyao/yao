<?php

return [
    //模板引擎类型 twig,smarty
    'type' => 'smarty',
    //模板调试
    'debug' => false,
    //模板缓存
    'cache' => true,
    //模板缓存路径
    'cache_dir' => ROOT . 'bootstrap' . DIRECTORY_SEPARATOR . 'view',
    //模板后缀
    'template_suffix' => 'html',

    //左右边界，仅对Smarty有效
    'left_delimiter' => '{{',
    'right_delimiter' => '}}',
];
