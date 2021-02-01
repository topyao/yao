<?php

require __DIR__ . '/../vendor/autoload.php';

$app = \Yao\Container::instance()->make('app');

$app->run();
