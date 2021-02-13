<?php

/**
 * 第二种注册路由的方式
 * @var \Yao\Http\Route $route
 */
$route = \Yao\App::instance()->make('route');

$route->get('test', 'index/index/test');

