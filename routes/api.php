<?php

/**
 * 第二种注册路由的方式[不推荐]
 * @var \Yao\Http\Route $route
 */
$route = \Yao\App::instance()->make('route');

$route->view('test', 'index/index/test');


unset($route);
