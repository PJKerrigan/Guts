<?php
namespace Guts3\Application;

//  Using declarations.
use \Guts3\Application\Object;
use \Guts3\Application\Model;
use \InvalidArgumentException;

/*
 *  ViewModel base class.
 */
abstract class ViewModel extends Object {
    protected $model;
    protected $data     = array();
    
    /*
     *  Constructor.
     */
    public function __construct(Model $model) {
        $this->model    = $model;
    }
    
    /*
     *  Gets a value for a specific key.
     */
    public function get($key) {
        if (array_key_exists($key, $this->data)) {
            return $this->data[$key];
        }
        return NULL;
    }
    
    /*
     *  Sets a value for a specific key.
     */
    protected function set($key, $value) {
        $this->data[$key]  = $value;
    }
}