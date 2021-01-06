<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', [\App\Index\Controller\Index::class, 'index'])->alias('index')->cross('*');

Route::post('/upload', 'index@index/upload')->cross('http://www.chengyao.xyz');