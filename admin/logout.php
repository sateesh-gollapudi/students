<?php
session_start();
require_once 'connection.php';
session_unset();
session_destroy();
header("Location: login.php");
die();
?>
