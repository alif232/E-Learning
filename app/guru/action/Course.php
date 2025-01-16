<?php
session_start();
include '../../../koneksi.php';

// Check if the user is logged in
if (!isset($_SESSION['id_user'])) {
    echo "<script>alert('Anda harus login terlebih dahulu');</script>";
    echo "<script>window.location.assign('../');</script>";
    exit;
}

// Handle adding a new course (Tambah Course)
if ($_GET['act'] == 'tambah') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect form data
        $kelas = $_POST['kelas'];
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $link = $_POST['link']; // Optional field for Materi
        $pertemuan = $_POST['pertemuan'];
        $courseType = $_POST['course']; // Type (Materi or Tugas)
        $guru = $_POST['guru'];
        $deadline = $_POST['deadline'] ; // Optional field for Tugas

        // Prepare the SQL insert query
        $query = "INSERT INTO course (kelas, judul, deskripsi, link, pertemuan, course, guru, deadline)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssssisss", $kelas, $judul, $deskripsi, $link, $pertemuan, $courseType, $guru, $deadline);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo "<script>window.location.assign('../course.php?id_kelas=" . urlencode($kelas) . "');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menambahkan course!');</script>";
            echo "<script>window.history.back();</script>";
        }

        // Close statement and connection
        $stmt->close();
        $con->close();
    } else {
        // Redirect if accessed directly
        echo "<script>window.location.assign('../kelas');</script>";
    }
}

// Handle editing a course (Edit Course)
if (isset($_GET['act']) && $_GET['act'] == 'edit') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect form data
        $id_course = $_POST['id_course'];
        $kelas = $_POST['kelas'];
        $judul = $_POST['judul'];
        $deskripsi = $_POST['deskripsi'];
        $link = $_POST['link'] ?? ''; // Optional field for Materi
        $pertemuan = $_POST['pertemuan'];
        $courseType = $_POST['course']; // Type (Materi or Tugas)
        $guru = $_POST['guru'];
       
        // Check if deadline is provided; if not, set to default "N/A"
        $deadline = $_POST['deadline'] ?? '';
        if (empty($deadline) && $courseType == 'Materi') {
            $deadline = 'N/A'; // Default value if not provided
        }

        // Prepare the SQL update query
        $query = "UPDATE course SET kelas=?, judul=?, deskripsi=?, link=?, pertemuan=?, course=?, guru=?, deadline=? WHERE id_course=?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ssssisssi", $kelas, $judul, $deskripsi, $link, $pertemuan, $courseType, $guru, $deadline, $id_course);

        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo "<script>window.location.assign('../course.php?id_kelas=" . urlencode($kelas) . "');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat memperbarui course!');</script>";
            echo "<script>window.history.back();</script>";
        }

        // Close statement and connection
        $stmt->close();
        $con->close();
    }
}

// Handle deleting a course (Delete Course)
if (isset($_GET['act']) && $_GET['act'] == 'delete') {
    if (isset($_GET['id_course'])) {
        $id_course = $_GET['id_course'];
       
        // Prepare the SQL delete query
        $query = "DELETE FROM course WHERE id_course = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("i", $id_course);
       
        // Execute the query and check if it was successful
        if ($stmt->execute()) {
            echo "<script>window.location.assign('../course.php?id_kelas=" . urlencode($_GET['id_kelas']) . "');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus course!');</script>";
            echo "<script>window.history.back();</script>";
        }
       
        // Close statement and connection
        $stmt->close();
        $con->close();
    }
}
?>

