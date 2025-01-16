<?php
session_start();

if (!isset($_SESSION['id_user'])) { ?>
<script>
alert("!!!! Maaf Anda Harus Login Dulu.");
window.location.assign('../');
</script>
<?php }

include '../../koneksi.php';

// Get the selected task from URL
$selectedTask = $_GET['id_tugas'] ?? null;

if ($selectedTask === null) {
    echo "Task not found.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon.png">
    <title>Epresent - Teacher</title>
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
        z-index: 10;
    }

    .nav-links a {
        text-decoration: none;
        font-weight: bold;
    }

    .logout {
        color: red;
    }

    .container {
        max-width: 960px;
        margin: 20px auto;
        padding: 20px;
    }

    .card {
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 20px;
    }

    .card-header {
        font-weight: bold;
        font-size: 1.2rem;
        margin-bottom: 15px;
        color: #007bff;
    }

    .material-item {
        display: flex;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .material-item:last-child {
        border-bottom: none;
    }

    .icon {
        font-size: 1.5rem;
        margin-right: 15px;
        color: #6c757d;
    }

    .material-title {
        font-weight: bold;
        color: #333;
    }

    .material-description {
        font-size: 0.9rem;
        color: #666;
        margin-left: 42px;
        margin-bottom: 8px;
    }

    .status {
        margin-left: auto;
        font-size: 0.85rem;
        color: green;
        font-weight: bold;
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
                <a href="kelas">Course</a>
                <a href="#" data-toggle="modal" data-target="#editProfileModal">Profile</a>
                <a href="#" class="logout" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </div>
    </header>
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
                            <label>Teacher Name</label>
                            <input type="text" class="form-control" name="nama" value="<?php echo $_SESSION['nama']; ?>"
                                placeholder="Masukkan Nama Guru" required>
                        </div>
                        <div class="form-group">
                            <label>Teacher Email</label>
                            <input type="text" class="form-control" name="email"
                                value="<?php echo $_SESSION['email']; ?>" placeholder="Masukkan Email" required>
                        </div>
                        <div class="form-group">
                            <label>Teacher Password</label>
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

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Assignment</h1>
        </div>

        <?php
        // Query the task details for the selected task
        $queryTask = "SELECT t.id_tugas, t.id_course, c.judul AS course_title
                    FROM tugas t
                    JOIN course c ON t.id_course = c.id_course
                    WHERE t.id_course = '$selectedTask'";
        $resultTask = mysqli_query($con, $queryTask);

        if ($resultTask && mysqli_num_rows($resultTask) > 0) {
            $task = mysqli_fetch_assoc($resultTask);
            $taskName = $task['course_title']; // Assuming this is the name, you can adjust based on your database structure
        } else {
            echo "No one has submitted the assignment yet.";
            exit;
        }

        ?>

        <div class="card">
            <div class="card-header">
                Assignment: <?php echo $taskName; ?>
            </div>
            <div class="card-body">
                <?php
                $queryAssignments = "SELECT t.id_tugas, t.id_course, u.nama, t.link, t.grade, t.date_created
                                    FROM tugas t
                                    JOIN user u ON t.id_user = u.id_user
                                    WHERE id_course = '$selectedTask'";
                $resultAssignments = mysqli_query($con, $queryAssignments);

                if ($resultAssignments && mysqli_num_rows($resultAssignments) > 0) {
                    while ($assignment = mysqli_fetch_assoc($resultAssignments)) {
                        $studentName = $assignment['nama']; 
                        $dateCreated = $assignment['date_created']; 
                        $videoLink = $assignment['link']; 
                ?>
                <div class="material-item">
                    <i class="icon"></i>
                    <div>
                        <div class="material-title">
                            <a href="detail_tugas.php?id_tugas=<?php echo $assignment['id_tugas']; ?>">
                                <?php echo "Student Name: $studentName"; ?>
                            </a>
                        </div>
                        <div class="material-description">
                            <?php echo "Uploaded on: " . date('F j, Y', strtotime($dateCreated)); ?>
                        </div>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "No assignments found for this task.";
                }
                ?>
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

</body>

</html>