<?php
if (is_file($_SERVER["DOCUMENT_ROOT"] . $_SERVER["SCRIPT_NAME"])) {
    return false;
} else {
    require_once('index.php');
}
