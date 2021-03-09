<?php

/**
 * 路由定义文件
 */

use Yao\Facade\Route;

Route::rule('/', 'index/index/index')->alias('home');

Route::rule('login', 'index/user/login');
Route::get('logout', 'index/user/logout');

//note路由
Route::rule('notes/add', 'index/note/create');
Route::get('notes', 'index/note/list')->alias('list');
Route::get('list', 'index/note/list');
Route::get('note/(\d+)\.html', 'index/note/read')->alias('read');
Route::rule('notes/edit/(\d+)', 'index/note/edit')->alias('edit');
Route::get('search', 'index/note/search');
Route::post('/notes/comment', 'index/comment/create');
Route::get('notes/delete/(\d+)', 'index/note/delete');


//评论分页
Route::get('note/(\d+)/comment/p/(\d+)', 'index/comment/page');
//点赞功能api
Route::get('/notes/heart/(\d+)', 'index/comment/heart');

//用户路由
Route::rule('users/add', 'index/user/create');


Route::get('log', 'index/index/log');

Route::redirect('document', '/note/132.html');


Route::get('test', function (\Yao\Http\Request $request) {
    dump($request);
    return ['fff'];

});