<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', 'index/index/index')->alias('home');

Route::get('todo', 'index/index/todo');

Route::get('login', 'index/index/login');

Route::get('document', 'index/index/document');