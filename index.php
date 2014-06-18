<?php

/*
 *  Debug-mode echo function.
 */
function e($message) {
    if (is_string($message)) {
        echo "<pre>{$message}</pre>";
        return TRUE;
    }
    return FALSE;
}

//  Enable error-reporting.
error_reporting(E_ALL);
ini_set("display_errors", 1);

//  Define important constants.
define("DEBUG", TRUE);
define("APP_ROOT", realpath(dirname(__FILE__)));

include "./private/includes/init.php";
include "./private/library/guts3/core.php";

use \Guts3\Core;
use \Guts3\Routing\Route;
use \Guts3\Routing\Router;
use \Guts3\FrontController;
use \Guts3\Auth\AuthA;
use \Guts3\Auth\Login;
use \Guts3\Security\SessionHandler;

$core       = new Core();
$session    = new SessionHandler();
$session->start(FALSE);

$default    = new Route("Guts3\Application\Models\DatabaseModel",
                        "Guts3\Application\ViewModels\GuestViewModel",
                        "Guts3\Application\Views\TemplateView",
                        "Guts3\Application\Controllers\GuestController");
$router     = new Router("index", $default);
$front      = new FrontController($router, "home", NULL);
//echo $front->output();

e("Hi.");
$dsn        = "mysql:host=" . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8';
$pdo        = new \PDO($dsn, DB_USER, DB_PASS, array());
$login      = new \Guts3\Auth\Login($pdo);

$user_name  = "test_user";
$user_email = "test@localhost";
$user_pass  = "pass_test";
$user_salt  = "faff-faff-faff";
$result     = $login->login($user_name, $user_email, $user_pass);
var_dump($_SESSION);
