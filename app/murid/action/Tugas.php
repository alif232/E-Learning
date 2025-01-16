<?php
session_start();
include '../../../koneksi.php';

// Set header to return JSON format and suppress PHP error display
header('Content-Type: application/json');
ini_set('display_errors', 0);
error_reporting(0);

// Check if action is set
if (!isset($_GET['act'])) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit;
}

// Process video upload
if ($_GET['act'] == 'video') {
    // Check for a logged-in user
    if (!isset($_SESSION['id_user'])) {
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    // Ensure the video file, id_course, and id_user are provided
    if (!isset($_FILES['videoFile']) || !isset($_POST['id_course']) || !isset($_POST['id_user'])) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
        exit;
    }

    $idCourse = $_POST['id_course'];
    $idUser = $_POST['id_user'];
    $uploadDir = '../../../video/'; // Directory where videos will be stored

    // Ensure the upload directory exists
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Process the uploaded video file
    $videoFile = $_FILES['videoFile'];
    $videoFileName = $idUser . '_' . time() . '_' . basename($videoFile['name']); // Unique file name
    $targetFilePath = $uploadDir . $videoFileName;

    // Move the uploaded file to the server's upload directory
    if (move_uploaded_file($videoFile['tmp_name'], $targetFilePath)) {
        // Convert file path to a relative path for storing in the database
        $relativeFilePath =  $videoFileName;

        // Insert or update the video link in the `tugas` table for this user and course
        $query = "INSERT INTO tugas (id_course, id_user, link) VALUES ('$idCourse', '$idUser', '$relativeFilePath')
                  ON DUPLICATE KEY UPDATE link = '$relativeFilePath'";
      
        if (mysqli_query($con, $query)) {
            echo json_encode(['status' => 'success', 'message' => 'Video uploaded successfully']);
        } else {
            // Remove the file if the database operation fails
            unlink($targetFilePath);
            echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($con)]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
    }
    exit;
}

//proses remove video
if ($_GET['act'] == 'remove_video') {
    // Get the course ID, user ID, and video filename from the POST request
    $idCourse = $_POST['id_course'];
    $idUser = $_POST['id_user'];
    $videoFile = $_POST['video_file'];

    // Query to delete the record from the 'tugas' table based on course ID and user ID
    $query = "DELETE FROM tugas WHERE id_course = '$idCourse' AND id_user = '$idUser' AND link = '$videoFile'";

    if (mysqli_query($con, $query)) {
        // Delete the video file from the server
        $videoPath = '../../../video/' . $videoFile;
        if (file_exists($videoPath)) {
            unlink($videoPath); // Delete the file
        }

        // Set a session variable to show success message or simply pass the success message via URL
        session_start();
        $_SESSION['message'] = 'Video removed successfully.';

        // Redirect to the tugas.php page with course ID as a query parameter
        header("Location: ../tugas.php?id_course=$idCourse");
        exit;
    } else {
        // Set an error message in the session for failure
        session_start();
        $_SESSION['message'] = 'Failed to remove video.';

        // Redirect to the tugas.php page with course ID as a query parameter
        header("Location: ../tugas.php?id_course=$idCourse");
        exit;
    }
}

// Process Comment
if ($_GET['act'] == 'komen') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the comment details from the POST data
        $id_course = $_POST['id_course'];
        $id_tugas = $_POST['id_tugas'];
        $id_user = $_POST['id_user'];
        $komentar = $_POST['komentar'];

        // Validate that all required data is present
        if (!empty($id_tugas) && !empty($id_user) && !empty($komentar)) {
            // Prepare and execute the SQL query to insert the comment
            $query = "INSERT INTO komentar (id_tugas, id_user, komentar, date_created) VALUES (?, ?, ?, NOW())";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "iis", $id_tugas, $id_user, $komentar);
            $success = mysqli_stmt_execute($stmt);

            if ($success) {
                header("Location: ../tugas?id_course=$id_course&pesan=komentar_berhasil");
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Database error: ' . mysqli_error($con)]);
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        }
    }
    exit;
}
?>