<?php
ob_start();
session_start();
require_once 'connection.php';
require_once 'header.php';
require_once 'student_nav.php';
$edit_email = $_SESSION['email'];
$edit_q = "select * from student_register where email='" . $edit_email . "'";
$edit_qurey = mysqli_query($conn, $edit_q);
if (mysqli_num_rows($edit_qurey) == 1) {
    $row = mysqli_fetch_assoc($edit_qurey);
    if (isset($_POST['submit'])) {
        $id = $_SESSION['id'];
        $edit_fname = $_POST['fname'];
        $edit_lname = $_POST['lname'];
        $edit_mail = $_POST['email'];
        $edit_gender = $_POST['gender'];
        $edit_branch = $_POST['branch'];
        $edit_phno = $_POST['phno'];
        $edit_year = $_POST['year'];
        $edit_q1 = "update student_register set fname='" . $edit_fname . "',lname='" . $edit_lname . "',email='" . $edit_email . "',gender='" . $edit_gender . "',branch='" . $edit_branch . "',phno='" . $edit_phno . "',year='" . $edit_year . "' where id = '" . $id . "';";
        $edit_query1 = mysqli_query($conn, $edit_q1);
        if (!$edit_q1) {
            echo '<script>toastr.error("Updation failed please try again.");</script>';
        } else {
            $_SESSION['message'] = "Details updated successfully";
            $url = ROOT . 'student_acc/studenthome.php?viewProfile=true';
            header("Location: " . $url);
            exit;
//            exit(header(" refresh:2, Location: ROOTstudent_acc/studenthome.php"));
        }
    }
}
ob_end_flush();
?>
<div class="container">
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            <div class="card text-center" style="border: 0;">
                <div class="card-head">
                    <h2>Edit profile</h2>
                </div>
                <div class="card-body">
                    <form method="post" name="edit" id="edit">
                        <input type="text" name="fname" id="fname" class="form-control mt-4" value="<?= $row['fname']; ?>" />
                        <input type="text" name="lname" id="lname" class="form-control mt-3" value="<?php echo $row['lname']; ?>" />
                        <input type="text" name="email" id="email" class="form-control mt-3" value="<?php echo $row['email']; ?>" />
                        <select class="form form-control mt-3" name="gender" id="gender">
                            <option value="">Gender</option>
                            <option value="male" <?= ($row['gender'] == 'male') ? 'selected' : '' ?>>Male</option>
                            <option value="female" <?= ($row['gender'] == 'female') ? 'selected' : '' ?>>Female</option>
                        </select>
                        <select class="form form-control mt-3" name="branch" id="branch">
                            <option value="">Select Branch</option>
                            <option value="cse" <?= ($row['branch'] == 'cse') ? 'selected' : '' ?>>CSE</option>
                            <option value="ece" <?= ($row['branch'] == 'ece') ? 'selected' : '' ?>>ECE</option>
                            <option value="civil" <?= ($row['branch'] == 'civil') ? 'selected' : '' ?>>CIVIL</option>
                            <option value="mech" <?= ($row['branch'] == 'mech') ? 'selected' : '' ?>>MECHANICAL</option>
                            <option value="eee" <?= ($row['branch'] == 'eee') ? 'selected' : '' ?>>EEE</option>
                        </select>
                        <input type="text" id="phno" name="phno" class="form-control mt-3" value="<?php echo $row['phno']; ?>" />
                        <select class="form form-control mt-3" id="year" name="year">
                            <option value="">Select Year</option>
                            <option value="1" <?= ($row['year'] == '1') ? 'selected' : '' ?>>1</option>
                            <option value="2" <?= ($row['year'] == '2') ? 'selected' : '' ?>>2</option>
                            <option value="3" <?= ($row['year'] == '3') ? 'selected' : '' ?>>3</option>
                            <option value="4" <?= ($row['year'] == '4') ? 'selected' : '' ?>>4</option>
                        </select>                        
                        <input type ="submit" class="btn btn-success mt-3" name="submit" />
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#edit').submit(function () {
            let fname = $('#fname').val();
            let lname = $('#lname').val();
            let email = $('#email').val();
            let gender = $('#gender').val();
            let branch = $('#branch').val();
            let phno = $('#phno').val();
            let year = $('#year').val();
            if (fname == "") {
                toastr.error("Enter First name.");
                $('#fname').focus();
                return false;
            }
            if (lname == "") {
                toastr.error("Enter Second name.");
                $('#lname').focus();
                return false;
            }
            if (email == "") {
                toastr.error("Enter email.");
                $('#email').focus();
                return false;
            }
            if (gender == "") {
                toastr.error("Select gender.");
                $('#gender').focus();
                return false;
            }
            if (branch == "") {
                toastr.error("Select branch.");
                $('#branch').focus();
                return false;
            }
            if (phno == "") {
                toastr.error("Enter phone number.");
                $('#phno').focus();
                return false;
            }
            if (year == "") {
                toastr.error("Select year.");
                $('#year').focus();
                return false;
            }
        });
    });
</script>