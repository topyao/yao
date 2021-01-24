<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', 'index/index/index')->alias('home');

Route::rule('login', 'index/user/login');


Route::get('document', 'index/index/document');


//note路由
Route::rule('notes/add', 'index/note/create');
Route::get('notes', 'index/note/list');
Route::get('notes/(\d+)\.html', 'index/note/list')->alias('list');
Route::get('list', 'index/note/list');
Route::rule('note/(\d+)\.html', 'index/note/read')->alias('read');
Route::rule('notes/edit/(\d+)', 'index/note/edit')->alias('edit');

//检索
Route::rule('sp', 'index/spider/index');
