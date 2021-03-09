<?php

return [
    //全局跨域允许
    'global' => false,
    //允许跨域的地址
    'origin' => '*',

    'credentials' => true,
    //允许跨域头
    'headers' => 'Origin,Content-Type,Accept,token,X-Requested-With',
    //预检缓存有效期
    'max_age' => 600
];