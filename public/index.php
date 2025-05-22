<?php
session_start();

require "../app/core/init.php";

$URL = $_GET['url'] ?? "home";
$URL = explode("/", $URL);

$pageName = strtolower($URL[0] ?? "home");
$file = page($pageName);

if (file_exists($file)) {
    require $file;
} else {
    require page("404");
}
exit;
