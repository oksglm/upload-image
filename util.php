<?php
require_once "log4php/Logger.php";
Logger::configure("config/log4php.xml");
$log = Logger::getLogger("Logger");
$ini = parse_ini_file("config/config.ini");

function cors() {
    // Allow from any origin
    if (isset($_SERVER["HTTP_ORIGIN"])) {
        // Decide if the origin in $_SERVER["HTTP_ORIGIN"] is one
        // you want to allow, and if so:
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Max-Age: 86400"); // cache for 1 day
        
    }
    // Access-Control headers are received during OPTIONS requests
    if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
        if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"])) {
            // may also be using PUT, PATCH, HEAD etc
            header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        }
        if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"])) {
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
        }
        exit(0);
    }
}

function authenticate() {
    header("WWW-Authenticate: Basic realm='Authentication System'");
    header("HTTP/1.0 401 Unauthorized");
    $GLOBALS['log']->info("You must enter a valid login ID and password to access this resource.");
    exit;
}

function validate() {
    if (isset($_SERVER["PHP_AUTH_USER"])) {
        $user = $_SERVER["PHP_AUTH_USER"];
        $pass = $_SERVER["PHP_AUTH_PW"];
        $validated = (isset($GLOBALS['ini'][$user])) && ($pass == decrypt($GLOBALS['ini'][$user]));
        if (!$validated) {
            authenticate();
        }
    } else {
        authenticate();
    }
}

function encrypt($password) {
    return openssl_encrypt($password, "AES-128-ECB", $GLOBALS['ini']["secret_key"]);
}

function decrypt($password) {
    return openssl_decrypt($password, "AES-128-ECB", $GLOBALS['ini']["secret_key"]);
}