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
        case 'berhasil':
            $alertMessage = 'Login successful! You are logged in as student.';
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon.png">
    <title>Epresent - Student</title>
    <!-- Custom fonts for this template-->
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="../../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <style>
    /* Main Styling */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }

    header {
        background-color: #fff;
        padding: 15px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .logo {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
    }

    .user-info {
        display: flex;
        align-items: center;
    }

    .username {
        margin-right: 15px;
        color: #333;
    }

    .nav-links {
        display: flex;
        gap: 15px;
    }

    .nav-links a {
        text-decoration: none;
        font-weight: bold;
    }

    .logout {
        color: red;
    }

    /* Welcome Card Styling */
    .container {
        max-width: 960px;
        margin: 20px auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .welcome-card {
        font-size: 1.5rem;
        font-weight: bold;
        margin-bottom: 20px;
        color: black;
    }

    /* User Details Styling */
    .user-details {
        margin-top: 20px;
        color: #333;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        .nav-links {
            display: none;
            flex-direction: column;
            position: absolute;
            top: 50px;
            right: 10px;
            background-color: white;
            padding: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            border-radius: 5px;
        }

        .show-nav {
            display: flex;
        }

        .menu-icon {
            display: inline-block;
            font-size: 1.5rem;
            cursor: pointer;
        }
    }

    @media (min-width: 769px){
        .menu-icon {
            display: none;
        }
    }
    </style>
</head>

<body>
    <header>
        <div class="logo">
            <img src="../../assets/img/logo.png" alt="e-Present" style="width: 150px; height:35px;">
        </div>
        <div class="user-info">
            <div class="username">Hi, <?php echo $_SESSION['email']; ?></div>
            <div class="menu-icon" onclick="toggleMenu()">
                <i class="fas fa-ellipsis-v"></i>
            </div>
            <div class="nav-links" id="navLinks">
                <a href="home">Home</a>
                <a href="course">Course</a>
                <a href="#" data-toggle="modal" data-target="#editProfileModal">Profile</a>
                <a href="#" class="logout" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </div>
    </header>

    <div class="container">
        <!-- Welcome Card -->
        <!-- Alert Message within the container -->
        <?php if ($alertMessage): ?>
        <div class="alert <?php echo $alertClass; ?>" id="alertMessage">
            <?php echo $alertMessage; ?>
            <span class="close-btn" onclick="closeAlert()">×</span>
        </div>
        <?php endif; ?>
        <div class="welcome-card">
            Welcome! You are logged in as student.
        </div>

        <!-- User Details -->
        <div class="user-details">
            <p><strong>Name:</strong> <?php echo $_SESSION['nama']; ?></p>
            <p><strong>Class:</strong> <?php echo $_SESSION['kelas']; ?></p>
            <!-- Add more user info if available in session -->
        </div>
    </div>

    <!-- Guide Section -->
    <div class="container">
            <h5>Guide Student</h5>
            <hr>
            <!-- View Course -->
            <details>
                <summary><b>1. View Course</b></summary>
                <img src="../../assets/img/murid/murid1.1.png" width="100%" alt="Student Learning">
                <p style="margin-left: 25px;">a. Click on the navbar course</p>
            </details>
            <hr>
            <!-- View Assignment -->
            <details>
                <summary><b>2. Submit Assignment</b></summary>
                <img src="../../assets/img/murid/murid1.png" width="100%" alt="Class Management">
                <p style="margin-left: 25px;">a. Click on the navbar course</p>
                <p style="margin-left: 25px;">b. Select a class</p>
                <p style="margin-left: 25px;">c. Click the assignment you want to work on (1)</p>
                <img src="../../assets/img/murid/murid2.png" width="100%" alt="Class Management">
                <p style="margin-left: 25px;">d. Click the start recording button (1)</p>
                <img src="../../assets/img/murid/murid3.png" width="100%" alt="Class Management">
                <p style="margin-left: 25px;">e. Click the retry recording button if you want to repeat the video recording (1)</p>
                <p style="margin-left: 25px;">f. Click the upload recording button if you sure to upload the assignment (2)</p>
                <img src="../../assets/img/murid/murid4.png" width="100%" alt="Class Management">
                <p style="margin-left: 25px;">g. Click the remove video button if you want to delete the assignment (1)</p>
            </details>
            <hr>
            <!-- View Assignment, Add Grade And Comment -->
            <details>
                <summary><b>3. View Grade And Comment</b></summary>
                <img src="../../assets/img/murid/murid5.png" width="100%" alt="Teacher Management">
                <p style="margin-left: 25px;">a. Click on the navbar course</p>
                <p style="margin-left: 25px;">b. Select a class</p>
                <p style="margin-left: 25px;">c. Select the assignment you want to view</p>
                <p style="margin-left: 25px;">d. If you want to upload a comment write the comment first (1)</p>
                <p style="margin-left: 25px;">e. And than click submit a comment (2)</p>
            </details>
            <hr>
        </div>

    <?php 
    include "../../koneksi.php";
    $id_user = $_SESSION['id_user'];
    $userQuery = "SELECT * FROM user WHERE id_user = '$id_user'";
    $userResult = mysqli_query($con, $userQuery);
    $userData = mysqli_fetch_assoc($userResult);
    ?>

    <!-- Edit Profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form action="action/Profile.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Profile</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">

                        <div class="form-group">
                            <label>Student Name</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo $_SESSION['nama']; ?>"
                                required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Class</label>
                            <select name="kelas" class="form-control" required>
                                <option selected>----- Select a Class -----</option>
                                <?php
                                $kelasQuery = "SELECT * FROM kelas";
                                $kelasResult = mysqli_query($con, $kelasQuery);

                                while ($kelasRow = mysqli_fetch_assoc($kelasResult)){
                                    $selected = ($kelasRow['nama'] == $userData['kelas']) ? 'selected' : '';
                                    echo "<option value='{$kelasRow['nama']}' {$selected}>{$kelasRow['nama']}</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Student Email</label>
                            <input type="text" class="form-control" name="email"
                                value="<?php echo $_SESSION['email']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label>Student Password</label>
                            <input type="text" class="form-control" name="password" value=""
                                placeholder="Not required if you do not want to be replaced">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Logout Modal -->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
        aria-hidden="true">
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

    <!-- JavaScript to toggle the menu -->
    <script>
    function toggleMenu() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('show-nav');
    }
    </script>

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
    // Close alert when close button is clicked
    function closeAlert() {
        document.getElementById("alertMessage").style.display = "none";
    }
    </script>
</body>

</html>