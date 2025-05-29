<?php

if (!is_admin()) {
    message("only admins can access the admin page");
    redirect('login');
}
$section = $URL[1] ?? "dashboard";
$action = $URL[2] ?? null;
$id = $URL[3] ?? null;

switch ($section) {
    case 'dashboard':
        require page('admin/dashboard');
        break;

    case 'users':
        require page('admin/users');
        break;

    case 'categories':
        require page('admin/categories');
        break;

    case 'artists':
        require page('admin/artists');
        break;

    case 'music':
        require page('admin/music');
        break;

    default:
        require page('admin/404');
        break;
}
?>