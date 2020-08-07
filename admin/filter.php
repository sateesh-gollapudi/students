<?php
session_start();
require_once 'connection.php';
require_once 'header.php';
require_once 'admin_nav.php';
if (empty($_SESSION["is_logged_in"])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
$branch_name = '';
if (isset($_POST['bran']) && $_POST['bran']) {
    $branch_name = $_POST['bran'];
}
$year_value = '';
if (isset($_POST['year']) && $_POST['year']) {
    $year_value = $_POST['year'];
}
$cbranch_name = '';
if (isset($_POST['cbran']) && $_POST['cbran']) {
    $cbranch_name = $_POST['cbran'];
}
$cyear_value = '';
if (isset($_POST['cyear']) && $_POST['cyear']) {
    $cyear_value = $_POST['cyear'];
}
//if (isset($_SESSION['msg'])) {
//    echo '<script>toastr.warning("No records found!");</script>';
//    unset($_SESSION['login']);
//}
?>
<div class="container-fluid">    
    <div class="row">
        <div class="col-lg-3">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <form class="input-group my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" name="term" placeholder="Enter Name and hit enter" aria-label="Search">
                        <a href="<?php ROOT . 'admin/filer.php' ?>" class="btn btn-outline-warning">Clear</a>
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
                        <input class="form-control mr-sm-2" type="search" name="mail" placeholder="Enter Email and hit enter" aria-label="Search">                        
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <form method="post" name="filter-year" id="sel">
                        <div class="input-group">
                            <select class="form-control mr-2" name="year" id="select">
                                <option value="">Select Year</option>
                                <option value="1" <?= ($year_value == '1') ? 'selected' : '' ?>>1</option>
                                <option value="2" <?= ($year_value == '2') ? 'selected' : '' ?>>2</option>
                                <option value="3" <?= ($year_value == '3') ? 'selected' : '' ?>>3</option>
                                <option value="4" <?= ($year_value == '4') ? 'selected' : '' ?>>4</option>                                
                            </select>
                            <input type="submit" name="yearfilter" id="year" class="btn btn-outline-success" value="Filter" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
        <!--********************************To filter branch and year combined***********************************************-->
        <div class="col-lg-6">
            <div class="card" style="border: none;">
                <div class="card-body">
                    <h3 class="text-center">For combined results</h3>
                    <form method="post" name="filter-branch" id="csel">
                        <div class="input-group">
                            <select class="form-control mr-2" name="cbran" id="cbran">
                                <option value="">Select Branch</option>
                                <option value="cse" <?= ($cbranch_name == 'cse') ? 'selected' : '' ?>>CSE</option>
                                <option value="ece" <?= ($cbranch_name == 'ece') ? 'selected' : '' ?>>ECE</option>
                                <option value="civil" <?= ($cbranch_name == 'civil') ? 'selected' : '' ?>>CIVIL</option>
                                <option value="mech" <?= ($cbranch_name == 'mech') ? 'selected' : '' ?>>MECHANICAL</option>
                                <option value="eee" <?= ($cbranch_name == 'eee') ? 'selected' : '' ?>>EEE</option>
                            </select>
                            <select class="form-control mr-2" name="cyear" id="cyear">
                                <option value="">Select Year</option>
                                <option value="1" <?= ($cyear_value == '1') ? 'selected' : '' ?>>1</option>
                                <option value="2" <?= ($cyear_value == '2') ? 'selected' : '' ?>>2</option>
                                <option value="3" <?= ($cyear_value == '3') ? 'selected' : '' ?>>3</option>
                                <option value="4" <?= ($cyear_value == '4') ? 'selected' : '' ?>>4</option>                                
                            </select>
                            <input type="submit" name="cfilter" id="cfilter" class="btn btn-outline-success" value="Filter" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-3"></div>
    </div>
</div>
<div class="container-fluid">
    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-warning d-none" id="error">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?php echo $_SESSION['msg']; ?>
        </div>
    <?php endif; ?>
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
            <!--*******************************************Filter by Branch***************************************************-->
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
                    $_SESSION['msg'] = "No records found!";
                    echo '<script> '
                    . '$("document").ready(function(){'
                    . '$("#error").removeClass("d-none");'
                    . '}); </script>';
                }
            }
            ?>
            <!--//******************************Filter by name*****************************************************-->
            <?php
            if (!empty($_REQUEST['term'])) {
                $term = mysqli_real_escape_string($conn, $_REQUEST['term']);
                $sql = "SELECT * FROM student_register WHERE fname OR lname LIKE '%" . $term . "%'";
                $r_query = mysqli_query($conn, $sql);
                if (mysqli_num_rows($r_query) > 0) {
                    while ($row = mysqli_fetch_array($r_query)) {
                        $n_id = $row['id'];
                        $n_fname = $row['fname'];
                        $n_lname = $row['lname'];
                        $n_email = $row['email'];
                        $n_gender = $row['gender'];
                        $n_phno = $row['phno'];
                        $n_branch = $row['branch'];
                        $n_year = $row['year'];
//                                                    $b_image = $b['image'];
                        ?>
                        <tr>
                            <td><?= $n_id; ?></td>
                            <td><?= $n_fname; ?></td>
                            <td><?= $n_lname; ?></td>
                            <td><?= $n_email; ?></td>
                            <td><?= $n_gender; ?></td>
                            <td><?= $n_phno; ?></td>
                            <td><?= $n_branch; ?></td>                                           
                            <td><?= $n_year; ?></td>                                               
                            <td>
                                <i class="fas fa-user-edit mr-2 btn" onclick="filterstudentdetails('<?= $n_id; ?>')"></i> 
                                <i class="fas fa-trash text-danger btn" onclick="filterdeletestudentdetails('<?= $n_id; ?>')"></i>
                            </td>
                        </tr> 
                        <?php
                    }
                } else {
                    $_SESSION['msg'] = 'No records found!';
                    echo '<script> '
                    . '$("document").ready(function(){'
                    . '$("#error").removeClass("d-none");'
                    . '}); </script>';
                }
            }
            ?>
            <!--//******************************Filter by email*****************************************************-->
            <?php
            if (!empty($_REQUEST['mail'])) {
                $term = mysqli_real_escape_string($conn, $_REQUEST['mail']);
                $sql = "SELECT * FROM student_register WHERE email LIKE '%" . $term . "%'";
                $r_query = mysqli_query($conn, $sql);
                if (mysqli_num_rows($r_query) > 0) {
                    while ($row = mysqli_fetch_array($r_query)) {
                        $n_id = $row['id'];
                        $n_fname = $row['fname'];
                        $n_lname = $row['lname'];
                        $n_email = $row['email'];
                        $n_gender = $row['gender'];
                        $n_phno = $row['phno'];
                        $n_branch = $row['branch'];
                        $n_year = $row['year'];
//                                                    $b_image = $b['image'];
                        ?>
                        <tr>
                            <td><?= $n_id; ?></td>
                            <td><?= $n_fname; ?></td>
                            <td><?= $n_lname; ?></td>
                            <td><?= $n_email; ?></td>
                            <td><?= $n_gender; ?></td>
                            <td><?= $n_phno; ?></td>
                            <td><?= $n_branch; ?></td>                                           
                            <td><?= $n_year; ?></td>                                               
                            <td>
                                <i class="fas fa-user-edit mr-2 btn" onclick="filterstudentdetails('<?= $n_id; ?>')"></i> 
                                <i class="fas fa-trash text-danger btn" onclick="filterdeletestudentdetails('<?= $n_id; ?>')"></i>
                            </td>
                        </tr> 
                        <?php
                    }
                } else {
                    $_SESSION['msg'] = 'No records found!';
                    echo '<script> '
                    . '$("document").ready(function(){'
                    . '$("#error").removeClass("d-none");'
                    . '}); </script>';
                }
            }
            ?>
            <!--********************************************Filter by Year*****************************************************-->
            <?php
            if (isset($_POST['year'])) {
                $year = $_POST['year'];
                $filter_year = "select * from student_register where year='" . $year . "'and status=1;";
                $filter_y = mysqli_query($conn, $filter_year);
//                    echo 'Entered first if'; exit;
                if (mysqli_num_rows($filter_y) > 0) {
                    while ($y = mysqli_fetch_array($filter_y, MYSQLI_ASSOC)) {
                        $y_id = $y['id'];
                        $y_fname = $y['fname'];
                        $y_lname = $y['lname'];
                        $y_email = $y['email'];
                        $y_gender = $y['gender'];
                        $y_phno = $y['phno'];
                        $y_branch = $y['branch'];
                        $y_year = $y['year'];
//                                                    $b_image = $b['image'];
                        ?>
                        <tr>
                            <td><?= $y_id; ?></td>
                            <td><?= $y_fname; ?></td>
                            <td><?= $y_lname; ?></td>
                            <td><?= $y_email; ?></td>
                            <td><?= $y_gender; ?></td>
                            <td><?= $y_phno; ?></td>
                            <td><?= $y_branch; ?></td>                                           
                            <td><?= $y_year; ?></td>                                               
                            <td>
                                <i class="fas fa-user-edit mr-2 btn" onclick="filterstudentdetails('<?= $y_id; ?>')"></i> 
                                <i class="fas fa-trash text-danger btn" onclick="filterdeletestudentdetails('<?= $y_id; ?>')"></i>
                            </td>
                        </tr> 
                        <?php
                    }
                } else {
                    $_SESSION['msg'] = "No records found!";
                    echo '<script> '
                    . '$("document").ready(function(){'
                    . '$("#error").removeClass("d-none");'
                    . '}); </script>';
                }
            }
            ?>
            <!--*******************************************************Combined Filter************************************************-->
            <?php
            if (isset($_POST['cfilter'])) {
                $cb = $_POST['cbran'];
                $cy = $_POST['cyear'];
                $cs = "select * from student_register where branch='" . $cb . "'and year='" . $cy . "'and status=1";
                $csq = mysqli_query($conn, $cs);
                if ($csq) {
                    if (mysqli_num_rows($csq) != 0) {
                        while ($cf = mysqli_fetch_array($csq, MYSQLI_ASSOC)) {
                            $cf_id = $cf['id'];
                            $cf_fname = $cf['fname'];
                            $cf_lname = $cf['lname'];
                            $cf_email = $cf['email'];
                            $cf_gender = $cf['gender'];
                            $cf_phno = $cf['phno'];
                            $cf_branch = $cf['branch'];
                            $cf_year = $cf['year'];
//                                                    $b_image = $b['image'];
                            ?>
                            <tr>
                                <td><?= $cf_id; ?></td>
                                <td><?= $cf_fname; ?></td>
                                <td><?= $cf_lname; ?></td>
                                <td><?= $cf_email; ?></td>
                                <td><?= $cf_gender; ?></td>
                                <td><?= $cf_phno; ?></td>
                                <td><?= $cf_branch; ?></td>                                           
                                <td><?= $cf_year; ?></td>                                               
                                <td>
                                    <i class="fas fa-user-edit mr-2 btn" onclick="filterstudentdetails('<?= $cf_id; ?>')"></i> 
                                    <i class="fas fa-trash text-danger btn" onclick="filterdeletestudentdetails('<?= $cf_id; ?>')"></i>
                                </td>
                            </tr> 
                            <?php
                        }
                    }
                } else {
                    $_SESSION['msg'] = "No records found!";
                    echo '<script> '
                    . '$("document").ready(function(){'
                    . '$("#error").removeClass("d-none");'
                    . '}); </script>';
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
        $('#csel').first().submit(function () {
            let cbran = $('#cbran').val();
            let cyear = $('#cyear').val();
            if (cbran == '') {
                toastr.error('Select Branch');
                $('#cbran').focus();
                return false;
            }
            if (cyear == '') {
                toastr.error('Select Year');
                $('#cyear').focus();
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
