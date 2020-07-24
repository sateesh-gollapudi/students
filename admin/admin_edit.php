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
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <form method="post" name="admin-edit" id="admin-edit">
                <div class="text-center">
                    <table class="table table-hover">
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
                            $query = "select * from student_register where status=1";
                            $q = mysqli_query($conn, $query);
                            if (mysqli_num_rows($q) > 0) {
                                while ($res = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
                                    $id = $res['id'];
                                    $fname = $res['fname'];
                                    $lname = $res['lname'];
                                    $email = $res['email'];
                                    $gender = $res['gender'];
                                    $phno = $res['phno'];
                                    $branch = $res['branch'];
                                    $year = $res['year'];
                                    $image = $res['image'];
                                    ?>                                                
                                    <tr>
                                        <td><?= $id; ?></td>
                                        <td><?= $fname; ?></td>
                                        <td><?= $lname; ?></td>
                                        <td><?= $email; ?></td>
                                        <td><?= $gender; ?></td>
                                        <td><?= $phno; ?></td>
                                        <td><?= $branch; ?></td>                                           
                                        <td><?= $year; ?></td>                                               
                                        <td>
                                            <i class="fas fa-user-edit mr-2 btn" onclick="getstudentdetails('<?= $id; ?>')"></i> 
                                            <i class="fas fa-trash text-danger btn" onclick="deletestudentdetails('<?= $id; ?>')"></i>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<script>tostar.error('No records found');</script>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </form>
            <!--Edit Modal Starts-->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="post" id="editing-details">
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
                                <button type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Edit Modal ends-->
<!--Delete modal-->
<div class="modal fade" id="exampleModal1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" name="delete">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="fas fa-trash text-danger"></i> Delete</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h3>Are you really want to delete data?</h3>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <input type="submit" class="btn btn-danger" name="submit" value="Yes"/>
                </div>
            </form>
        </div>
    </div>
</div>
<!--Delete modal ends-->   
<script>
    function getstudentdetails(id) {
        var formdata = {'id': id, 'type': 'edit'};
        var url = '<?= ROOT ?>admin/ajax.php';
        $.ajax({
            type: 'POST',
            data: formdata,
            url: url,
            success: function (data) {
                data = $.parseJSON(data);
                var img = '<?= ROOT ?>student_acc/' + data.image;
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
    function deletestudentdetails(id) {
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
