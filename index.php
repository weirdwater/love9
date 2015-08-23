<?php
require 'includes/initialize.php';

$view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

// Display a person's profile
if ($view == 'person' && !empty($id)) {
    $person = love9\Person::withId($id);
    $profile = new \love9\Profile($person);

    require TEMPLATES . 'header.php';
    $profile->showProfile();
    require TEMPLATES . 'footer.php';
}

// Display a users' favorites
elseif ($view == 'favorite' && empty($id) && empty($action)) {

}

// Login screen
elseif ($view == 'login' || $view == 'signup') {
    require TEMPLATES . 'header.php';
    require TEMPLATES . 'sign-in-up.php';
    require TEMPLATES . 'footer.php';
}

// Logout
elseif ($view == 'logout') {
    $user->logout();
}

// Remove person from favorites, then go to profile of person with status
elseif ($view == 'favorite' && !empty($id) && $action == 'add') {
    $person = love9\Person::withId($id);
    $person->addToFavorites();

    $profile = new \love9\Profile($person);
    require TEMPLATES . 'header.php';
    $profile->showProfile();
    require TEMPLATES . 'footer.php';
}

// Add person to favorites, then go to profile of person with status
elseif ($view == 'favorite' && !empty($id) && $action == 'delete') {
    $person = love9\Person::withId($id);
    $person->removeFromFavorites();

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