<?php
session_start();
require_once 'connection.php';
require_once 'header.php';
require_once 'admin_nav.php';
if (empty($_SESSION["is_logged_in"])) {
    session_destroy();
    echo ("<script>toastr.error('Session Expired please login again');</script>");
    header("refresh:1;url=login.php");
    exit();
}
?>
<a href="<?= ROOT?>admin/logout.php">Logout</a>