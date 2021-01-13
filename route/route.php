<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', [\App\Index\Controller\Index::class, 'index'])->alias('name')->cross('*');

Route::post('/upload', 'index@index/upload');

Route::rule('test', 'index@index/test');

Route::get('todo', 'index@index/todo');