<?php

// Enable CORS for all domains (for development)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

/* ----------------------------------- So I can see PHP errors ---------------------------------- */
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set('America/New_York');
/* ---------------------------------------------------------------------------------------------- */

function get_db_config()
{
  $prod_base = '/api/';
  $script_base = substr($_SERVER['PHP_SELF'], 0, strlen($prod_base));
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::MYSQL_ATTR_FOUND_ROWS => true
    // PDO::ATTR_EMULATE_PREPARES => false
  );
  if ($script_base === $prod_base) {
    $config = (object) array('username' => 'root', 'password' => 'me1neDSQ9d1/', 'dsn' => 'mysql:host=localhost;dbname=preflight;charset=utf8mb4', 'options' => $options);
    return $config;
  } else {
    opcache_reset();
    $config = (object) array('username' => 'root', 'password' => 'me1neDSQ9d1/', 'dsn' => 'mysql:host=localhost;dbname=preflight-dev;charset=utf8mb4', 'options' => $options);
    return $config;
  }
}
