<?php

use _MODULE\User\_ACCOUNT;

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title><?= isset($page_title) ? $page_title : '' ?></title>
    <meta name="description" content="<?= isset($page_description) ? $page_description : '' ?>">
    <?= cssResources() ?>
</head>
<body>
<header>
    <div class="container">
        <nav class="navbar navbar-expand-md navbar-light">
            <a href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>"
               class="navbar-brand logo">
                <?= isset($_APP_CONFIG['_NAME_FRONT']) ? $_APP_CONFIG['_NAME_FRONT'] : '' ?>
            </a>

            <button class="navbar-toggler collapsed" id="mobile-menu-burger" type="button" data-toggle="collapse"
                    data-target="#main-menu"
                    aria-controls="main-menu" aria-expanded="false" aria-label="">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </button>

            <div class="collapse navbar-collapse" id="main-menu">
                <ul class="navbar-nav ml-auto justify-content-center align-items-center">

                    <? if (_ACCOUNT::_loggedIn('user')): ?>
                        <li class="nav-item">
                            <a class="nav-link nav-hover<?= currentPage('dashboard') ? ' current' : '' ?>"
                               href="<?= webLink('dashboard') ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link nav-hover<?= currentPage('user/logout') ? ' current' : '' ?>"
                               href="<?= webLink('user/logout') ?>">Log Out</a>
                        </li>
                    <? else: ?>
                        <li class="nav-item">
                            <a class="nav-link nav-hover<?= currentPage('user/login') ? ' current' : '' ?>"
                               href="<?= webLink('user/login') ?>">Login</a>
                        </li>
                    <? endif ?>

                    <li class="nav-item">
                        <a class="nav-link nav-hover<?= currentPage('blog') ? ' current' : '' ?>"
                           href="<?= webLink('blog') ?>">Blog</a>
                    </li>


                    <li class="nav-item"><?= selfRender('Blog', 'public/search-form.php') ?></li>
                </ul>
            </div>
        </nav>
    </div>
</header>