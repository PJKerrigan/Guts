<?php
namespace Guts3\Security;

use \Exception;
use \InvalidArgumentException;

/*
 *  A more secure session-handler class.
 */
class SessionHandler {
    
    /*
     *  Starts a session securely.
     */
    public function start($secure = TRUE) {
        $sessionName        = "sec_session_id";
        $httponly           = TRUE;
        
        if (ini_set("session.use_only_cookies", 1) === FALSE) {
            throw new Exception("Could not initiate secure session. Cookies must be enabled in PHP settings.");
        }
        //  Get the current cookie parameters.
        $cookieParams       = session_get_cookie_params();
        session_set_cookie_params(
                $cookieParams["lifetime"],
                $cookieParams["path"],
                $cookieParams["domain"],
                $secure,
                $httponly);
        //  Set the session name to the one above.
        session_name($sessionName);
        session_start();
        session_regenerate_id();
    }
}