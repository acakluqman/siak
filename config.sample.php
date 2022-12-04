<?php
ob_start();
session_start();

// uncomment
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./vendor/autoload.php');

$alert = new \Plasticbrain\FlashMessages\FlashMessages();

$base_url = 'http://localhost:8000/'; // sertakan '/' dibelakang
$db_host  = 'localhost';              // host db
$db_user  = 'root';                   // username db
$db_pass  = 'hackyhack';              // password db
$db_name  = 'sipendu';                // nama db

try {
  $conn = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Connection failed: " . $e->getMessage());
}
