<?php
namespace Guts3\Auth;

/*
 *  Simple class representing the MySQL database row structure.
 */
class LoginInfo {
    public $id;
    public $username;
    public $email;
    public $pass;
    public $salt;
}