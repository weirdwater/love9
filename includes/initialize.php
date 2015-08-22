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
// session_start();
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

$_SESSION['userId'] = 3;