<?php

function edit_student($id) {
    require 'connection.php';
    $query = "select * from student_register where id='" . $id . "'";
    $q = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($q);
    //print_r($row);
    return json_encode($row);
}

function delete_student($id) {
    require 'connection.php';
    $del = "update student_register set status=0 where id='" . $id . "';";
    $delquery = mysqli_query($conn, $del);
    $data = ($delquery) ? array('success' => 1, 'msg' => 'Student has been deleted successfully') : array('success' => 0, 'msg' => 'Something went wrong, try again later');
    return json_encode($data);
}

if ($_POST) {
    $id = $_POST['id'];
    $type = $_POST['type'];
    switch ($type) {
        case 'edit':
            $jdata = edit_student($id);
            echo $jdata;
            break;

        case 'delete':
            $jdata = delete_student($id);
            echo $jdata;
            break;

        default:
            break;
    }
}
?>        