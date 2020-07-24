<?php
session_start();
require_once 'connection.php';
require_once 'header.php';
require_once 'student_nav.php';
if (empty($_SESSION["is_logged_in"])) {
    session_destroy();
    echo ("<script>toastr.error('Session Expired please login again');</script>");
    header("refresh:1;url=login.php");
    exit();
}
?>

<div class="row">    
    <div class="col-lg-3"></div>
    <div class="col-lg-6">
        <div class="alert alert-danger d-none" id="error">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <span>Password must contain capital letter, special character lower character and minimum 8 characters. </span>
        </div>
        <form id="pwd-validation" method="post">
            <section class="p-5">
                <div class="input-group input-group-lg mt-5 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock" style="color:#7f03fc;"></i></span>
                    </div>
                    <input type="password" class="form-control" placeholder="Enter new password" name="new-pwd" id="new-pwd" aria-label="Password" aria-describedby="basic-addon1">
                </div>
                <div class="input-group input-group-lg mt-5 mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock" style="color:#7f03fc;"></i></span>
                    </div>
                    <input type="password" class="form-control" placeholder="Confirm new password" name="c-pwd" id="c-pwd" aria-label="Password" aria-describedby="basic-addon1">
                </div>
                <input type="submit" name="change" id="change" class="login-button mt-3" value="Change" />
            </section>
        </form>
    </div>
    <div class="col-lg-3"></div>
</div>
<?php
if (isset($_POST['change'])) {
    $newpwd = md5(trim($_POST['new-pwd']));
    $changepwdemail = $_SESSION['email'];
    $oldpwd = "select pwd from student_register where email='" . $changepwdemail . "';";
    $pwdresult = mysqli_query($conn, $oldpwd);
    if ($pwdresult == $newpwd) {
        echo "<script>toastr.error('This password is already used once. Please try new one!');</script>";
    } else {
        $updatepwd = "update student_register set pwd='" . $newpwd . "'where email='" . $changepwdemail . "';";
        $changepassword = mysqli_query($conn, $updatepwd);
        if ($changepassword) {
            echo "<script>toastr.success('Password updated successfully.');</script>";
            // header("Refresh:2; url=studenthome.php");
        }
    }
}
require_once 'footer.php';
?>
<script>
    $('document').ready(function () {
        $('#pwd-validation').submit(function () {
            let newpwd = $('#new-pwd').val();
            let cpwd = $('#c-pwd').val();
            if (newpwd == '') {
                toastr.error('Enter new password');
                $('#new-pwd').focus();
                return false;
            }
            if (cpwd == '') {
                toastr.error('Re-enter password to confirm');
                $('#c-pwd').focus();
                return false;
            }
            if (newpwd != cpwd) {
                toastr.error('Password must match..!');
                return false;
            }
            if (!(newpwd.match(/[a-z]/g) && newpwd.match(
                    /[A-Z]/g) && str.match(
                    /[0-9]/g) && str.match(
                    /[^a-zA-Z\d]/g) && str.length >= 8))
            {
                $('#error').removeClass('d-none');
                return false;
            }
        });
    })
</script>