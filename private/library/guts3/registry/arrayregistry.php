<?php
namespace Guts3\Registry;

//  Using declarations.
use \Guts3\Registry\IRegistry;
use \Guts3\Registry\IDumpable;

/*
 *  Registry using an array to store its values.
 */
class ArrayRegistry implements IRegistry {
    protected $data                     = array();
    
    /*
     *  Sets a value from the registry.
     */
    public function set($key, $value) {
        $this->data[strtolower($key)]   = $value;
    }
    
    /*
     *  Gets a value from the registry.
     */
    public function get($key) {
        $key                            = strtolower($key);
        return isset($this->data[$key]) ? $this->data[$key] : NULL;
    }
    
    /*
     *  Clears the registry.
     */
    public function clear() {
        unset($this->data);
        $this->data                     = array();
    }
}