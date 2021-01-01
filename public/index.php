<?php

define('ROOT', dirname(getcwd()) . DIRECTORY_SEPARATOR);
require ROOT . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
//调用框架初始化方法
Yao\App::run();
