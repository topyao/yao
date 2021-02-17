<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', 'index/index/index')->alias('home');

Route::rule('login', 'index/user/login');

Route::view('test', 'test/dd');

Route::redirect('document', 'http://www.chengyao.xyz/note/125.html');

//note路由
Route::rule('notes/add', 'index/note/create');
Route::get('notes/(\d+)\.html', 'index/note/list')->alias('list');
Route::get('list', 'index/note/list');
Route::rule('note/(\d+)\.html', 'index/note/read')->alias('read');
Route::rule('notes/edit/(\d+)', 'index/note/edit')->alias('edit');
Route::get('search', 'index/note/search');

//用户路由
Route::rule('users/add', 'index/user/create');