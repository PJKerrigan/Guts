<?php
namespace Guts3\Routing;

//  Using declarations.
use \Guts3\Routing\Route;
use \Exception;
use \InvalidArgumentException;

/*
 *  Responsible for routing requests. Typically used within the FrontController.
 */
class Router {
    private $table                  = array();
    private $default;
    
    /*
     *  Constructor.
     */
    public function __construct($defaultString, Route $defaultRoute) {
        if (!is_string($defaultString)) {
            throw new InvalidArgumentException("DefaultString not a valid string.");
        }
        $this->default              = $defaultString;
        $this->table[$defaultString] = $defaultRoute;
    }
    
    /*
     *  Gets the route for a specific string.
     */
    public function getRoute($route) {
        $route                      = strtolower($route);
        
        if (!isset($this->table[$route])) {
            return $this->table[$this->default];
        }
        
        return $this->table[$route];
    }
}