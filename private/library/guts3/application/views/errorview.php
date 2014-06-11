<?php
namespace Guts3\Application\Views;

use \Guts3\Application\View;
use \Exception;
use \InvalidArgumentException;

/*
 *  View displayed when an error is found.
 */
class ErrorView extends View {
    public function output() {
        echo "<h2>Error!</h2>";
    }
}