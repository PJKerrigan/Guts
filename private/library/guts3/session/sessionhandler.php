<?php
namespace Guts3\Session;

//  Using declarations.
use \PDO;

/*
 *  Custom session-handler class responsible for open, close, read, write,
 *  destroy and gc (garbage-collect) operations.
 */
class SessionHandler {
    private $session_id;
    private $db;
    private $table;
    
    /*
     *  Constructor.
     */
    public function __construct(PDO $db) {
        $this->db       = $db;
        $this->initialize();
    }
    
    /*
     *  Ensures that PHP uses this instance and its methods for session
     *  handling.
     */
    public function initialize() {
        session_set_save_handler(
                array(&$this, "open"),
                array(&$this, "close"),
                array(&$this, "read"),
                array(&$this, "write"),
                array(&$this, "destroy"),
                array(&$this, "gc"));
    }
    
    /*
     *  Opens a session.
     */
    public function open($path, $name) {
        
    }
    
    /*
     *  Closes a session.
     */
    public function close() {
        
    }
    
    /*
     *  Reads session data from a data-source.
     */
    public function read($session_id) {
        
    }
    
    /*
     *  Writes session data to a data-source.
     */
    public function write($session_id, $data) {
        
    }
    
    /*
     *  Garbage collection method.
     */
    public function gc() {
        
    }
    
    /*
     *  Destroys the session.
     */
    public function destroy() {
        
    }
}