<?php
require_once "lib/nekopoi.php";

// change debug to 1 or 0
define('debug', 0);

$gTitle = "Nekopoi";

function base_url($path = '')
{
    return "http://localhost/_2021/Nekopoi/" . $path;
}

if (!debug) {
    error_reporting(E_ALL);
} else {
    error_reporting(0);
}
