<?php
namespace Guts3\Auth;

//  Using declarations.
use \Guts3\Auth\LoginInfo;
use \PDO;
use \PDOException;
use \Guts3\Database\LazyPDO;
use \Exception;
use \InvalidArgumentException;

/*
 *  Authentication class.
 */
class Login {
    const DEFAULT_BRUTE_FORCE_COUNT         = 5;
    protected $brute_counter                = self::DEFAULT_BRUTE_FORCE_COUNT;
    protected $db;
    protected $login_stmt;
    protected $count_stmt;
    protected $brute_stmt;
    protected $clear_stmt;
    
    /*
     *  Constructor.
     */
    public function __construct(PDO $db) {
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
        $this->login_stmt->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, "\Guts3\Auth\LoginInfo");
        $this->login_stmt->execute();
        $user                           = $this->login_stmt->fetch();
        //  If no results were recovered, exit.
        if (!$user) {
            return FALSE;
        }
        //  If the user has tried to login too many times, exit.
        if ($this->checkBruteForce($user->id, 5)) {
            //  User is trying to brute-force.
            return FALSE;
        }
        //  Test login information.
        $password                       = hash("sha512", $password . $user->salt);
        if ($this->validate($user->pass, $password)) {
            //  Get the user-agent string of the user.
            $user_agent                 = $_SERVER["HTTP_USER_AGENT"];
            //  Get the username and id.
            $user_name                  = preg_replace("/[^a-zA-Z0-0_\-]+/", "", $user->username);
            $user_id                    = preg_replace("/[^0-9]+/", "", $user->id);
            //  Store this data in the _SESSION global.
            $_SESSION["user_name"]      = $user_name;
            $_SESSION["user_id"]        = $user_id;
            $_SESSION["user_pass"]      = $password;
            //  Login successful!
            return TRUE;
        } 
        
        //  Password is incorrect. Store the attempt in the database.
        $this->recordLoginAttempt($user->id, time());
        return FALSE;        
    }
    
    /*
     *  Helper method. Used for validation.
     */
    protected function validate($db_pass, $input_pass) {
        return $db_pass === $input_pass;
    }
    
    /*
     *  Records a login attempt for a specific username.
     */
    protected function recordLoginAttempt($user_id) {
        if (!isset($this->count_stmt) or empty($this->count_stmt)) {
            $this->count_stmt           = $this->db->prepare("INSERT INTO login_attempts (user_id, time) VALUES (:user_id, :time)");
        }
        $this->count_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $this->count_stmt->bindValue(":time", time(), PDO::PARAM_INT);
        $this->count_stmt->execute();            
    }
    
    /*
     *  Clears login attempts from the database. Useful for admins, but not to 
     *  be used by any other users. Can circumvent brute-force prevention.
     */
    public function clearLoginAttempts($user_id) {
        if (!isset($this->clear_stmt) or empty($this->clear_stmt)) {
            e("Creating clear_stmt.");
            $this->clear_stmt           = $this->db->prepare("DELETE FROM login_attempts WHERE user_id = :user_id");
        }
        try {
            e("Binding params to clear_stmt.");
            $this->clear_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
            e("Executing clear_stmt.");
            $this->clear_stmt->execute();
            return TRUE;
        } catch (PDOException $ex) {
            e("Exception when using clear_stmt.");
            return FALSE;
        }
    }
    
    /*
     *  Checks whether a user has attempted to login too many times.
     */
    public function checkBruteForce($user_id, $maximum) {
        $now                    = time();
        $valid_attempts         = $now - (2 * 60 * 60);
        $this->brute_stmt       = $this->db->prepare("SELECT count(*) FROM login_attempts WHERE user_id = :user_id AND time > :time");
        $this->brute_stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);
        $this->brute_stmt->bindValue(":time", $valid_attempts, PDO::PARAM_INT);
        $this->brute_stmt->execute();
        $count                  = $this->brute_stmt->fetchColumn();
        if ($count >= $maximum) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}