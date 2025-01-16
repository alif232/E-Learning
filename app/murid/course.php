<?php
session_start();
include '../../koneksi.php';

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) { ?>
<script>
alert("!!!! Maaf Anda Harus Login Dulu.");
window.location.assign('../');
</script>
<?php
    exit;
}

// Get the user's class from the session
$selectedClass = $_SESSION['kelas'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon.png">
    <title>Epresent - Student | <?php echo htmlspecialchars($selectedClass); ?></title>
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
                <a href="course">Course</a>
                <a href="#" data-toggle="modal" data-target="#editProfileModal">Profile</a>
                <a href="#" class="logout" data-toggle="modal" data-target="#logoutModal">Logout</a>
            </div>
        </div>
    </header>

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

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h1>Course for Class <?php echo htmlspecialchars($selectedClass); ?></h1>
        </div>

        <?php
        // Query distinct sessions for the user's class
        $querySessions = "SELECT DISTINCT pertemuan FROM course WHERE kelas = '$selectedClass' ORDER BY pertemuan";
        $resultSessions = mysqli_query($con, $querySessions);

        // Loop through each session and display courses
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
                    $itemType = ($materi['course'] == 'Tugas') ? 'ASSIGNMENT' : 'FILE';
                    $link = ($materi['course'] == 'Tugas') ? 'tugas?id_course=' . $materi['id_course'] : $materi['link'];

                    // Check if the deadline has passed
                    $isDeadlinePassed = ($materi['course'] == 'Tugas' && isset($materi['deadline']) && strtotime($materi['deadline']) < strtotime(date('Y-m-d')));
                ?>
                <div class="material-item">
                    <i class="icon"></i>
                    <div>
                        <div class="material-title">
                            <?php if (!$isDeadlinePassed) { ?>
                            <a href="<?php echo $link; ?>" class="text-decoration-none">
                                <?php echo $itemType; ?> - <?php echo $materi['judul']; ?>
                            </a>
                            <?php } else { ?>
                            <span class="text-muted">
                                <a href="<?php echo $link; ?>" class="text-decoration-none">
                                    <?php echo $itemType; ?> - <?php echo $materi['judul']; ?>
                            </span>
                            <span class="deadline-passed" style="color: red;">(Deadline Passed)</span>
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
                        <!-- Additional status or icons can be placed here -->
                    </div>
                </div>
                <?php } ?>
            </div>
        </div>
        <?php } ?>
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

    <!-- JavaScript and dependencies -->
    <script src="../../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../../assets/vendor/jquery-easing/jquery.easing.min.js"></script>
    <script src="../../assets/js/sb-admin-2.min.js"></script>

    <script>
    function toggleMenu() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('show-nav');
    }
    </script>
</body>

</html>