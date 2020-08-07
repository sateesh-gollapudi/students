<?php
session_start();
require_once 'connection.php';
require_once 'header.php';
require_once 'admin_nav.php';
if (empty($_SESSION["is_logged_in"])) {
    session_destroy();    
    header("Location: login.php");
    exit();
}
?>