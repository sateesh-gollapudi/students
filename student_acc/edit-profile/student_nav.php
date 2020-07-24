<?php
require_once 'header.php';
// Auto logout in inactive state
// $inactive = 10;
// if (!isset($_SESSION['timeout']))
//     $_SESSION['timeout'] = time() + $inactive;
// $session_life = time() - $_SESSION['timeout'];
// if ($session_life > $inactive) {
//     session_destroy();
//     header("Location:login.php");
// }
// $_SESSION['timeout'] = time();
// Auto logout code ends
$uid = $_SESSION['id'];
$q = "select * from student_register where id = '" . $uid . "'";
$recs = mysqli_query($conn, $q);
$rec = mysqli_fetch_array($recs, MYSQLI_ASSOC);
?>
<style>
    /*    .dropdown:hover>.dropdown-menu {
            display: block;
        }*/
    .dropdown-header {
        display: block;
        padding: .5rem 3rem;
        margin-bottom: 0;
        font-size: .875rem;
        color: #6c757d;
        white-space: nowrap;
    }
</style>
<!-- Navbar -->
<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
        <a href="<?= ROOT ?>student_acc/studenthome.php" class="navbar-brand">
            <img src="<?= ROOT ?>student_acc/images/school.png" alt="Student Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light"><?php echo $rec['fname']; ?></span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <!--          <li class="nav-item">
                            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                          </li>-->
                <li class="nav-item">
                    <a href="<?= ROOT ?>student_acc/studenthome.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">More</a>
                    <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                        <li><a href="<?= ROOT ?>student_acc/edit-profile/edit_profile.php" class="dropdown-item">Edit profile </a></li>
                        <li><a href="#" class="dropdown-item">Some other action</a></li>

                        <li class="dropdown-divider"></li>

                        <!-- Level two dropdown-->
                        <li class="dropdown-submenu dropdown-hover">
                            <a id="dropdownSubMenu2" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">Hover for action</a>
                            <ul aria-labelledby="dropdownSubMenu2" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a tabindex="-1" href="#" class="dropdown-item">level 2</a>
                                </li>

                                <!-- Level three dropdown-->
                                <li class="dropdown-submenu">
                                    <a id="dropdownSubMenu3" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-item dropdown-toggle">level 2</a>
                                    <ul aria-labelledby="dropdownSubMenu3" class="dropdown-menu border-0 shadow">
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                        <li><a href="#" class="dropdown-item">3rd level</a></li>
                                    </ul>
                                </li>
                                <!-- End Level three -->

                                <li><a href="#" class="dropdown-item">level 2</a></li>
                                <li><a href="#" class="dropdown-item">level 2</a></li>
                            </ul>
                        </li>
                        <!-- End Level two -->
                    </ul>
                </li>
            </ul>

            <!-- SEARCH FORM -->
            <form class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                    <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-navbar" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
            <!-- Messages Dropdown Menu -->
            <!--            <li class="nav-item dropdown">
                            <a class="nav-link" data-toggle="dropdown" href="#">
                                <i class="fas fa-comments"></i>
                                <span class="badge badge-danger navbar-badge">3</span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                <a href="#" class="dropdown-item">
                                     Message Start 
                                    <div class="media">
                                        <img src="/images/school.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title">
                                                Brad Diesel
                                                <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                                            </h3>
                                            <p class="text-sm">Call me whenever you can...</p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                        </div>
                                    </div>
                                     Message End 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                     Message Start 
                                    <div class="media">
                                        <img src="/images/school.png" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title">
                                                John Pierce
                                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                                            </h3>
                                            <p class="text-sm">I got your message bro</p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                        </div>
                                    </div>
                                     Message End 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item">
                                     Message Start 
                                    <div class="media">
                                        <img src="../../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
                                        <div class="media-body">
                                            <h3 class="dropdown-item-title">
                                                Nora Silvester
                                                <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                                            </h3>
                                            <p class="text-sm">The subject goes here</p>
                                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                                        </div>
                                    </div>
                                     Message End 
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                            </div>
                        </li>-->
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <!--Menu-->
            <li class="nav-item dropdown pl-3">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-header">
                        <?php
                        $mail = $_SESSION['email'];
                        $re = mysqli_query($conn, "select image from student_register where email='" . $mail . "';");
                        while ($row = mysqli_fetch_array($re)) {
                            $url = ROOT . 'student_acc/';
                            ?>
                            <a class="nav-link" name='viewProfile' href="<?= ROOT ?>student_acc/studenthome.php?viewProfile=true" data-widget="control-sidebar" data-slide="true" role="button"><?php echo $_SESSION['name']; ?><img src="<?= $url . $row['image']; ?>" class="ml-1 img-thumbnail rounded-circle" width="60" height="60" /></a>
                        <?php } ?>
                    </span>
                    <span class="dropdown-header bg-warning">
                        <a class="nav-link" name='changePwd' href="<?= ROOT ?>student_acc/changepassword.php" data-widget="control-sidebar" data-slide="true" role="button">Change Password</a>
                    </span>
                    <span class="dropdown-header bg-danger font-weight-bold">
                        <a class="nav-link" name='deleteAccount' style="color: #fff" href="<?= ROOT ?>student_acc/delete.php" data-widget="control-sidebar" data-slide="true" role="button">Delete Account</a>
                    </span>
                    <div class="dropdown-divider"></div>
                    <a href="<?= ROOT ?>student_acc/logout.php" class="dropdown-item">
                        <i class="fas fa-sign-out-alt"></i> Logout
                        <!--                        <span class="float-right text-muted text-sm">3 mins</span>-->
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- /.navbar -->