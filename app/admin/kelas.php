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
        case 'tambah':
            $alertMessage = 'Add class successfully.';
            $alertClass = 'alert-success'; // Change alert class to success for registration
            break;
        case 'edit':
            $alertMessage = 'Edit class successfully.';
            $alertClass = 'alert-success'; // Change alert class to success for registration
            break;
        case 'hapus':
            $alertMessage = 'Delete class successfully.';
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

    <!-- Custom styles for this page -->
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">


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
            <li class="nav-item">
                <a class="nav-link" href="dashboard">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Data Kelas -->
            <li class="nav-item active">
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
                    <h1 class="h3 mb-2 text-gray-800">Class Data</h1>
                    <p class="mb-4">Can add, edit, and delete classes.</p>

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Class Data Table</h6>
                            <button class="btn btn-primary btn-sm float-right" data-toggle="modal"
                                data-target="#addModal">Add Class</button>
                        </div>
                        <!-- Alert Message within the container -->
                        <?php if ($alertMessage): ?>
                        <div class="alert <?php echo $alertClass; ?>" id="alertMessage">
                            <?php echo $alertMessage; ?>
                            <span class="close-btn" onclick="closeAlert()">×</span>
                        </div>
                        <?php endif; ?>

                        <div class="modal fade" id="addModal" tabindex="-1" role="dialog"
                            aria-labelledby="addModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="action/Kelas.php?act=tambah" method="POST">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="addModalLabel">Add a new class</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Class Name</label>
                                                <input type="text" class="form-control" name="nama"
                                                    placeholder="Enter the class name" required>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Add Class</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Class name</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                            $no = 1;
                                            include '../../koneksi.php';
                                            $sql = "SELECT * FROM kelas GROUP BY id_kelas DESC"; 
                                            $query = mysqli_query($con, $sql); 
                                            $jumlah_data = mysqli_num_rows($query);
                                            if ($jumlah_data > 0) {
                                                $i = 1;
                                                while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td style="position:relative;">
                                                <a href="#"
                                                    onclick="event.preventDefault(); toggleDropdown(<?php echo $data['id_kelas']; ?>)"
                                                    id="className<?php echo $data['id_kelas']; ?>">
                                                    <?php echo $data['nama']; ?>
                                                </a>
                                                <div class="dropdown-menu" id="dropdown<?php echo $data['id_kelas']; ?>"
                                                    aria-labelledby="className<?php echo $data['id_kelas']; ?>"
                                                    style="display: none; position: absolute;">
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#editModal<?php echo $data['id_kelas']; ?>">Edit</a>
                                                    <a class="dropdown-item" href="#" data-toggle="modal"
                                                        data-target="#deleteModal<?php echo $data['id_kelas']; ?>">Delete</a>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editModal<?php echo $data['id_kelas']; ?>"
                                            tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="action/Kelas.php?act=edit" method="POST">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel">Edit Class</h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_kelas"
                                                                value="<?php echo $data['id_kelas']; ?>">
                                                            <div class="form-group">
                                                                <label>Class Name</label>
                                                                <input type="text" class="form-control" name="nama"
                                                                    value="<?php echo $data['nama']; ?>"
                                                                    placeholder="Enter the class name" required>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save
                                                                changes</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="deleteModal<?php echo $data['id_kelas']; ?>"
                                            tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form
                                                        action="action/Kelas.php?act=hapus&id=<?php echo $data['id_kelas']; ?>"
                                                        method="POST">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteModalLabel">Delete Class
                                                            </h5>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <input type="hidden" name="id_kelas"
                                                                value="<?php echo $data['id_kelas']; ?>">
                                                            <p>Are you sure you want to delete this
                                                                <b>"<?php echo $data['nama']; ?>"</b> class?
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
                                        <?php $i++; } } ?>
                                    </tbody>

                                </table>
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

    <!-- Page level plugins -->
    <script src="../../assets/vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="../../assets/vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="../../assets/js/demo/datatables-demo.js"></script>

    <script>
    function toggleDropdown(id) {
        const dropdown = document.getElementById(`dropdown${id}`);
        dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';

        // Close other dropdowns if one is opened
        document.addEventListener('click', function(event) {
            if (!event.target.closest(`#className${id}`) && !event.target.closest(`#dropdown${id}`)) {
                dropdown.style.display = 'none';
            }
        });
    }
    </script>

    <script>
    // Close alert when close button is clicked
    function closeAlert() {
        document.getElementById("alertMessage").style.display = "none";
    }
    </script>

</body>

</html>