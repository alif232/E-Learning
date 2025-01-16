<?php
session_start();
include '../../koneksi.php';

// Get the task ID from the URL
$taskId = $_GET['id_tugas'] ?? null;

if ($taskId === null) {
    echo "Task not found.";
    exit;
}

// Query the task details
$queryTask = "SELECT t.*, c.judul AS course_title, u.nama AS student_name
              FROM tugas t
              JOIN course c ON t.id_course = c.id_course
              JOIN user u ON t.id_user = u.id_user
              WHERE t.id_tugas = '$taskId'";
$resultTask = mysqli_query($con, $queryTask);

if ($resultTask && mysqli_num_rows($resultTask) > 0) {
    $task = mysqli_fetch_assoc($resultTask);
    $taskTitle = $task['course_title'];
    $studentName = $task['student_name'];
    $dateCreated = $task['date_created'];
    $grade = $task['grade'];
    $videoLink = $task['link'];
} else {
    echo "Task details not found.";
    exit;
}

// Query comments for this task
$queryComments = "SELECT k.komentar, u.nama AS commenter_name, k.date_created
                  FROM komentar k
                  JOIN user u ON k.id_user = u.id_user
                  WHERE k.id_tugas = '$taskId'
                  ORDER BY k.id_komentar DESC";
$resultComments = mysqli_query($con, $queryComments);
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

    /* Make the video container responsive */
    .video-container {
        position: relative;
        width: 100%;
        max-width: 960px;
        margin: 20px auto;
        padding: 0 10px;
        background-color: #fff;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    video {
        width: 100%;
        height: auto;
        border-radius: 10px;
    }

    /* Comment Section */

    .comment-card {
        background-color: #f4f4f4;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        margin-right: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .comment-card .comment-author {
        font-weight: bold;
        color: #333;
    }

    .comment-card .comment-text {
        margin-top: 1px;
        color: #555;
    }

    .comment-input {
        width: 98%;
        padding: 10px;
        border-radius: 5px;
        border: 1px solid #ddd;
        margin-top: 10px;
        margin-bottom: 10px;
        font-size: 1rem;
        background-color: #f9f9f9;
    }

    .comment-input::placeholder {
        color: #888;
    }

    .comment-btn {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
    }

    .comment-btn:hover {
        background-color: #0056b3;
    }

    .grade-section {
        margin-top: 20px;
    }

    .grade-input {
        padding: 10px;
        width: 100%;
        max-width: 200px;
        border-radius: 5px;
        border: 1px solid #ddd;
        font-size: 1rem;
    }

    .grade-input::placeholder {
        color: #888;
    }

    .grade-btn {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 10px;
    }

    .grade-btn:hover {
        background-color: #218838;
    }

    .grade-hint {
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
        <!-- Welcome Card -->
        <div class="welcome-card">
            Detail Assignment
        </div>

        <!-- User Details -->
        <div class="user-details">
            <p><strong>Assignment title:</strong> <?php echo $taskTitle; ?></p>
            <p><strong>Student Name:</strong> <?php echo $studentName; ?></p>
            <p><strong>Uploaded on:</strong> <?php echo date('F j, Y', strtotime($dateCreated)); ?></p>
            <!-- Add more user info if available in session -->
        </div>
    </div>

    <!-- Video Playback -->
    <div class="video-container">
        <h2 style="color: black;">Assignment Video</h2>
        <?php if ($videoLink): ?>
        <video id="videoPlayback" controls>
            <source src="../../video/<?php echo $videoLink; ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <?php else: ?>
        <p>No video submitted for this task.</p>
        <?php endif; ?>
    </div>

    <!-- Grade Form Section -->
    <div class="container grade-section">
        <h2 style="color: black;">Grade Assignment</h2>
        <form action="action/Tugas.php?act=nilai" method="POST">
            <input type="hidden" name="assignment_id" value="<?php echo $taskId; ?>">
            <input type="number" name="grade" id="grade" class="grade-input" min="0" max="100"
                value="<?php echo $grade; ?>" placeholder="Enter grade (0-100)" required>
            <button type="submit" class="grade-btn">Submit Grade</button>
        </form>
        <p class="grade-hint">Enter value (0-100)</p>
    </div>

    <!-- Comment Section -->
    <div class="container">
        <h3 style="color: black;">Comment</h3>

        <?php
            // Display each comment
            if ($resultComments && mysqli_num_rows($resultComments) > 0) {
                while ($comment = mysqli_fetch_assoc($resultComments)) {
                    $commentText = $comment['komentar'];
                    $commenterName = $comment['commenter_name'];
                    $commenterTgl = $comment['date_created'];
            ?>
        <div class="comment-card">
            <div class="comment-author"><?php echo htmlspecialchars($commenterName); ?></div>
            <div class="comment-text"><?php echo htmlspecialchars($commentText); ?></div>
            <div class="comment-text"><?php echo htmlspecialchars($commenterTgl); ?></div>
        </div>
        <?php
                }
            } else {
                echo "<p style='color: black;'>No comments available for this task.</p>";
            }
            ?>

        <!-- Comment Input and Submit -->
        <form action="action/Tugas.php?act=komen" method="POST">
            <input type="hidden" name="id_tugas" value="<?php echo $taskId; ?>">
            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
            <textarea class="comment-input" name="komentar" placeholder="Write your comment..." required></textarea>
            <button class="comment-btn" type="submit">Submit a comment</button>
        </form>
    </div>

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

    <!-- JavaScript to toggle the menu -->
    <script>
    function toggleMenu() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('show-nav');
    }
    </script>
</body>

</html>