<?php
/*
 * Database Settings
 * This PHP project uses PDO to establish connection to the database. It has
 * been developed in a MySQL enviroment. It's untested in other enviroments.
 * Please adjust the settings below to match your Database's settings.
 */
define('DB_HOST', 'localhost');
define('DB_PORT', '8889');
define('DB_NAME', 'datingsite');
define('DB_USER', 'root');
define('DB_PASS', 'root');

/*
 * L10n settings
 */
date_default_timezone_set('Europe/Amsterdam');
setlocale(LC_TIME, 'nl_NL');

/*
 * Error Reporting Settings
 * During production its a good idea to shield your error messages. But during
 * development you should get as much information as possible to make debugging
 * less painful.
 * To control the error messages we tell PHP to throw exceptions instead.
 */
error_reporting(E_ALL | E_NOTICE | E_ERROR);
ini_set('display_errors', 1);
//set_error_handler(function ($errno, $errstr, $errfile, $errline)
//{
//    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
//});
$inDevelopment = true;

/*
 * Path Settings
 * If index.php is not located in the root folder of the server you need to
 * adjust the string below.
 * Example situation: .../httpdocs/datingsite/index.php
 * Example solution:  $pathToIndex = '/datingsite/';
 * Do not forget to end the $pathToIndex with a '/'!
 */
$pathToIndex = '/love9/';
define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT'] . $pathToIndex);
define('BASE_URL', $pathToIndex);

// Handy shortcuts
define('CLASSES', ROOT_PATH . 'includes/classes/');
define('TEMPLATES', ROOT_PATH . 'includes/templates/');
define('HANDLERS', ROOT_PATH . 'includes/handlers/');