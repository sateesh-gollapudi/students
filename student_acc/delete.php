<?php
session_start();
require_once 'header.php';
require_once 'connection.php';
// require_once 'student_nav.php';
if (empty($_SESSION["is_logged_in"])) {
    session_destroy();
    echo ("<script>toastr.error('Session Expired please login again');</script>");
    header("refresh:1;url=login.php");
    exit();
}
if (isset($_POST['submit']) && $_POST) {
    $password = md5($_POST['deleteacc-pwd']);
    $mail = $_SESSION['email'];
    //    $cmp_password = $_SESSION['pwd'];
    $q = "select * from student_register where email='" . $mail . "' and pwd='" . $password . "';";
    $q2 = mysqli_query($conn, $q);
    if (mysqli_num_rows($q2) == 1) {
        $q3 = "update student_register set status = 0 where email = '" . $mail . "';";
        $q4 = mysqli_query($conn, $q3);
        if ($q4) {
            echo '<script>toastr.success("Account deleted successfully. May see you again!");</script>';
            header("Refresh:2; url=logout.php");
        }
    } else {
        echo '<script>toastr.error("Incorrect password");</script>';
    }
}
?>
<div class="container">
    <div class="row text-center" style="margin-top: 7rem;">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card">
                <form method="post" name="confirm" id="confirm">
                    <div class="card-head text-center pt-3">
                        <i class="fas fa-user-shield fa-3x text-danger"></i>
                        <font class="font-weight-bold text-danger"> Delete account</font>
                        <hr>
                    </div>
                    <div class="card-body text-center">
                        <i class="fas fa-key fa-4x"></i>
                        <p>Enter password to delete your account</p>
                        <input type="password" id="deleteacc-pwd" name="deleteacc-pwd" placeholder="Enter password" class="form-control" />
                    </div>
                    <div class="card-footer p-3">
                        <input type="submit" name="submit" id="go" class="btn btn-danger float-left mb-2" value="Delete" />
                        <a href="<?= ROOT ?>student_acc/studenthome.php" class="btn btn-primary float-right mb-2">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>
<script>
    $('document').ready(function() {
        $('#confirm').submit(function() {
            var password = $('#deleteacc-pwd').val();
            if (password == "") {
                toastr.error('Please enter password to delete the account');
                $('#deleteacc-pwd').focus();
                return false;
            }
        });
        //        $('#go').click(function(){
        //            var url = "https://www.google.com";
        //            $(location).attr('href', url);
        //        })
    });
</script>