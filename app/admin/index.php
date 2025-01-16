<?php
session_start();

if(!isset($_SESSION['id_user'])){ ?>
<script>
alert("!!!! Maaf Anda Harus Login Dulu.")
window.location.assign('../');
</script>
<?php } 

$alertMessage = '';
$alertClass = 'alert-danger'; // Default alert class for errors
if (isset($_GET['pesan'])) {
    switch ($_GET['pesan']) {
        case 'unauthorized':
            $alertMessage = 'You are not an admin, cannot reset the course.';
            break;
        case 'berhasil':
            $alertMessage = 'Login successful! You are logged in as admin.';
            $alertClass = 'alert-success'; // Change alert class to success for registration
            break;
        case 'reset_success':
            $alertMessage = 'Reset course successful!';
            $alertClass = 'alert-success'; // Change alert class to success for registration
            break;
        default:
            $alertMessage = '';
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon.png">
    <title>Epresent - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                </div>
                <div class="sidebar-brand-text mx-3">Epresent</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Data Kelas -->
            <li class="nav-item">
                <a class="nav-link" href="kelas">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Class Data</span></a>
            </li>

            <!-- Nav Item - Data Guru -->
            <li class="nav-item">
                <a class="nav-link" href="guru">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Teacher Data</span></a>
            </li>

            <!-- Nav Item - Data Murid -->
            <li class="nav-item">
                <a class="nav-link" href="murid">
                    <i class="fas fa-fw fa-folder"></i>
                    <span>Student Data</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Logout -->
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar -->
                    <div class="sidebar-brand-text mx-3">Epresent</div>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-4 text-gray-800">Dashboard</h1>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Guru Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Teacher</div>
                                            <?php 
                                                include '../../koneksi.php';
                                                $query = "SELECT COUNT(*) as total FROM user WHERE level = 'Guru'";
                                                $result = mysqli_query($con, $query);
                                                $row = mysqli_fetch_assoc($result);
                                                ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $row['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Murid Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Student</div>
                                            <?php 
                                                include '../../koneksi.php';
                                                $query = "SELECT COUNT(*) as total FROM user WHERE level = 'Murid   '";
                                                $result = mysqli_query($con, $query);
                                                $row = mysqli_fetch_assoc($result);
                                                ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $row['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Kelas Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Class</div>
                                            <?php 
                                                include '../../koneksi.php';
                                                $query = "SELECT COUNT(*) as total FROM kelas";
                                                $result = mysqli_query($con, $query);
                                                $row = mysqli_fetch_assoc($result);
                                                ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $row['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Course Card -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Course
                                            </div>
                                            <?php
                                            include '../../koneksi.php';
                                            $query = "SELECT COUNT(*) as total FROM course";
                                            $result = mysqli_query($con, $query);
                                            $row = mysqli_fetch_assoc($result);
                                            ?>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                <?php echo $row['total']; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <!-- Reset Button -->
                                            <button class="btn btn-danger btn-sm" href="#" data-toggle="modal"
                                                data-target="#resetModal">Reset</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content Row -->


                    <!-- Default Card Example -->
                    <div class="card mb-4">
                        <!-- Alert Message within the container -->
                        <?php if ($alertMessage): ?>
                        <div class="alert <?php echo $alertClass; ?>" id="alertMessage">
                            <?php echo $alertMessage; ?>
                            <span class="close-btn" onclick="closeAlert()">×</span>
                        </div>
                        <?php endif; ?>
                        <div class="card-body">
                            Welcome Admin!!
                        </div>
                    </div>

                    <!-- Guide Section -->
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5>Guide Admin</h5>
                            <hr>
                            <!-- Reset All Course -->
                            <details>
                                <summary><b>1. Reset All Course</b></summary>
                                <img src="../../assets/img/admin/admin1.png" width="100%" alt="Student Learning">
                                <p style="margin-left: 25px;">a. Click the reset button on the dashboard (1)</p>
                                <p style="margin-left: 25px;">b. And then click delete</p>
                            </details>
                            <hr>
                            <!-- Manage Class Data -->
                            <details>
                                <summary><b>2. Manage Data Class</b></summary>
                                <img src="../../assets/img/admin/admin2.png" width="100%" alt="Class Management">
                                <p style="margin-left: 25px;">a. To add class data click add class (1)</p>
                                <p style="margin-left: 25px;">b. To edit class data first click the name you want to
                                    change and then click edit (2)</p>
                                <p style="margin-left: 25px;">c. To delete class data first click the name you want to
                                    delete and then click delete (3)</p>
                            </details>
                            <hr>
                            <!-- Manage Teacher Data -->
                            <details>
                                <summary><b>3. Manage Data Teacher</b></summary>
                                <img src="../../assets/img/admin/admin3.png" width="100%" alt="Teacher Management">
                                <p style="margin-left: 25px;">a. To add teacher data click add teacher (1)</p>
                                <p style="margin-left: 25px;">b. To edit teacher data first click the name you want to
                                    change and then click edit (2)</p>
                                <p style="margin-left: 25px;">c. To delete teacher data first click the name you want to
                                    delete and then click delete (3)</p>
                            </details>
                            <hr>
                            <!-- Manage Student Data -->
                            <details>
                                <summary><b>4. Manage Data Student</b></summary>
                                <img src="../../assets/img/admin/admin4.png" width="100%" alt="Student Management">
                                <p style="margin-left: 25px;">a. To add student data click add student (1)</p>
                                <p style="margin-left: 25px;">b. To edit student data first click the name you want to
                                    change and then click edit (2)</p>
                                <p style="margin-left: 25px;">c. To delete student data first click the name you want to
                                    delete and then click delete (3)</p>
                            </details>
                        </div>
                    </div>

                    <!-- Delete Modal -->
                    <div class="modal fade" id="resetModal" tabindex="-1" role="dialog"
                        aria-labelledby="deleteModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form action="action/Reset.php" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel">Reset Course
                                        </h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure you want to delete all course or reset them?
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Logout Modal -->
                    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog"
                        aria-labelledby="logoutModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to log out?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <!-- Redirect to logout action -->
                                    <a href="logout.php" class="btn btn-danger">Logout</a>
                                </div>
                            </div>
                        </div>
                    </div>



                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Epresent</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="../../assets/js/sb-admin-2.min.js"></script>
    <script>
    // Close alert when close button is clicked
    function closeAlert() {
        document.getElementById("alertMessage").style.display = "none";
    }
    </script>

</body>

</html>