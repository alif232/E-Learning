<?php

include '../../../koneksi.php';

#Proses Komentar
if ($_GET['act'] == 'komen') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Get the comment details from the POST data
        $id_tugas = $_POST['id_tugas'];
        $id_user = $_POST['id_user'];
        $komentar = $_POST['komentar'];

        // Validate that all required data is present
        if (!empty($id_tugas) && !empty($id_user) && !empty($komentar)) {
            // Prepare and execute the SQL query to insert the comment
            $query = "INSERT INTO komentar (id_tugas, id_user, komentar) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, "iis", $id_tugas, $id_user, $komentar);
            $success = mysqli_stmt_execute($stmt);

            if ($success) {
                // Redirect with a success message
                header("Location: ../detail_tugas.php?id_tugas=$id_tugas&pesan=komentar_berhasil");
                exit;
            } else {
                echo "Error adding comment: " . mysqli_error($con);
            }

            // Close the prepared statement
            mysqli_stmt_close($stmt);
        } else {
            echo "All fields are required.";
        }
    }
}

#Proses Nilai
if ($_GET['act'] == 'nilai') {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get the task ID and grade from POST data
        $taskId = $_POST['assignment_id'] ?? null;
        $grade = $_POST['grade'] ?? null;
    
        // Validate that the task ID and grade are provided and grade is within 0-100
        if ($taskId !== null && $grade !== null && is_numeric($grade) && $grade >= 0 && $grade <= 100) {
            // Prepare the SQL statement to update the grade
            $query = "UPDATE tugas SET grade = ? WHERE id_tugas = ?";
            $stmt = mysqli_prepare($con, $query);
    
            // Bind parameters and execute the statement
            mysqli_stmt_bind_param($stmt, "ii", $grade, $taskId);
            $success = mysqli_stmt_execute($stmt);
    
            // Check if the update was successful
            if ($success) {
                // Redirect back to the task detail page with a success message
                $_SESSION['message'] = "Grade updated successfully.";
                header("Location: ../detail_tugas.php?id_tugas=$taskId");
                exit;
            } else {
                // Display an error message if the update fails
                echo "Error updating grade: " . mysqli_error($con);
            }
    
            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "Invalid grade value. Please enter a number between 0 and 100.";
        }
    } else {
        echo "Invalid request method.";
    }
}