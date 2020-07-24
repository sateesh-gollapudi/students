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
$branch_name = '';
if (isset($_POST['bran']) && $_POST['bran']) {
    $branch_name = $_POST['bran'];
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-3">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <form class="input-group my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" name="term" placeholder="Enter Name" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="fname">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <form method="post" name="filter-branch" id="sel">
                        <div class="input-group">
                            <select class="form-control mr-2" name="bran" id="select">
                                <option value="">Select Branch</option>
                                <option value="cse" <?= ($branch_name == 'cse') ? 'selected' : '' ?>>CSE</option>
                                <option value="ece" <?= ($branch_name == 'ece') ? 'selected' : '' ?>>ECE</option>
                                <option value="civil" <?= ($branch_name == 'civil') ? 'selected' : '' ?>>CIVIL</option>
                                <option value="mech" <?= ($branch_name == 'mech') ? 'selected' : '' ?>>MECHANICAL</option>
                                <option value="eee" <?= ($branch_name == 'eee') ? 'selected' : '' ?>>EEE</option>
                            </select>
                            <input type="submit" name="filter" id="filter" class="btn btn-outline-success" value="Filter" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <form class="input-group my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" name="term" placeholder="Enter Email" aria-label="Search">
                        <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="email">Search</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <form method="post" name="filter-branch" id="sel">
                        <div class="input-group">
                            <select class="form-control mr-2" name="bran" id="select">
                                <option value="">Select Branch</option>
                                <option value="cse" <?= ($branch_name == 'cse') ? 'selected' : '' ?>>CSE</option>
                                <option value="ece" <?= ($branch_name == 'ece') ? 'selected' : '' ?>>ECE</option>
                                <option value="civil" <?= ($branch_name == 'civil') ? 'selected' : '' ?>>CIVIL</option>
                                <option value="mech" <?= ($branch_name == 'mech') ? 'selected' : '' ?>>MECHANICAL</option>
                                <option value="eee" <?= ($branch_name == 'eee') ? 'selected' : '' ?>>EEE</option>
                            </select>
                            <input type="submit" name="filter" id="filter" class="btn btn-outline-success" value="Filter" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <table class="table table-hover" id="filter-table">
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Branch</th>
                <th>Year</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody class="text-center">
            <?php
            if (isset($_POST['filter'])) {
                $bran = $_POST['bran'];
                $filter_branch = "select * from student_register where branch='" . $bran . "'and status=1;";
                $filter_q = mysqli_query($conn, $filter_branch);
                if (mysqli_num_rows($filter_q) > 0) {
                    while ($b = mysqli_fetch_array($filter_q, MYSQLI_ASSOC)) {
                        $b_id = $b['id'];
                        $b_fname = $b['fname'];
                        $b_lname = $b['lname'];
                        $b_email = $b['email'];
                        $b_gender = $b['gender'];
                        $b_phno = $b['phno'];
                        $b_branch = $b['branch'];
                        $b_year = $b['year'];
//                                                    $b_image = $b['image'];
                        ?>
                        <tr>
                            <td><?= $b_id; ?></td>
                            <td><?= $b_fname; ?></td>
                            <td><?= $b_lname; ?></td>
                            <td><?= $b_email; ?></td>
                            <td><?= $b_gender; ?></td>
                            <td><?= $b_phno; ?></td>
                            <td><?= $b_branch; ?></td>                                           
                            <td><?= $b_year; ?></td>                                               
                            <td>
                                <i class="fas fa-user-edit mr-2 btn" onclick="filterstudentdetails('<?= $b_id; ?>')"></i> 
                                <i class="fas fa-trash text-danger btn" onclick="filterdeletestudentdetails('<?= $b_id; ?>')"></i>
                            </td>
                        </tr> 
                        <?php
                    }
                } else {
                    echo "<script>tostar.error('No records found');</script>";
                }
            }
            ?>
            <?php
            //******************************Filter by fname*****************************************************
            if (isset($_POST['fname'])) {
                if (!empty($_REQUEST['fname'])) {

                    $term = mysqli_real_escape_string($conn, $_REQUEST['term']);
                    $sql = "SELECT * FROM student_register WHERE fname OR lname LIKE '%" . $term . "%'";
                    $r_query = mysqli_query($conn, $sql);
                    if ($r_query) {
                        while ($row = mysqli_fetch_array($r_query)) {
                            $b_id = $row['id'];
                            $b_fname = $row['fname'];
                            $b_lname = $row['lname'];
                            $b_email = $row['email'];
                            $b_gender = $row['gender'];
                            $b_phno = $row['phno'];
                            $b_branch = $row['branch'];
                            $b_year = $row['year'];
//                                                    $b_image = $b['image'];
                            ?>
                            <tr>
                                <td><?= $b_id; ?></td>
                                <td><?= $b_fname; ?></td>
                                <td><?= $b_lname; ?></td>
                                <td><?= $b_email; ?></td>
                                <td><?= $b_gender; ?></td>
                                <td><?= $b_phno; ?></td>
                                <td><?= $b_branch; ?></td>                                           
                                <td><?= $b_year; ?></td>                                               
                                <td>
                                    <i class="fas fa-user-edit mr-2 btn" onclick="filterstudentdetails('<?= $b_id; ?>')"></i> 
                                    <i class="fas fa-trash text-danger btn" onclick="filterdeletestudentdetails('<?= $b_id; ?>')"></i>
                                </td>
                            </tr> 
                            <?php
                        }
                    } else {
                        echo "<script>tostar.error('No records found');</script>";
                    }
                } else {
                    die('Query not executed');
                }
            }
            ?>
        </tbody>
    </table>
</div>
<!--Modal code-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" name="editing-details" id="editing-details">
                <input type="hidden" name="itemid" id="itemid" value="" />
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <img src="" class="img-thumbnail mb-2" id="stu_img" width="150" height="auto"/>
                    <div class="input-group">
                        <input type="text" name="fname" value="" class="form-control" id="fname"/>
                        <input type="text" name="lname" value="" class="form-control" id="lname"/>
                    </div>
                    <div class="input-group mt-2">
                        <input type="email" name="email" value="" class="form-control" id="email"/>                                            
                    </div>
                    <div class="input-group mt-2">
                        <select class="form form-control" name="gender" id="gender">
                            <option value="">Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <input type="text" name="phno" value="" class="form-control" id="phno"/>
                    </div>
                    <div class="input-group mt-2">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-success" value="Submit" name="edit" id="submit">
                </div>
            </form>
        </div>
    </div>
</div>
<!--Modal ends-->
<?php
if (isset($_POST['edit'])) {
    $itemid = $_POST['itemid'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $gender = $_POST['gender'];
    $phno = $_POST['phno'];
    $branch = $_POST['branch'];
    $year = $_POST['year'];
    //echo $id; exit;
    $edit_q1 = "update student_register set fname='" . $fname . "',lname='" . $lname . "',email='" . $email . "',gender='" . $gender . "',branch='" . $branch . "',phno='" . $phno . "',year='" . $year . "' where id = '" . $itemid . "';";
    $edit_query1 = mysqli_query($conn, $edit_q1);
    if (!$edit_q1) {
        echo '<script>toastr.error("Updation failed please try again.");</script>';
    } else {
        echo '<script>toastr.success("Details updated successfully");</script>';
    }
}
?>
<script>
    $('document').ready(function () {
        $('#sel').submit(function () {
            let branch = $('#select').val();
            if (branch == '') {
                toastr.error("Select branch to display");
                $('#select').focus();
                return false;
            }
        });
    });
    function filterstudentdetails(id) {
        var formdata = {'id': id, 'type': 'edit'};
        var url = '<?= ROOT ?>admin/ajax.php';
        $.ajax({
            type: 'POST',
            data: formdata,
            url: url,
            success: function (data) {
                data = $.parseJSON(data);
                var img = '<?= ROOT ?>student_acc/' + data.image;
                $('#itemid').val(data.id);
                $('#fname').val(data.fname);
                $('#lname').val(data.lname);
                $('#email').val(data.email);
                $('#gender').val(data.gender);
                $('#phno').val(data.phno);
                $('#branch').val(data.branch);
                $('#year').val(data.year);
                $('#stu_img').attr('src', img);
                $('#exampleModal').modal('show');
            }
        });
    }
    function filterdeletestudentdetails(id) {
        var cnfrm = confirm('Are you sure!, You want to delete the record?');
        if (cnfrm) {
            var formdata = {'id': id, 'type': 'delete'};
            var url = '<?= ROOT ?>admin/ajax.php';
            $.ajax({
                type: 'POST',
                data: formdata,
                url: url,
                success: function (data) {
                    data = $.parseJSON(data);
                    if (data.success == 1) {
                        toastr.success(data.msg);
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    } else {
                        toastr.error(data.msg);
                        return false;
                    }
                }
            });
        }
    }
</script>
