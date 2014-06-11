<?php
namespace Guts3;

//  Using declarations.
use \Guts3\Routing\Route;
use \Guts3\Routing\Router;
use \Exception;
use \InvalidArgumentException;

/*
 *  Front-controller class. Used when routing requests and ensuring the correct
 *  MVC stack is loaded and used.
 */
class FrontController {
    protected $model;
    protected $viewModel;
    protected $view;
    protected $controller;
    
    /*
     *  Constructor.
     */
    public function __construct(Router $router, $requestString, $action = NULL) {
        //  Get the route for the requested URI.
        $route              = $router->getRoute($requestString);
        //  Store the model, viewmodel, view and controller names.
        $modelName          = $route->getModel();
        $viewModelName      = $route->getViewModel();
        $viewName           = $route->getView();
        $controllerName     = $route->getController();
        //  Instantiate the MVC stack.
        $model              = new $modelName();
        $viewModel          = new $viewModelName($model);
        $this->view         = new $viewName($requestString, $viewModel);
        $this->controller   = new $controllerName($viewModel);
        //  If the action exists, call it.
        if (!empty($action)) {
            call_user_func(array($this->controller, $action));
        }
    }
    
    /*
     *  Output method. Returns the view output.
     */
    public function output() {
        return $this->view->output();
    }
}