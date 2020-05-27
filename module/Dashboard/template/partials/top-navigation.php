<?php

use _MODULE\Dashboard;

?>
<nav class="navbar fixed-top flex-md-nowrap p-0 my-auto">
    <div class="navbar-brand col-sm-3 col-md-2 mr-0">
        <div class="row">
            <div class="col text-left ml-0">
                <span class="oi oi-menu left-menu-action"></span>
                <a class=""
                   href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?><?= Dashboard::dashboardLink() ?>">
                    <?= isset($_APP_CONFIG['_NAME_DASHBOARD']) ? $_APP_CONFIG['_NAME_DASHBOARD'] : '' ?>
                </a>
            </div>
        </div>
    </div>
    <div class="top-bar-item top-bar-item-right px-0 d-flex">
        <div>
            <a target="_blank" href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>"
               class="profile-action text-decoration-none">
                <span class="oi oi-home"></span>
            </a>
        </div>

        <div class="dropdown">
            <div class="profile-action" id="dropdownMenuOffset"
                 data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="oi oi-person"></span>
            </div>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuOffset">
                <span class="dropdown-menu-arrow"></span>
                <a class="dropdown-item"
                   href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user">Profile</a>
                <a class="dropdown-item"
                   href="<?= (isset($_APP_CONFIG['_DOMAIN_ROOT']) ? $_APP_CONFIG['_DOMAIN_ROOT'] : '') ?>user/logout">Logout</a>
            </div>
        </div>
    </div>
</nav>