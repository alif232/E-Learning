<?php
session_start();
include '../../../koneksi.php';

// Ensure the user has admin rights
if (!isset($_SESSION['id_user']) || $_SESSION['level'] !== 'Admin') {
    header("Location: ../dashboard?pesan=unauthorized");
    exit;
}

// Clear the `course`, `tugas`, and `komentar` tables
mysqli_query($con, "DELETE FROM course");
mysqli_query($con, "DELETE FROM tugas");
mysqli_query($con, "DELETE FROM komentar");

// Delete all video files from the ../../video/ directory
$videoDirectory = '../../../video/';
$files = glob($videoDirectory . '*'); // Get all file names

foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file); // Delete file
    }
}

// Redirect back with a success message
header("Location: ../dashboard?pesan=reset_success");
exit;
?>
