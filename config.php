<?php
session_start();

$db_host  = 'localhost';
$db_user  = 'root';
$db_pass  = 'hackyhack';
$db_name  = 'kependudukan';

// create connection
$conn = new mysqli($db_host, $db_user, $db_pass);

// check connection
if ($conn->connect_error) {
  die("DB connection failed: " . $conn->connect_error);
}
