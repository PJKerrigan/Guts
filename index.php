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
//  Define database constants.
define("DB_USER", "root");
define("DB_PASS", "Guinness.For.Strength.112");

include "./private/includes/init.php";
include "./private/library/guts3/core.php";

use \Guts3\Core;
use \Guts3\Routing\Route;
use \Guts3\Routing\Router;
use \Guts3\FrontController;

$core       = new Core();
$default    = new Route("Guts3\Application\Models\DatabaseModel",
                        "Guts3\Application\ViewModels\GuestViewModel",
                        "Guts3\Application\Views\TemplateView",
                        "Guts3\Application\Controllers\GuestController");


$router     = new Router("index", $default);
$front      = new FrontController($router, "home", NULL);
echo $front->output();