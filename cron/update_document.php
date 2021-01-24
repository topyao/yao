#!/usr/bin/env php
<?php

define('ROOT_PATH', dirname(getcwd()));
chdir('./public');
include(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php');

$lock = __DIR__ . DIRECTORY_SEPARATOR . 'lock';

//if (!file_exists($lock)) {
//    touch($lock);
//} else {
//    exit('脚本正在执行!');
//}

$data = file_get_contents('https://github.com/topyao/yao/blob/master/README.md');

if (false == $data) {
    exit('文档获取失败！');
} else {
    \Yao\Facade\Db::name('notes')
        ->where(['id' => 125])
        ->update(['text' => $data]);
}
