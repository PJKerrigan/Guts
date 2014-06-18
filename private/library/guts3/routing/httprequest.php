<?php
namespace Guts3\Routing;

//  Using declarations.
use \Exception;
use \InvalidArgumentException;

/*
 *  Represents a client request sent to the server. Parsed into a full URL, a
 *  controller, an action and an array of paramters.
 */
class HttpRequest {
    protected $uri          = "";
    protected $controller   = "";
    protected $action       = NULL;
    protected $params       = NULL;
    
    public function __construct($uri, $controller, $action = NULL, array $params = array()) {
        if (!is_string($url)) {
            throw new InvalidArgumentException("Uri must be a valid string.");
        }
        if (!is_string($controller)) {
            throw new InvalidArgumentException("Controller must be a valid string.");
        }
        if (isset($action) and !is_string($action)) {
            throw new InvalidArgumentException("Action must be a valid string.");
        }
        $this->uri          = $uri;
        $this->controller   = $controller;
        $this->action       = (isset($action) ? $action : NULL);
        $this->params       = (isset($params) ? $params : NULL);
    }
    
    public function getUri() { return $this->uri; }
    public function getController() { return $this->controller; }
    public function getAction() { return $this->action; }
    public function getParams() { return $this->params; }
}