<?php
namespace Guts3\Application\Models;

use \Guts3\Application\Model;
use \Guts3\Database\LazyPDO;
use \PDO;
use \PDOException;
use \Exception;
use \InvalidArgumentException;

/*
 *  Model taking advantage of a database.
 */
class DatabaseModel extends Model {
    protected $db;
    
    /*
     *  Constructor.
     */
    public function __construct() {
        $options        = array();
        $this->db       = new LazyPDO(DB_DSN, DB_USER, DB_PASS);
    }
}