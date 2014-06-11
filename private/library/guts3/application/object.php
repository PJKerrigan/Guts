<?php
namespace Guts3\Application;

//  Using declarations.
use \Exception;
use \InvalidArgumentException;

/*
 *  Simple base-class that the application classes inherit from.
 */
class Object {
    
    /*
     *  Gets the name of this class.
     */
    public function getClassName() {
        return get_class($this);
    }
}