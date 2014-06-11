<?php
namespace Guts3\Application;

//  Using declarations.
use \Guts3\Database\LazyPDO;
use \Guts3\Application\Object;
use \Exception;
use \InvalidArgumentException;

/*
 *  Represents the Model-layer.
 */
abstract class Model extends Object {
    
    /*
     *  Constructor.
     */
    public function __construct() {
    }
}