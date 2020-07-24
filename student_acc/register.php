<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
require_once 'header.php';
//require_once("nav.php");
require_once 'connection.php';
if (isset($_POST["submit"]) && $_POST) {
    $fname = mysqli_real_escape_string($conn, $_POST["fname"]);
    if (empty($fname)) {
        echo '<script>toastr.error("Special characters are not allowed..!");</script>';
    }
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $pwd = md5($_POST["pwd"]);
    $gender = $_POST["gender"];
    $phno = $_POST["phno"];
    $branch = $_POST["branch"];
    $year = $_POST["year"];
    $created_date = date('Y-m-d H:i:s');
    $ip = $_SERVER['REMOTE_ADDR'];
    $sql = 'select * from student_register where email="' . $email . '"';
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    $res = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $status = $res['status'];
//    if ($status == 1) {
    if ((mysqli_num_rows($result) > 0) && ($status == 1)) {
        echo '<script>toastr.error("Entered email already exists..!");</script>';
    } else {
        $q = "insert into student_register (fname, lname, email, pwd, gender, phno, branch, year, ip, created_date) values('" . $fname . "', '" . $lname . "', '" . $email . "', '" . $pwd . "', '" . $gender . "', '" . $phno . "', '" . $branch . "', '" . $year . "','" . $ip . "','" . $created_date . "');";
        $insert = mysqli_query($conn, $q);
        if ($insert) {
            $_SESSION['login'] = 'Registered successfully. Please login to continue';
//            sleep(2);
            $url = ROOT . 'student_acc/login.php';
            header("Location: " . $url);
        } else {
            echo '<script> alert("Error 200") </script>';
        }
    }
//    }
}
session_destroy();
?>
<style>
    html, body{
        height: 100%;
        margin: 0rem;
    }
</style>
<div class="container-fluid h-100" style="margin: 0px;">
    <div class="row h-100">
        <div class="col-lg-6 h-100 text-center shadow-lg p-3 mb-5 rounded" style="background: #7f03fc; color: #fff;">
            <div class="d-none" id="show-up">
                <a href="index.php"><img src="images/logo.png" width="200" /></a>
                <h1>Welcome to registration page</h1>
                <h2>Still haven't registered!</h2>
                <p>Well what are you waiting for register now.</p>
                <i class="fas fa-arrow-right fa-4x"></i>
            </div>
        </div>
        <div class="col-lg-6 h-100">            
            <div class="shadow-lg p-3 mb-5 bg-white rounded" id="register-box">
                <div class="card" style="border:none; padding: 5rem;">
                    <div class="card-head text-center pt-2">
                        <h2>Register</h2>
                    </div>
                    <div class="card-body">
                        <form id="register_form" class="register_form" method="post" autocomplete="off">
                            <div class="input-group pb-2">
                                <input type="text" name="fname" id="fname" placeholder="Enter First Name" class="form form-control">
                                <input type="text" name="lname" id="lname" placeholder="Enter Last Name" class="form form-control">
                            </div>
                            <input type="email" name="email" id="email" placeholder="Enter Email" class="form form-control">
                            <div class="input-group pt-2">
                                <input type="password" name="pwd" id="pwd" placeholder="Enter password" class="form form-control">
                                <input type="password" name="cpwd" id="cpwd" placeholder="Re-enter password" class="form form-control">
                            </div>
                            <div class="input-group pt-2">
                                <select class="form form-control" name="gender" id="gender">
                                    <option value="">Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                                <input type="text" class="form form-control" onkeypress="return isNumberPress(event)" name="phno" id="phno" placeholder="Enter Phone number">
                            </div>
                            <div class="input-group pt-2">
                                <select class="form form-control" name="branch" id="branch">
                                    <option value="">Select Branch</option>
                                    <option value="cse">CSE</option>
                                    <option value="ece">ECE</option>
                                    <option value="civil">CIVIL</option>
                                    <option value="mech">MECHANICAL</option>
                                    <option value="eee">EEE</option>
                                </select>
                                <select class="form form-control" id="year" name="year">
                                    <option value="">Select Year</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <input type="submit" class="login-button mt-3" name="submit" value="Register Now">
                            <div class="alert alert-danger d-none" id="error">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <span>Password must contain capital letter, special character lower character and minimum 8 characters. </span>
                            </div>
                            <a href="login.php" class="float-right pt-4" id="for-reg">Already have an account? Click here to login.</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once 'footer.php'; ?>
<script>
    var re_phno = new RegExp("\\d{10}", "g");
    $('document').ready(function () {
        $("input, textarea").on("keypress", function (e) {
            if (e.which === 32 && !this.value.length)
                e.preventDefault();
        });

        $('#register_form').submit(function () {
            var fname = $('#fname').val();
            var lname = $('#lname').val();
            var email = $('#email').val();
            var pwd = $('#pwd').val();
            var cpwd = $('#cpwd').val();
            var gender = $('#gender').val();
            var phno = $('#phno').val();
            var branch = $('#branch').val();
            var year = $('#year').val();
            if (fname == '') {
                toastr.error('please enter first name');
                $('#fname').focus();
                return false;
            }
            if (lname == '') {
                toastr.error('please enter last name');
                $('#lname').focus();
                return false;
            }
            if (email == '') {
                toastr.error('please enter email');
                $('#email').focus();
                return false;
            }
            if (pwd == '') {
                toastr.error('please enter password');
                $('#pwd').focus();
                return false;
            }
            if (cpwd == '') {
                toastr.error('please re enter password to confirm');
                $('#cpwd').focus();
                return false;
            }
            if (pwd != cpwd) {
                toastr.error('your both passwords must match');
                $('#cpwd').focus();
                return false;
            }
            if (gender == '') {
                toastr.error('please select gender');
                $('#gender').focus();
                return false;
            }
            if (phno == '') {
                toastr.error('please enter phone number');
                $('#phno').focus();
                return false;
            }
            if (!(phno.match(re_phno)) && !(phno.length == 10)) {
                toastr.error('Phone number is not valid');
                $('#phno').focus();
                return false;
            }
            if (branch == '') {
                toastr.error('please select branch');
                $('#branch').focus();
                return false;
            }
            if (year == '') {
                toastr.error('please select year');
                $('#year').focus();
                return false;
            }
            if (!(pwd.match(/[a-z]/g) && pwd.match(
                    /[A-Z]/g) && str.match(
                    /[0-9]/g) && str.match(
                    /[^a-zA-Z\d]/g) && str.length >= 8))
            {
                $('#error').removeClass('d-none');
                return false;
            }
        });
    });

    // To print only numbers in phone number field
    function isNumberPress(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    $(document).ready(function () {
        $('#show-up').fadeIn(2000).removeClass('d-none');
        //        $('#show-register').click(function() {
        //            $("#register-box").fadeToggle(1000).removeClass('d-none');
        //        });
    });
</script>
