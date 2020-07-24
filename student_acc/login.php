<?php
session_start();
require_once 'connection.php';
require_once 'header.php';
//require_once("nav.php");
if (isset($_SESSION['login'])) {
    echo '<script>toastr.success("Registered successfully. Please login to continue");</script>';
    unset($_SESSION['login']);
}
if(isset($_SESSION['message'])){
    echo '<script>toastr.success("Updated successfully. Please login to continue");</script>';
    unset($_SESSION['message']);
}
if (isset($_POST["submit"])) {
    $user = trim($_POST["uname"]);
    $pass = md5(trim($_POST["pwd"]));
    $sql = "select * from student_register where email ='" . $user . "' and pwd = '" . $pass . "'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['id'] = $row['id'];
        $_SESSION['name'] = $row['fname'] . ' ' . $row['lname'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['phno'] = $row['phno'];
        $_SESSION['is_logged_in'] = true;
        $_SESSION['status'] = $row['status'];
        if ($_SESSION['status'] == 0) {
            echo ("<script>toastr.error('No details found with this email. Please register and login');</script>");
            session_destroy();
            header("Refresh:2; url=login.php");
            die();
        } else {
            header("Location: studenthome.php");
        }
    } else {
        echo ("<script>toastr.error('Invalid Username or Password');</script>");
        //        header("Refresh:0; url=login.php");
    }
}
?>
<style>
    html, body {
    height: 100%;
    margin: 0;
}
</style>
<div class="container-fluid h-100">
    <div class="row h-100">
        <div class="col-lg-6 h-100 text-center" style="background: #7f03fc; color: #fff; ">
            <div class="d-none" id="show-up">
                <a href="index.php"><img src="images/logo.png" width="200" /></a>
                <h1>Welcome Back!</h1>
                <p class="pt-2 font-weight-bold">Glad to see you again</p>
                <p class="pt-2">I hope you having a good day </p>
            </div>
        </div>
        <div class="col-lg-6 h-100 text-center" id="login-box">
            <div class="mt-3" style="border:none; padding: 7rem 3rem;">                
                <h1><i class="fas fa-sign-in-alt"></i> Login</h1>
                <div>
                    <form id="login_form" name="login_form" method="post">
                        <div class="input-group input-group-lg mt-5 mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-envelope" style="color:#7f03fc;"></i></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Username" name="uname" id="uname" aria-label="Username" aria-describedby="basic-addon1">
                        </div>
                        <div class="input-group input-group-lg mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><i class="fas fa-lock" style="color:#7f03fc;"></i></span>
                            </div>
                            <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Password" aria-label="Password" aria-describedby="basic-addon1">
                        </div>
                        <div>
                            <a id="for-reg" href="forget.php" class="float-left">Forget password?</a>
                            <a id="for-reg" href="register.php" class="float-right">Not registered yet? Register Here!</a><br><br>
                        </div>
                        <input type="submit" class="login-button" name="submit">
                        <span class="spinner-border spinner-border-sm d-none ml-3 text-success" id="loader" role="status" aria-hidden="true"></span>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#login_form').submit(function () {
            let uname = $('#uname').val();
            let pwd = $('#pwd').val();
            if (uname == '') {
                toastr.error('Please enter username');
                $('#uname').focus();
                return false;
            }
            if (pwd == '') {
                toastr.error('Please enter password');
                $('#pwd').focus();
                return false;
            }
            $('#loader').removeClass("d-none");
        });
    });
    $(document).ready(function () {
        $('#show-up').fadeIn(2000).removeClass('d-none');
    })
</script>
</body>

</html>