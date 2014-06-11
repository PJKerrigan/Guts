<?php
namespace Guts3\Auth;

//  Using declarations.
use \Guts3\Auth\LoginInfo;
use \Exception;
use \InvalidArgumentException;

/*
 *  Authentication class.
 */
class Login {
    protected $db;
    protected $login_stmt;
    
    /*
     *  Constructor.
     */
    public function __construct(LazyPDO $db) {
        $this->db               = $db;
    }
    
    /*
     *  Login function.
     */
    public function login($username, $email, $password) {
        if (!isset($this->login_stmt) or empty($this->login_stmt)) {
            $this->login_stmt           = $this->db->prepare("SELECT id, username, email, pass, salt FROM users WHERE username = :username LIMIT 1");
        }
        
        $this->login_stmt->bindParam(":username", $username, PDO::PARAM_STR);
        $this->login_stmt->execute();            
        $user                           = $this->login_stmt->fetch(PDO::FETCH_CLASS, "LoginInfo");

        //  If no results were recovered, exit.
        if (!$user) {
            return FALSE;
        }
        //  If the user has tried to login too many times, exit.
        if ($this->checkBruteForce($user->id)) {
            //  User is trying to brute-force.
            return FALSE;
        }

        //  Test login information.
        $password                       = hash("sha512", $password . $user->salt);
        if ($user->pass == $password) {
            //  Get the user-agent string of the user.
            $user_agent                 = $_SERVER["HTTP_USER_AGENT"];
            $user_id                    = preg_replace("/[^0-9]+/", "", $user->id);
            $user_name                  = preg_replace("/[^a-zA-Z0-0_\-]+/", "", $user->username);

            //  Store this data in the _SESSION global.
            $_SESSION["username"]       = $user_name;
            $_SESSION["login_string"]   = hash("sha512", $password . $user_agent);
            //  Login successful!
            return TRUE;
        } else {
            
        }
    }
}