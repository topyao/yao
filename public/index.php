<?php

namespace Yao;

require __DIR__ . '/../vendor/autoload.php';

$app = Container::instance()->make(App::class);

$app->run();
