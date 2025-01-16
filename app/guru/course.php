<?php
session_start();

if (!isset($_SESSION['id_user'])) { ?>
<script>
alert("!!!! Maaf Anda Harus Login Dulu.");
window.location.assign('../');
</script>
<?php }

include '../../koneksi.php';

// Get the selected class from URL
$selectedClass = $_GET['id_kelas'] ?? null;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon.png">
    <title>Epresent - Teacher | <?php echo htmlspecialchars($selectedClass); ?> </title>
    <link href="../../assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="../../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <style>
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

    .hint {
        font-size: 0, 9rem;
        color: red;
        margin-top: 5px;
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

        /* Stack buttons vertically on smaller screens */
        .btn-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        /* Ensure the 'Course Class' heading is responsive */
        h1 {
            font-size: 1.5rem;
            word-wrap: break-word;
            /* Handle long class names */
            text-align: center;
        }

        /* Edit and Delete icons stack vertically */
        .status {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .status a {
            margin-bottom: 5px;
        }

        /* Adjust icon size */
        .icon {
            font-size: 1.2rem;
        }

        /* Adjust margins for smaller screens */
        .material-title {
            font-size: 1rem;
        }

        .material-description {
            font-size: 0.8rem;
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
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="btn-group float-right">
                <button class="btn btn-primary add-course-btn" data-toggle="modal" data-target="#addMateriModal">
                    Add Learning Material
                </button>
                <button class="btn btn-secondary add-course-btn ml-2" data-toggle="modal" data-target="#addTugasModal">
                    Add Assignments
                </button>
            </div>
            <h1>Course Class <?php echo htmlspecialchars($selectedClass); ?></h1>
            <!-- Button container for right alignment -->

        </div>

        <!-- Modal for adding Materi -->
        <div class="modal fade" id="addMateriModal" tabindex="-1" aria-labelledby="addMateriModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addMateriModalLabel">Add Learning Material</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="action/Course.php?act=tambah" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="kelas" value="<?php echo htmlspecialchars($selectedClass); ?>">
                            <input type="hidden" name="course" value="Materi">
                            <input type="hidden" name="deadline" value="">
                            <div class="form-group">
                                <label for="judul">Title</label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    placeholder="Enter the learning title" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Description</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi"
                                    placeholder="Enter the description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pertemuan">Meeting</label>
                                <input type="number" class="form-control" id="pertemuan" name="pertemuan"
                                    placeholder="Enter the learning meeting to" required>
                            </div>
                            <div class="form-group">
                                <label for="guru">Guru</label>
                                <input type="text" class="form-control" id="guru" name="guru"
                                    value="<?php echo $_SESSION['nama']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="link">Link</label>
                                <input type="text" class="form-control" id="link" name="link"
                                    placeholder="Enter the link (Optional)">
                                <p class="hint">Upload a link to the material that has been uploaded on google drive</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal for adding Tugas -->
        <div class="modal fade" id="addTugasModal" tabindex="-1" aria-labelledby="addTugasModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addTugasModalLabel">Add Assignments</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="action/Course.php?act=tambah" method="POST">
                        <div class="modal-body">
                            <input type="hidden" name="kelas" value="<?php echo htmlspecialchars($selectedClass); ?>">
                            <input type="hidden" name="course" value="Tugas">
                            <input type="hidden" name="link" value="">
                            <div class="form-group">
                                <label for="judul">Title</label>
                                <input type="text" class="form-control" id="judul" name="judul"
                                    placeholder="Enter the learning title" required>
                            </div>
                            <div class="form-group">
                                <label for="deskripsi">Description</label>
                                <textarea class="form-control" id="deskripsi" name="deskripsi"
                                    placeholder="Enter the description" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="pertemuan">Meeting</label>
                                <input type="number" class="form-control" id="pertemuan" name="pertemuan"
                                    placeholder="Enter the learning meeting to" required>
                            </div>
                            <div class="form-group">
                                <label for="guru">Teacher</label>
                                <input type="text" class="form-control" id="guru" name="guru"
                                    value="<?php echo $_SESSION['nama']; ?>" readonly>
                            </div>
                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="date" class="form-control" id="deadline" name="deadline">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
        // Query distinct sessions for the selected class
        $querySessions = "SELECT DISTINCT pertemuan FROM course WHERE kelas = '$selectedClass' ORDER BY pertemuan";
        $resultSessions = mysqli_query($con, $querySessions);

        while ($session = mysqli_fetch_assoc($resultSessions)) {
            $pertemuan = $session['pertemuan'];
        ?>
        <div class="card">
            <div class="card-header">
                Meeting to <?php echo $pertemuan; ?>
            </div>
            <div class="card-body">
                <?php
                // Query materials for the current session in the selected class
                $queryMateri = "SELECT * FROM course WHERE kelas = '$selectedClass' AND pertemuan = $pertemuan";
                $resultMateri = mysqli_query($con, $queryMateri);

                while ($materi = mysqli_fetch_assoc($resultMateri)) {
                    // Determine the course type (Materi or Tugas)
                    $itemType = ($materi['course'] == 'Tugas') ? 'ASSIGNMENT' : 'FILE';
                    $iconClass = ($materi['course'] == 'Tugas') ? '' : '';
                    $link = ($materi['course'] == 'Tugas') ? 'tugas?id_tugas=' . $materi['id_course'] : $materi['link'];
                   
                    // Check if it's an assignment and whether the deadline has passed
                    $isDeadlinePassed = ($materi['course'] == 'Tugas' && isset($materi['deadline']) && strtotime($materi['deadline']) < strtotime(date('Y-m-d')));
                ?>
                <div class="material-item">
                    <i class="icon <?php echo $iconClass; ?>"></i>
                    <div>
                        <div class="material-title">
                            <?php if (!$isDeadlinePassed) { ?>
                            <a href="<?php echo $link; ?>" class="text-decoration-none">
                                <?php echo $itemType; ?> - <?php echo $materi['judul']; ?>
                            </a>
                            <?php } else { ?>
                            <a href="<?php echo $link; ?>" class="text-decoration-none">
                                <?php echo $itemType; ?> - <?php echo $materi['judul']; ?>
                            </a>
                            <?php } ?>
                        </div>
                        <div class="material-description"><?php echo $materi['deskripsi']; ?></div>

                        <!-- Display Deadline -->
                        <?php if ($materi['course'] == 'Tugas' && isset($materi['deadline'])) { ?>
                        <div class="material-deadline">
                            <strong>Deadline:</strong>
                            <span class="<?php echo $isDeadlinePassed ? 'text-danger' : 'text-success'; ?>">
                                <?php echo date('F j, Y', strtotime($materi['deadline'])); ?>
                            </span>
                        </div>
                        <?php } ?>
                    </div>
                    <div class="status">
                        <!-- Edit and Delete Icons -->
                        <a href="#" data-toggle="modal"
                            data-target="#editCourseModal<?php echo $materi['id_course']; ?>" class="text-primary">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <a href="#" data-toggle="modal"
                            data-target="#deleteCourseModal<?php echo $materi['id_course']; ?>"
                            class="text-danger ml-2">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </div>
                </div>
                <!-- Edit Course Modal -->
                <div class="modal fade" id="editCourseModal<?php echo $materi['id_course']; ?>" tabindex="-1"
                    aria-labelledby="editCourseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editCourseModalLabel">Edit Course</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form
                                action="action/Course.php?act=edit&id_course=<?php echo $materi['id_course']; ?>&id_kelas=<?php echo $selectedClass; ?>"
                                method="POST">
                                <div class="modal-body">
                                    <input type="hidden" name="id_course" value="<?php echo $materi['id_course']; ?>">
                                    <input type="hidden" name="kelas" value="<?php echo $selectedClass; ?>">
                                    <input type="hidden" name="course" value="<?php echo $materi['course']; ?>">

                                    <div class="form-group">
                                        <label for="judul">Title</label>
                                        <input type="text" class="form-control" id="judul" name="judul"
                                            value="<?php echo $materi['judul']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="deskripsi">Description</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi"
                                            required><?php echo $materi['deskripsi']; ?></textarea>
                                    </div>

                                    <div class="form-group">
                                        <label for="pertemuan">Meeting</label>
                                        <input type="number" class="form-control" id="pertemuan" name="pertemuan"
                                            value="<?php echo $materi['pertemuan']; ?>" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="guru">Teacher</label>
                                        <input type="text" class="form-control" id="guru" name="guru"
                                            value="<?php echo $_SESSION['nama']; ?>" readonly>
                                    </div>

                                    <!-- Conditionally display Link field for Materi -->
                                    <?php if ($materi['course'] == 'Materi') { ?>
                                    <div class="form-group">
                                        <label for="link">Link</label>
                                        <input type="text" class="form-control" id="link" name="link"
                                            value="<?php echo $materi['link']; ?>"
                                            placeholder="Enter the link (Optional)">
                                        <p class="hint">Upload a link to the material that has been uploaded on google
                                            drive</p>
                                    </div>
                                    <?php } ?>

                                    <!-- Conditionally display Deadline field for Tugas -->
                                    <?php if ($materi['course'] == 'Tugas') { ?>
                                    <div class="form-group">
                                        <label for="deadline">Deadline</label>
                                        <input type="date" class="form-control" id="deadline" name="deadline"
                                            value="<?php echo $materi['deadline']; ?>">
                                    </div>
                                    <?php } ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Delete Course Modal -->
                <div class="modal fade" id="deleteCourseModal<?php echo $materi['id_course']; ?>" tabindex="-1"
                    aria-labelledby="deleteCourseModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteCourseModalLabel">Delete Course</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form
                                action="action/Course.php?act=delete&id_course=<?php echo $materi['id_course']; ?>&id_kelas=<?php echo $selectedClass; ?>"
                                method="POST">
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this course
                                        "<b><?php echo $materi['judul']; ?></b>"?</p>
                                    <input type="hidden" name="id_course" value="<?php echo $materi['id_course']; ?>">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


                <?php } ?>
            </div>
        </div>
        <?php } ?>
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
                                <input type="text" class="form-control" name="nama"
                                    value="<?php echo $_SESSION['nama']; ?>" placeholder="Masukkan Nama Guru" required>
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
</body>

</html>