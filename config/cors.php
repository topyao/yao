<?php

return [
    'origin' => '*',
    'credentials' => true,
    'headers' => 'Origin,Content-Type,Accept,token,X-Requested-With',
    //预检缓存有效期
    'max_age' => 600
];