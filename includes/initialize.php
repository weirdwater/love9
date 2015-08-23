<?php
require 'settings.php';
require HANDLERS . 'ExceptionHandler.php';
require CLASSES . 'Person.php';
require CLASSES . 'Location.php';
require CLASSES . 'Comment.php';
require CLASSES . 'Profile.php';
require CLASSES . 'Interest.php';
require CLASSES . 'PeopleGrid.php';
require CLASSES . 'Alert.php';
require CLASSES . 'User.php';
$exceptionHandler = new toolbox\ExceptionHandler($inDevelopment);
$requiredAvatars = [];

/*
 * Setup database connection
 * We use PDO to connect to the database because PDO uses prepared statements
 * to query the database. This has a number of benefits over querying with
 * mysql(i), one of which being protection against sql injections.
 * Here we give PDO the needed credentials, tell PDO to throw exceptions in
 * stead of blatant error messages and open the connection.
 */
try
{
    $db = new PDO('mysql:host='.DB_HOST.';port='.'7777'.';dbname='.DB_NAME, DB_USER, DB_PASS);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $db->exec('SET NAMES \'utf8\'');
}
catch (PDOException $e)
{
    $exceptionHandler->databaseException($e, 'Initial connection');
    exit;
}

session_start();
if (empty($_SESSION['userId'])) {
    if ($_SERVER['REQUEST_METHOD'] == 'POST'
        && isset($_GET['view'])
        && $_GET['view'] == 'login')
    {
        $user = \love9\User::withLogin();
    }

    // Default, not logged in user
    else
        $user = new \love9\User();
}
else {
    $user = \love9\User::withId($_SESSION['userId']);
}
