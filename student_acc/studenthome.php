<?php
session_start();
require_once 'connection.php';
if (empty($_SESSION["is_logged_in"])) {
    session_destroy();
    echo ("<script>toastr.error('Session Expired please login again');</script>");
    header("refresh:1;url=login.php");
    exit();
}
require_once 'student_nav.php';

if (isset($_POST['submit'])) {

    $email = $_SESSION['email'];
    $image = $_FILES['image']['name'];

    $temp = explode(".", $_FILES["image"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);
    $target = "images/profile/" . $newfilename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        $sql = "update student_register set image='" . $target . "'where email='" . $email . "'";
        // execute query
        mysqli_query($conn, $sql);
        echo '<script>toastr.success("Profile picture updated successfully");</script>';
    } else {
        echo '<script>toastr.warning("Failed to upload image. Please try again later.!");</script>';
    }
}

if (isset($_GET['viewProfile'])) {
    $vemail = $_SESSION['email'];
    $q = "select * from student_register where email='" . $vemail . "';";
    $rec = mysqli_query($conn, $q);
    $res = mysqli_fetch_array($rec, MYSQLI_ASSOC);
    ?>
    <!--//Display student details-->
    <div class="container mt-5">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <?php echo $_SESSION['message']; ?>
            </div>
        <?php endif; ?>
        <?php unset($_SESSION['message']); ?>
        <div class="row">
            <div class="col-lg-12 col-md-6 mb-3">
                <div id="views">
                    <div>
                        <?php
                        $mail = $_SESSION['email'];
                        $re = mysqli_query($conn, "select image from student_register where email='" . $mail . "';");
                        while ($row = mysqli_fetch_array($re)) {
                            ?>
                        <a href="<?= $row['image']; ?>"><img src="<?= $row['image']; ?>" class="img-thumbnail" width="150" height="auto" /></a>
                        <?php } ?>
                    </div>
                    <form method="post" enctype="multipart/form-data">
                        <div class="mt-2">
                            <input type="file" id="target" name="image" class="file-upload center-block" />
                            <input type="submit" name='submit' class="btn btn-outline-dark btn-sm" />
                        </div>
                    </form>
                </div>
                <div class="input-group mt-5">
                    <input type="text" value="<?php echo $res['fname']; ?>" disabled class="m-auto form-control" />
                    <input type="text" value="<?php echo $res['lname']; ?>" disabled class="form-control" />
                </div>
                <div class="input-group mt-3">
                    <input type="text" value="<?php echo $res['email'] ?>" disabled class="form-control" />                    
                </div>
                <div class="input-group mt-3">                    
                    <input type="text" value="<?php echo $res['phno'] ?>" disabled class="form-control" />
                    <input type="text" value="<?php echo $res['gender'] ?>" disabled class="form-control" />
                </div>
                <div class="input-group mt-3">
                    <input type="text" value="<?php echo $res['year'] ?>" disabled class="form-control" />
                    <input type="text" value="<?php echo $res['branch'] ?>" disabled class="form-control" />
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>
<footer class="page-footer font-small blue">
    <!-- Copyright -->
    <div class="footer-copyright text-center py-3">
        <font>Copyright &copy; <?php echo date('Y'); ?></font>
        <?php $urlfoot = ROOT . 'index.php'; ?>
        <font><a href="<?= $urlfoot; ?>">Student Login</a></font>
    </div>
    <!-- Copyright -->
</footer>


<script>
    //    To read Image
    $(document).ready(function () {


        var readURL = function (input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('.avatar').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }


        $(".file-upload").on('change', function () {
            readURL(this);
        });
    });
    //To crop Image
    var jcrop_api;
    var canvas;
    var context;
    var image;
    var prefsize;

    function loadImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                image = new Image();
                image.src = e.target.result;
                validateImage();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Password Validation
    $(document).ready(function () {
        $('#pwd-validation').submit(function () {
            let new_pwd = $('#new-pwd').val();
            let c_pwd = $('#c-pwd').val();
            if (new_pwd == "") {
                toastr.error('Please enter new password');
                $('#new-pwd').focus();
                return false;
            }
            if (c_pwd == "") {
                toastr.error('Confirm new password');
                $('#c-pwd').focus();
                return false;
            }
            if (new_pwd != c_pwd) {
                toastr.error('Passwords must be match');
                return false;
            }
        });
    });
</script>