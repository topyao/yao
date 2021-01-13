<?php

define('ROOT', dirname(getcwd()) . DIRECTORY_SEPARATOR);
require ROOT . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
\Yao\App::run();
