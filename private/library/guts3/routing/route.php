<?php
namespace Guts3\Routing;

//  Using declarations.
use \Exception;
use \InvalidArgumentException;

/*
 *  Basic route class.
 */
class Route {
    protected $pattern;
    protected $model;
    protected $viewModel;
    protected $view;
    protected $controller;
    
    /*
     *  Constructor.
     */
    public function __construct($model, $viewModel, $view, $controller) {
        if (!is_string($model)) {
            throw new InvalidArgumentException("Model not a valid string.");
        }
        if (!is_string($viewModel)) {
            throw new InvalidArgumentException("ViewModel not a valid string.");
        }
        if (!is_string($view)) {
            throw new InvalidArgumentException("View not a valid string.");
        }
        if (!is_string($controller)) {
            throw new InvalidArgumentException("Controller not a valid string.");
        }
        
        $this->model        = $model;
        $this->viewModel    = $viewModel;
        $this->view         = $view;
        $this->controller   = $controller;
    }
    
    /*
     *  Gets the model string.
     */
    public function getModel() {
        return $this->model;
    }
    
    /*
     *  Gets the ViewModel string.
     */
    public function getViewModel() {
        return $this->viewModel;
    }
    
    /*
     *  Gets the view string.
     */
    public function getView() {
        return $this->view;
    }
    
    /*
     *  Gets the controller string.
     */
    public function getController() {
        return $this->controller;
    }
}