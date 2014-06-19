<?php
namespace Guts3\Session;

//	Using declarations.
use \PDO;
use \Exception;

/*
 *	A custom session-handler class.
 */
class CustomSessionHandler {

	protected $db			= NULL;
	protected $life;
	protected $start;
	protected $id;

	public function __construct(PDO $db) {
		$this->db			= $db;
	}
	
	public function open($path, $name) {
		$this->life			= ini_get("session.gc_maxlifetime");
	}	
	
	public function close() {
		$this->gc();
	}
	
	public function gc() {
		$sess_life			= time() - $this->life;
		try {
			$gc_stmt		= $this->db->prepare("DELETE FROM sessions WHERE last_access < :last_access");
			$gc_stmt->bindParam(":last_access", $sess_life, PDO::PARAM_INT);
			$gc_stmt->execute();
			return TRUE;
		} catch(PDOException $e) {
			return FALSE;
		}

	}
	
	public function read($session_id) {
		$read_stmt			= $this->db->prepare("SELECT * FROM sessions WHERE session_id = :session_id");
		$read_stmt->bindParam(":session_id", $session_id, PDO::PARAM_STR);
		$read_stmt->execute();
		$result				= $read_stmt->fetch(PDO::FETCH_ASSOC);
		
		if (!$result) {
			return NULL;
		}
		
		$sess_data			= unserialize($result["session_value"]);
		$this->start		= $result["session_start"];
		return $this->id	= $session_id;
	}
	
	public function write($session_id, $data) {
		if (!isset($this->start)) {
			$this->start	= time();
		}
		
		$serialized			= serialize($data);
		try {
			$write_stmt			= $this->db->prepare("INSERT INTO sessions (session_id, session_lastaccess, session_start, session_value) VALUES (:session_id, :session_lastaccess, :session_start, :session_value) ON DUPLICATE KEY UPDATE session_lastaccess = VALUES(session_lastaccess), session_value = VALUES(session_value)");
			$write_stmt->bindParam(":session_id", $session_id, PDO::PARAM_STR);
			$write_stmt->bindValue(":session_lastaccess", time(), PDO::PARAM_INT);
			$write_stmt->bindParam(":session_start", $this->start, PDO::PARAM_INT);
			$write_stmt->bindParam(":session_value", $serialized, PDO::PARAM_STR);
			$write_stmt->execute();
			return TRUE;
		} catch(PDOException $e) {
			return FALSE;
		}
	}
	
	public function destroy($session_id) {
		// TODO: Add destruction method.
	}
}

function HijackCheck() 
{
    // check the users user agent activity.
    if(isset($_POST['submit'])) 
    {
        if($_SESSION['PW_CHECKS'] < PW_MAX_CHECKS)
        {
            if(isset($_POST['password'])) 
            {
                if(!isset($_SESSION['PW_CHECKS'])) $_SESSION['PW_CHECKS'] = 1;
                if($_SESSION['PW_CHECKS'] <= PW_MAX_CHECKS) 
                {
                    $_SESSION['PW_CHECKS']++;
 
                    // check the password provided, if invalid show the password form again here.
                }
                else 
                {
                    // reset our session variables.
                    unset($_SESSION['UA_CHECKS']);
                    unset($_SESSION['HTTP_USER_AGENT']);
                    unset($_SESSION['PW_CHECKS']);
                }
            }
        }
        else
        {
            $this->destroy($this->_ses_id);
        }
    }
 
    // check to see if UA_CHECKS is instantiated, if not set it to 0
    if(!isset($_SESSION['UA_CHECKS'])) $_SESSION['UA_CHECKS'] = 0;
    // check to see if the users IP address has been set, if not set it.
    if(!isset($_SESSION['HTTP_USER_AGENT'])) $_SESSION['HTTP_USER_AGENT'] = md5($this->fingerprint.$_SERVER['HTTP_USER_AGENT']);
 
    // check to see if the UA has changed
    if($_SESSION['HTTP_USER_AGENT'] == md5($this->fingerprint.$_SERVER['HTTP_USER_AGENT']))
    {
        $_SESSION['UA_CHECKS']++;
    }
    else
    {
        // Check to see if the UA_CHECKS has been completed UA_THRESHOLD times
        // update the new UserAgent
        if($_SESSION['UA_CHECKS'] >= UA_THRESHOLD) 
        {
            // It's not normal for the users UA to change frequently
            $this->validate($pwError);
        }
        else
        {
            unset($_SESSION['UA_CHECKS']);
            unset($_SESSION['HTTP_USER_AGENT']);
        }
    }
}
