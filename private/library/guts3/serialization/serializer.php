<?php
namespace Guts3\Serialization;

//  Using declarations.
use \Serializable;
use \InvalidArgumentException;
use \RuntimeException;

/*
 *  Serializes data.
 */
class Serializer implements Serializable {
    
    /*
     *  Constructor.
     */
    public function __construct() { }
    
    /*
     *  Serializes a value.
     */
    public function serialize($value) {
        if (is_resource($value)) {
            throw new InvalidArgumentException("A PHP resource cannot be serialized.");
        }
        try {
            return serialize($value);
        } catch (Exception $ex) {
            throw new RuntimeException($ex->getMessage());
        }
    }
    
    /*
     *  De-serializes a value.
     */
    public function unserialize($value) {
        if (!is_string($value)) {
            throw new InvalidArgumentException("Value to be unserialized must be a string.");
        }
        if (($unserialized = @unserialize($value)) === FALSE) {
            throw new \RuntimeException("Unable to unserialize '$value'.");
        }
        return $unserialized;
    }
}