<?php
require_once 'connection.php';
require_once 'header.php';
require_once 'mail/mail.php';
//require_once '../nav.php';
?>
<?php
ob_start();
if (isset($_POST['submit'])) {
    $forget_email = $_POST['email'];
    $forget_query = "select email from student_register where email='" . $forget_email . "'";
    $forget_q = mysqli_query($conn, $forget_query);
    if (mysqli_num_rows($forget_q) == 1) {
        $data = mysqli_fetch_assoc($forget_q);

        $str = md5(mt_rand(1111, 9999) . date('YmdHis'));
        $forget_query1 = "update student_register set forget_recover_key='" . $str . "'where email='" . $forget_email . "';";
        $forget_q1 = mysqli_query($conn, $forget_query1);
        $to = $data['email'];
        $subject = "Reset Password Recovery Link";
        $message = '<h2>Please click given link below to reset your password</h2>'
                . ' <br> <a href="' . ROOT . 'student_acc/reset-password.php?str=' . $str . '" target="_blank">Click Here</a>'
        ;
        // Always set content-type when sending HTML email
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $msg = sendMail($to, $subject, $message, $headers);
        //$url = ROOT . 'student_acc/forget.php';
        //echo $url; exit;
        // header("refresh: 5");
        $_SESSION['message'] = 'Reset link was send to your email. Please check your mail and continue.';
    } else {
        echo '<script>toastr.error("Entered email not exist in Database..!");</script>';
    }
}
ob_end_flush();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo $_SESSION['message']; ?>
                </div>
            <?php endif; ?>
            <div class="hold-transition login-page login-box" style="margin-top: 5rem;;">
                <div class="login-logo">
                    <a href="login.php"><b>Student</b> Login</a>
                </div>
                <!-- /.login-logo -->
                <div class="card">
                    <div class="card-body login-card-body">
                        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

                        <form name='forget' id="forget" method="post">
                            <div class="input-group mb-3">
                                <input type="email" name='email' id="email" class="form-control" placeholder="Email">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" name="submit" class="btn btn-primary btn-block">Request new password</button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>

                        <p class="mt-3 mb-1">
                            <a href="login.php">Login</a>
                        </p>
                        <p class="mb-0">
                            <a href="register.php" class="text-center">Register a new membership</a>
                        </p>
                    </div>
                    <!-- /.login-card-body -->
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>
<script>
    $('document').ready(function () {
        $('#forget').submit(function () {
            let email = $('#email').val();
            if (email == '') {
                toastr.error('Enter email');
                $('#email').focus();
                return false;
            }
        });
    });
</script>
<?php require_once 'footer.php'; ?>
