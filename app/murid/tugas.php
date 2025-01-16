<?php
session_start();
include '../../koneksi.php';
// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('!!!! Maaf Anda Harus Login Dulu.'); window.location.assign('../');</script>";
    exit;
}

// Get the course ID and user ID
$idCourse = $_GET['id_course'];
$idUser = $_SESSION['id_user'];

// Query to fetch the course title and deadline based on id_course
$query = "SELECT judul, guru, deadline FROM course WHERE id_course = '$idCourse'";
$resultCourse = mysqli_query($con, $query);
$courseData = mysqli_fetch_assoc($resultCourse);

$courseTitle = $courseData['judul'] ?? 'Tugas';
$courseTeacher = $courseData['guru'] ?? 'Tidak Diketahui';
$courseDeadline = isset($courseData['deadline']) ? date('F j, Y', strtotime($courseData['deadline'])) : 'Tidak Ditetapkan';

// Check if the deadline has passed
$isDeadlinePassed = isset($courseData['deadline']) && strtotime($courseData['deadline']) < time();

// Fetch id_tugas based on the id_course and user (murid)
$queryTask = "SELECT id_tugas FROM tugas WHERE id_course = '$idCourse' AND id_user = '$idUser'";
$resultTask = mysqli_query($con, $queryTask);
$taskData = mysqli_fetch_assoc($resultTask);
$idTask = $taskData['id_tugas'] ?? null;

// Query to fetch comments related to this task
$queryComments = "SELECT c.komentar, u.nama AS author, c.date_created
                  FROM komentar c
                  JOIN user u ON c.id_user = u.id_user
                  WHERE c.id_tugas = '$idTask'
                  ORDER BY c.date_created DESC";
$resultComments = mysqli_query($con, $queryComments);

// Query to check if the user has uploaded a video and fetch the grade
$queryGrade = "SELECT link, grade FROM tugas WHERE id_course = '$idCourse' AND id_user = '$idUser'";
$resultGrade = mysqli_query($con, $queryGrade);
$gradeData = mysqli_fetch_assoc($resultGrade);
$videoFile = $gradeData['link'] ?? null;
$grade = $gradeData['grade'] ?? 'Belum Dinilai';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon.png">
    <title>Epresent - Student</title>
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
        border-radius: 8px;
    }

    .record-section {
        margin: 20px;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .controls {
        margin-top: 10px;
    }

    .controls button {
        padding: 10px 15px;
        margin: 5px;
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }

    .controls button:hover {
        background-color: #0056b3;
    }

    /* Comment Section */

    .comment-card {
        background-color: #f4f4f4;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .comment-card .comment-author {
        font-weight: bold;
        color: #333;
    }

    .comment-card .comment-text {
        margin-top: 5px;
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

    /* Styling the progress bar */
    .progress-container {
        margin-top: 20px;
        width: 100%;
        max-width: 920px;
        margin-bottom: 10px;
    }

    progress {
        width: 100%;
        height: 25px;
        border-radius: 5px;
    }

    #progressPercentage {
        font-size: 1rem;
        color: #333;
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
        <!-- Welcome Card -->
        <div class="welcome-card">
            Please Do The Assignment
        </div>
        <div class="welcome-card">
            Class <?php echo $_SESSION['kelas']; ?>
        </div>

        <!-- User Details -->
        <div class="user-details">
            <p><strong>Assignment Title:</strong> <?php echo htmlspecialchars($courseTitle); ?></p>
            <p><strong>Teacher Name:</strong> <?php echo htmlspecialchars($courseTeacher); ?></p>
            <p><strong>Deadline Date:</strong> <?php echo htmlspecialchars($courseDeadline); ?>
                <?php if ($isDeadlinePassed) { ?>
                <span style="color: red;">(Deadline Passed)</span>
                <?php } ?>
            </p>
            <!-- Add more user info if available in session -->
        </div>
    </div>

    <div class="video-container">
        <?php if ($videoFile): ?>
        <h3 style="color: black;">Presentation Assignment Result</h3>
        <video id="videoPlayback" width="920" height="480" controls>
            <source src="../../video/<?php echo $videoFile; ?>" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <button class="btn btn-danger" data-toggle="modal" data-target="#removeVideoModal">Remove Video</button>
        <?php elseif ($isDeadlinePassed): ?>
        <div class="container">
            <h3 style="color: red;">The deadline has passed. You cannot record this assignment.</h3>
        </div>
        <?php else: ?>
        <h3 style="color: black;">Record Presentation Assignment</h3>
        <div id="recordingContainer">
            <video id="videoPreview" width="920" height="480" autoplay muted></video>
            <video id="recordedVideo" width="920" height="480" controls style="display: none;"></video>
            <div class="controls">
                <button id="startRecording">Start Recording</button>
                <button id="stopRecording" style="display: none;">Stop Recording</button>
                <button id="retryRecording" style="display: none;">Retry Recording</button>
                <button id="uploadRecording" style="display: none;">Upload Recording</button>
                <div id="recordingDuration" style="margin-top: 10px; color: black;">00:00</div> <!-- Durasi -->
            </div>
        </div>
        <?php endif; ?>

        <!-- Progress Bar Section -->
        <div class="progress-container">
            <progress id="uploadProgress" value="0" max="100" style="width: 100%;"></progress>
            <span id="progressPercentage">0%</span>
        </div>

    </div>

    <!-- Remove Video Modal -->
    <div class="modal fade" id="removeVideoModal" tabindex="-1" role="dialog" aria-labelledby="removeVideoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="removeVideoModalLabel">Remove Video</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to remove this video? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <form action="action/Tugas.php?act=remove_video" method="POST" style="display:inline;">
                        <input type="hidden" name="id_course" value="<?php echo $idCourse; ?>">
                        <input type="hidden" name="id_user" value="<?php echo $idUser; ?>">
                        <input type="hidden" name="video_file" value="<?php echo $videoFile; ?>">
                        <button type="submit" class="btn btn-danger">Remove Video</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Grade Form Section -->
    <div class="container grade-section">
        <h2 style="color: black;">Grade Assignment</h2>
        <form action="action/Tugas.php?act=nilai" method="POST">
            <input type="hidden" name="assignment_id" value="<?php echo $taskId; ?>">
            <input type="number" name="grade" id="grade" class="grade-input" min="0" max="100"
                value="<?php echo $grade; ?>" placeholder="" readonly>
        </form>
        <p class="grade-hint">Value (0-100)</p>
    </div>

    <!-- Comment Section -->
    <div class="container">
        <h3 style="color: black;">Comment</h3>

        <?php
            // Display each comment
            if ($resultComments && mysqli_num_rows($resultComments) > 0) {
                while ($comment = mysqli_fetch_assoc($resultComments)) {
                    $commentText = $comment['komentar'];
                    $commenterName = $comment['author'];
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
            <input type="hidden" name="id_tugas" value="<?php echo $idTask; ?>">
            <input type="hidden" name="id_course" value="<?php echo $idCourse; ?>">
            <input type="hidden" name="id_user" value="<?php echo $_SESSION['id_user']; ?>">
            <textarea class="comment-input" name="komentar" placeholder="Write your comment..." required></textarea>
            <button class="comment-btn" type="submit">Submit a comment</button>
        </form>
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

    <script>
    // JavaScript untuk Recording
    const videoPreview = document.getElementById('videoPreview');
    const recordedVideo = document.getElementById('recordedVideo');
    const startRecordingBtn = document.getElementById('startRecording');
    const stopRecordingBtn = document.getElementById('stopRecording');
    const retryRecordingBtn = document.getElementById('retryRecording');
    const uploadRecordingBtn = document.getElementById('uploadRecording');
    const recordingDuration = document.getElementById('recordingDuration'); // Elemen untuk durasi

    let mediaRecorder;
    let recordedChunks = [];
    let startTime;
    let timerInterval;

    // Access the user's webcam and microphone
    navigator.mediaDevices.getUserMedia({
            video: true,
            audio: true
        })
        .then(stream => {
            videoPreview.srcObject = stream;
            mediaRecorder = new MediaRecorder(stream);

            mediaRecorder.ondataavailable = event => {
                if (event.data.size > 0) {
                    recordedChunks.push(event.data);
                }
            };

            mediaRecorder.onstop = () => {
                const blob = new Blob(recordedChunks, {
                    type: 'video/mp4'
                });
                recordedVideo.src = URL.createObjectURL(blob);
                recordedVideo.style.display = 'block';
                videoPreview.style.display = 'none';

                // Display upload and retry buttons
                uploadRecordingBtn.style.display = 'inline';
                retryRecordingBtn.style.display = 'inline';

                // Hentikan timer
                clearInterval(timerInterval);

                // Attach upload function to the upload button
                uploadRecordingBtn.onclick = () => uploadRecording(blob);
            };

            startRecordingBtn.onclick = () => {
                recordedChunks = [];
                mediaRecorder.start();
                startTime = Date.now(); // Menyimpan waktu saat rekaman dimulai
                startRecordingBtn.style.display = 'none';
                stopRecordingBtn.style.display = 'inline';
                recordedVideo.style.display = 'none';
                videoPreview.style.display = 'block';
                // Mulai timer
                timerInterval = setInterval(updateDuration, 1000);
            };

            stopRecordingBtn.onclick = () => {
                mediaRecorder.stop();
                stopRecordingBtn.style.display = 'none';
            };

            retryRecordingBtn.onclick = () => {
                recordedChunks = [];
                recordedVideo.style.display = 'none';
                videoPreview.style.display = 'block';
                startRecordingBtn.style.display = 'inline';
                stopRecordingBtn.style.display = 'none';
                retryRecordingBtn.style.display = 'none';
                uploadRecordingBtn.style.display = 'none';
                // Reset timer
                clearInterval(timerInterval);
                recordingDuration.textContent = '00:00';
            };
        })
        .catch(error => console.error('Error accessing media devices.', error));

    // Fungsi untuk mengupdate durasi rekaman
    function updateDuration() {
        const elapsedTime = Math.floor((Date.now() - startTime) / 1000); // Hitung detik yang telah berlalu
        const minutes = Math.floor(elapsedTime / 60);
        const seconds = elapsedTime % 60;
        recordingDuration.textContent = `${padZero(minutes)}:${padZero(seconds)}`; // Format menjadi mm:ss
    }

    // Fungsi untuk menambahkan angka nol di depan jika kurang dari dua digit
    function padZero(num) {
        return num < 10 ? `0${num}` : num;
    }

    // Function to upload the recording
    function uploadRecording(blob) {
        const formData = new FormData();
        formData.append('videoFile', blob, 'recording.mp4');
        formData.append('id_course', <?php echo $idCourse; ?>);
        formData.append('id_user', <?php echo $idUser; ?>);

        // Get the progress bar element
        const progressBar = document.getElementById('uploadProgress');
        const progressPercentage = document.getElementById('progressPercentage');

        // Create a new XMLHttpRequest
        const xhr = new XMLHttpRequest();

        // Set up the progress event
        xhr.upload.onprogress = function(event) {
            if (event.lengthComputable) {
                // Calculate the progress percentage
                const percent = (event.loaded / event.total) * 100;
                progressBar.value = percent;
                progressPercentage.textContent = `${Math.round(percent)}%`; // Update the percentage text
            }
        };

        // Set up the upload complete event
        xhr.onload = function() {
            if (xhr.status === 200) {
                alert('Video uploaded successfully!');
                window.location.reload();
            } else {
                alert('An error occurred while uploading the video.');
            }
        };

        // Set up the error event
        xhr.onerror = function() {
            alert('An error occurred during the file upload.');
        };

        // Send the request
        xhr.open('POST', 'action/Tugas.php?act=video', true);
        xhr.send(formData);
    }
    </script>

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