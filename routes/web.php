<?php

/**
 * 路由定义文件
 */

use \Yao\Facade\Route;

Route::get('/', 'index/index/index')->alias('home');

Route::get('todo', 'index/index/todo');

Route::get('login', 'index/index/login');


Route::get('document', 'index/index/document');

Route::get('test', 'index/index/test');


Route::rule('notes', 'index/note/create');
Route::get('list', 'index/note/list');
Route::get('note/(\d+)','index/note/note');