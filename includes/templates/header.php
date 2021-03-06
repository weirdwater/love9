<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Love9</title>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/bootstrap.min.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/main.css"/>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/avatars.php?users=<?= implode(',', $requiredAvatars) ?>"/>
</head>
<header>
    <a href="<?= BASE_URL ?>">
        <img class="logo" src="<?= BASE_URL ?>img/logo.png" alt=""/>
    </a>
    <nav class="main">
        <ul>
            <?php if ($user->isLoggedIn()): ?>
                <li class="dropdown">
                    <div class="user-face dropdown-toggle" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" data-userid="<?= $user->getPerson()->getId() ?>">
                        <span>me</span>
                    </div>
                    <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu1">
                        <li><a href="<?= BASE_URL ?>?view=person&id=<?= $user->getPerson()->getId() ?>"><span class="glyphicon glyphicon-user"></span>  Profile</a></li>
                        <li><a href="#"><span class="glyphicon glyphicon-heart"></span>  Favorites</a></li>
                        <li><a href="<?= BASE_URL ?>?view=profile&id=<?= $user->getPerson()->getId() ?>&action=delete"><span class="glyphicon glyphicon-remove-sign"></span>  Delete Profile</a></li>
                        <li role="separator" class="divider"></li>
                        <li><a href="<?= BASE_URL ?>?view=logout"><span class="glyphicon glyphicon-log-out"></span>  Sign Out</a></li>
                    </ul>
                </li>
            <?php else: ?>
                <li class="dropdown">
                    <a href="<?= BASE_URL?>?view=login" class="user-face-link">
                        <div class="user-face logged-out">
                            <span>me</span>
                        </div>
                    </a>
                </li>
            <?php endif ?>
            <li><a href="<?= BASE_URL ?>" class="menu-icons"><div class=" glyphicon glyphicon-th"></div></a></li>
            <li><div class="menu-icons glyphicon glyphicon-search"></div></li>
            <?php if (isset($profile)): ?>
                <?php if ($user->isLoggedIn()): ?>
                    <?php if ($person->isInUserFavorites()): ?>
                        <li>
                            <a href="<?= BASE_URL ?>?view=favorite&id=<?= $person->getId() ?>&action=delete" class="menu-icons">
                                <div class="menu-icons glyphicon glyphicon-heart" data-favorite="true"></div>
                            </a>
                        </li>
                    <?php else: ?>
                        <li><a href="<?= BASE_URL ?>?view=favorite&id=<?= $person->getId() ?>&action=create" class="menu-icons">
                                <div class="menu-icons glyphicon glyphicon-heart"></div>
                            </a>
                        </li>
                    <?php endif ?>
                <?php endif ?>
                <li><div class="menu-icons glyphicon glyphicon-envelope"></div></li>
            <?php endif ?>
            <?php if ($view == 'browse' || empty($view)) { ?>
            <li><div class="menu-icons glyphicon glyphicon-filter"></div></li>
            <?php } ?>
        </ul>
    </nav>
</header>
<div class="container" ?>
<?php $exceptionHandler->showAlerts(); ?>