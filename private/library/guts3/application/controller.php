<?php
namespace Guts3\Application;

//  Using declarations.
use \Guts3\Application\Object;
use \Exception;
use \InvalidArgumentException;

/*
 *  Represents the Controller-layer.
 */
abstract class Controller extends Object {
    protected $viewModel;
    
    /*
     *  Constructor.
     */
    public function __construct(ViewModel $viewModel) {
        $this->viewModel    = $viewModel;
    }
    
    /*
     *  Gets the name of the controller.
     */
    public function getName() {
        return get_class($this);
    }
}