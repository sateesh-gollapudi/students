<?php
session_start();
require_once 'connection.php';
require_once 'header.php';
if (isset($_POST['submit'])) {
    $uname = $_POST['uname'];
    $pwd = md5(trim($_POST['pwd']));
//    $q = "update adminlogin where id";
    $q = "select * from adminlogin where uname='" . $uname . "';";
    $r = mysqli_query($conn, $q);
    if (mysqli_num_rows($r) == 1) {
        $res = mysqli_fetch_assoc($r);
        $name = $res['uname'];
        $pass = $res['pwd'];
        $id = $res['id'];
        $_SESSION['is_logged_in'] = true;
        $_SESSION['id'] = $id;
        $_SESSION['uname'] = $name;
        $_SESSION['pwd'] = $pass;
        $ip = $_SERVER['REMOTE_ADDR'];
        $q1 = "update adminlogin set ip='" . $ip . "' where id='" . $id . "';";
        $r1 = mysqli_query($conn, $q1);
        if (($uname == $name) && ($pwd == $pass)) {
            header("Location: adminhome.php");
        } else {
            $_SESSION['invalidlogin'] = 'Invalid login details.';
        }
    } else {
        $_SESSION['invaliduser'] = 'Invalid user';
    }
}
if (isset($_SESSION['invalidlogin'])) {
    echo '<script>toastr.error("Invalid login details.");</script>';
    unset($_SESSION['invalidlogin']);
}
if (isset($_SESSION['invaliduser'])) {
    echo '<script>toastr.error("Invalid user!");</script>';
    unset($_SESSION['invaliduser']);
}
?>
<div class="container-fluid h-100">
    <div class="row h-100 m-0">
        <div class="col-lg-6 h-100" style="background-image: url('images/door.png'); background-size: cover;">           
        </div>        
        <div class="col-lg-6 h-100">
            <div class="col-lg-12 text-center" style="margin-top: 7rem;">
                <h2><i class="fas fa-user-shield fa-2x"></i> Admin login</h2>
                <div class="shadow-lg p-3 mb-5 bg-white rounded">
                    <div class="card p-5" style="border:none;">
                        <div class="card-body">
                            <form method="post" name="admin" id="admin">
                                <input type="text" class="form-control mt-3" name="uname" id="uname" placeholder="Enter username" />
                                <input type="password" class="form-control mt-3" name="pwd" id="pwd" placeholder="Enter password" />
                                <div class="mt-3">
                                    <input type="submit" class="btn btn-outline-success" name="submit" id="submit"/>
                                    <span class="spinner-border spinner-border-sm d-none ml-3 mt-3 text-success" id="loader" role="status" aria-hidden="true"></span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $('document').ready(function () {
        $('#admin').submit(function () {
            let uname = $('#uname').val();
            let pwd = $('#pwd').val();
            if (uname == '') {
                toastr.error("Enter username");
                $('#uname').focus();
                return false;
            }
            if (pwd == '') {
                toastr.error("Enter password");
                $('#pwd').focus();
                return false;
            }

            $('#loader').removeClass("d-none");
        });
    });
</script>