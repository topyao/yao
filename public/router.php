<?php
if (is_file($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])) {
    return false;
} else {
    define('ROOT_PATH', getcwd() . DIRECTORY_SEPARATOR);
    require_once('index.php');
}
