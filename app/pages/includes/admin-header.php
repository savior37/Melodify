<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Melodify - Your Music Journey Starts Here</title>
    <link rel="stylesheet" type="text/css" href="<?=ROOT?>/assets/css/style.css?45">
</head>
<style>
    header a{
        color: white;
    }
    .dropdown-list{
        background-color: green;
    }
</style>
<body>
    <header style="background-color: #b029e6 ; color: white;">
            <div class="header-content">
                <div class="logo-container">
                    <a href="index.html">
                        <img class="logo" src="<?=ROOT?>/assets/images/logo1.jpeg" alt="Melodify Logo">
                    </a>
                </div>
                <div class="header-main">
                    <div class="brand-name">
                        ADMIN AREA
                        <div>
                        </div>
                    </div>
                    <nav class="main-nav">
                        <div class="nav-item">
                            <a href="<?=ROOT?>/admin">Dashboard</a>
                        </div>
                        <div class="nav-item">
                            <a href="<?=ROOT?>/admin/users">Users</a>
                        </div>
                        <div class="nav-item">
                            <a href="<?=ROOT?>/admin/music">Music</a>
                        </div>
                        <div class="nav-item">
                            <a href="<?=ROOT?>/admin/category">Categories</a>
                        </div>
                        <div class="nav-item">
                            <a href="<?=ROOT?>/admin/artists">Artists</a>
                        </div>
                        <div class="nav-item dropdown user-nav">
                            <a href="<?=ROOT?>/profile">Hi, Danu</a>
                            <div class="dropdown-list hide">
                                <div class="nav-item">
                                    <a href="<?=ROOT?>/profile">Profile</a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?=ROOT?>">Website</a>
                                </div>
                                <div class="nav-item">
                                    <a href="<?=ROOT?>/logout">Logout</a>
                                </div>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
    </header>