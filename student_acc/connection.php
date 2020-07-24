<?php

$root = (isset($_SERVER['HTTPS']) ? "https://" : "http://") . $_SERVER['HTTP_HOST'];
$root .= '/students/';
define('ROOT', $root);
$host = 'localhost:3306';
$username = 'root';
$password = '';
$dbname = 'studentdb';
$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die('<script>alert("Database connection error.");</script>');
}
?>
