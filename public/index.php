<?php
session_start();

require "../app/core/init.php";

$URL = $_GET['url'] ?? "home";
$URL = explode("/", $URL);

//get page number
$page = $_GET['page'] ?? 1;
$page = (int)$page;
$prev_page = $page <= 1 ? 1 : $page - 1;
$next_page = $page + 1;

$pageName = strtolower($URL[0] ?? "home");
$file = page($pageName);

if (file_exists($file)) {
    require $file;
} else {
    require page("404");
}
exit;
