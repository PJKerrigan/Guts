<?php
//  Database constants for sec_user login.
define("DB_HOST", "localhost");
define("DB_USER", "sec_user");
define("DB_PASS", "atm2byHtpyztYNcn");
//  Data-Source Name for PDO connections.
define("DB_NAME", "secure_login");define("DB_DSN", "mysql:dbname=" . DB_NAME . ";host=" . DB_HOST . ";charset=utf8");
//  Other database configuration constants.
define("CAN_REGISTER", "any");
define("DEFAULT_ROLE", "member");
define("SECURE", FALSE);