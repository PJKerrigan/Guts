<?php
namespace Guts\Database;

//  Using declarations.
use \PDO;
use \PDOException;

class PDOWrapper extends PDO {
    private $error                  = "";
    private $sql                    = "";
    private $errorCallbackFunction;
    private $errorMsgFormat;
    
    /*
     *  Constructor.
     */
    public function __construct($dsn, $username, $password, array $options) {
        try {
            parent::__construct($dsn, $username, $password, $options);
        } catch (PDOException $ex) {
            $this->error    = $ex->getMessage();
        }
    }
    
    public function delete($table, $where, $bind = "") {
        $sql                = "DELETE FROM " . $table . " WHERE " . $where . ";";
        $this->run($sql, $bind);
    }
    
    public function filter($table, $info) {
        $driver             = $this->getAttribute(PDO::ATTR_DRIVER_NAME);
        if ($driver == "sqlite") {
            $sql            = "PRAGMA table_info('" . $table . "');";
            $key            = "name";
        } elseif ($driver == "mysql") {
            $sql            = "DESCRIBE " . $table . ";";
            $key            = "Field";
        } else {
            $sql            = "SELECT column_name FROM information_schema.columns WHERE table_name = '" . $table . "';";
            $key            = "column_name";
        }
        if (FALSE !== ($list = $this->run($sql))) {
            $fields         = array();
            foreach ($list as $record) {
                $fields[]   = $record[$key];
            }
            return array_values(array_intersect($fields, array_keys($info)));
        }
        return array();
    }
    
    private function cleanup($bind) {
        if (!is_array($bind)) {
            if (!empty($bind)) {
                $bind       = array($bind);                        
            } else {
                $bind       = array();
            }
        }
        foreach ($bind as $key => $value) {
            $bind[$key]     = stripslashes($value);
        }
        return $bind;
    }
    
    public function insert($table, $info) {
        $fields                 = $this->filter($table, $info);
        $sql                    = "INSERT INTO " . $table . " (" . implode($fields, ", ") . ") VALUES (:" . implode($fields, ", :") . ");";
        $bind                   = array();
        foreach ($fields as $field) {
            $bind[":$field"]    = $info[$field];
        }
        return $this->run($sql, $bind);
    }
}