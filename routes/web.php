<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', 'index/index/index')->alias('home');

Route::get('login', 'index/index/login');


Route::get('document', 'index/index/document');


//note路由
Route::rule('notes/add', 'index/note/create');
Route::rule('notes', 'index/note/list');
Route::get('list', 'index/note/list');
Route::get('note/(\d+)\.html', 'index/note/read');

//检索
Route::rule('sp', 'index/spider/index');
