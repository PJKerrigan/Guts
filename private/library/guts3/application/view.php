<?php
namespace Guts3\Application;

//  Using declarations.
use \Guts3\Application\Object;
use \Guts3\Application\ViewModel;
use \Exception;
use \InvalidArgumentException;

/*
 *  Represents the View-layer.
 */
abstract class View extends Object {
    protected $viewModel;
    protected $route;
    
    /*
     *  Constructor.
     */
    public function __construct($route, ViewModel $viewModel) {
        $this->route        = $route;
        $this->viewModel    = $viewModel;
    }
    
    /*
     *  Output method. All views must implement this.
     */
    public abstract function output();
}