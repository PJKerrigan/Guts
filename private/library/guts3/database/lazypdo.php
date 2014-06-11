<?php
namespace Guts3\Database;

//  Using declarations.
use \PDO;
use \PDOException;
use \ReflectionClass;
use \Exception;
use \InvalidArgumentException;

/*
 *  Wrapper for the PDO class taking advantage of lazy-instantiation.
 */
class LazyPDO {
    private $db;
    private $args;
    
    /*
     *  Constructor.
     */
    public function __construct() {
        $this->args     = func_get_args();
    }
    
    /*
     *  All method calls are routed through here.
     */
    public function __call($method, $args) {
        if (empty($this->db)) {
            $refl       = new \ReflectionClass("\PDO");
            $this->db   = $refl->newInstanceArgs($this->args);
        }        
        return call_user_func_array(array($this->db, $method), $args);
    }
}