<?php
require 'includes/initialize.php';

$user = love9\Person::withId($_SESSION['userId']);

$view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// Display the person's profile
if ($view == 'person' && !empty($id)) {
    $person = love9\Person::withId($id);
    $profile = new \love9\Profile($person);

    require TEMPLATES . 'header.php';
    $profile->showProfile();
    require TEMPLATES . 'footer.php';
}

// Remove person from favorites, then go to profile of person with status
elseif ($view == 'favorite' && !empty($id) && $action == 'add') {
    $person = love9\Person::withId($id);
    $user->addToFavorites($person);

    $profile = new \love9\Profile($person);
    require TEMPLATES . 'header.php';
    $profile->showProfile();
    require TEMPLATES . 'footer.php';
}

// Add person to favorites, then go to profile of person with status
elseif ($view == 'favorite' && !empty($id) && $action == 'delete') {
    $person = love9\Person::withId($id);
    $user->removeFromFavorites($person);

    $profile = new \love9\Profile($person);
    require TEMPLATES . 'header.php';
    $profile->showProfile();
    require TEMPLATES . 'footer.php';
}

// Display the browsing view
else {
    if (empty($id))
        $id = 1;
    $peoplegrid = new \love9\PeopleGrid($id);
    require TEMPLATES . 'header.php';
    $peoplegrid->showPeopleGrid();
    require TEMPLATES . 'footer.php';
}