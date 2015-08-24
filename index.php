<?php
require 'includes/initialize.php';

$view = filter_input(INPUT_GET, 'view', FILTER_SANITIZE_STRING);
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);
$showProfile = false;

/* Profile Setup
 * Site doesn't work unless the user has a person(profile).
 * So it is top priority that they create one. Thus it is at the top of the if
 * chain.
 */
if ($user->isLoggedIn() && !$user->hasPerson()
    || $view == 'profile' && $action == 'create' ) {
    /*
     * Because this view is forced a possible scenario is having header
     * elements meant for a views appear.
     * To avoid this we set the get variables so they match this view.
     */
    $view = 'profile';
    $action = 'create';
    $id = 0;

    $signupHandler = toolbox\SignupHandler::profileSetup();
    require TEMPLATES . 'header.php';
    require TEMPLATES . 'profile-setup.php';
    require TEMPLATES . 'footer.php';
}

// Display a person's profile
elseif ($view == 'person' && !empty($id)) {
    $person = love9\Person::withId($id);
    $showProfile = true;
}

// Display a users' favorites
elseif ($view == 'favorite' && empty($id) && empty($action)) {

}

// Login screen
elseif ($view == 'login' || $view == 'signup') {
    if ($view == 'signup')
        $signupHandler = \toolbox\SignupHandler::signup();
    else
        $signupHandler = new \toolbox\SignupHandler(0);
    require TEMPLATES . 'header.php';
    require TEMPLATES . 'sign-in-up.php';
    require TEMPLATES . 'footer.php';
}

// Logout
elseif ($view == 'logout') {
    $user->logout();
}

// Remove person from favorites, then go to profile of person with status
elseif ($view == 'favorite' && !empty($id) && $action == 'create') {
    $person = love9\Person::withId($id);
    $person->addToFavorites();
    $showProfile = true;
}

// Add person to favorites, then go to profile of person with status
elseif ($view == 'favorite' && !empty($id) && $action == 'delete') {
    $person = love9\Person::withId($id);
    $person->removeFromFavorites();
    $showProfile = true;
}

// Remove a comment
elseif ($view == 'comment' && !empty($id) && $action == 'delete') {
    $comment = \love9\Comment::withId($id);
    $comment->delete();
    $person = $comment->getTo();
    $showProfile = true;
}

// Remove a profile
// Remove a comment
elseif ($view == 'profile' && !empty($id) && $action == 'delete') {
    $person = love9\Person::withId($id);
    $person->deleteUser();
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

if ($showProfile) {
    $profile = new \love9\Profile($person);
    require TEMPLATES . 'header.php';
    $profile->showProfile();
    require TEMPLATES . 'footer.php';
}