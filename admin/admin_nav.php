<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Student Login</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="<?= ROOT ?>admin/adminhome.php">Home <span class="sr-only">(current)</span></a>
            </li>      
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    More
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="admin_edit.php">Edit details</a>
                    <a class="dropdown-item" href="filter.php">Filter students</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
            </li>
        </ul>
        <form class="form-inline my-2 my-lg-0">
            <input class="form-control mr-sm-2" type="search" name="term" placeholder="Search" aria-label="Search">
            <!--            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="filter">Search</button>-->
        </form>
    </div>
</nav>
<?php
if (!empty($_REQUEST['term'])) {

    $term = mysqli_real_escape_string($conn, $_REQUEST['term']);
    $sql = "SELECT * FROM student_register WHERE fname OR branch LIKE '%" . $term . "%'";
    $r_query = mysqli_query($conn, $sql);
    if ($r_query) {
        while ($row = mysqli_fetch_array($r_query)) {
            echo 'Primary key: ' . $row['id'];
            echo '<br /> Code: ' . $row['fname'];
            echo '<br /> Description: ' . $row['lname'];
            echo '<br /> Category: ' . $row['email'];
            echo '<br /> Cut Size: ' . $row['phno'];
        }
    }else{
        die('Query not executed');
    }
}
?>