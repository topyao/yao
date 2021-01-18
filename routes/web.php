<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', 'index/index/index')->alias('home');
