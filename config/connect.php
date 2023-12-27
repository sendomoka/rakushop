<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Jakarta');

$host = "localhost";
$user = "ecom4781_jamalinux";
$pass = "Kohuji098.";
$db = "ecom4781_rakushop";

if ($_SERVER['HTTP_HOST'] == 'localhost' || strpos($_SERVER['HTTP_HOST'], 'rakushop.test') !== false) {
    $user = "root";
    $pass = "";
    $db = "rakushop";
}

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>