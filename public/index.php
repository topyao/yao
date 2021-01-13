<?php
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('ROOT', dirname(getcwd()) . DIRECTORY_SEPARATOR);
require ROOT . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
\Yao\App::run();
