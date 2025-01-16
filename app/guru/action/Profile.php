<?php
session_start();
include '../../../koneksi.php'; // Include your database connection

$id_user = $_POST['id_user'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password']; 

// Hash password menggunakan bcrypt
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Prepare the SQL query to update the user's details
$sql = "UPDATE user SET nama = ?, email = ?";

// Add password to query if it's provided
if (!empty($password)) {
    $sql .= ", password = ?";
}
$sql .= " WHERE id_user = ?";

// Prepare the statement
$stmt = mysqli_prepare($con, $sql);

// Bind parameters based on whether a password is provided
if (!empty($password)) {
    mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $hashedPassword, $id_user);
} else {
    mysqli_stmt_bind_param($stmt, "ssi", $nama, $email, $id_user);
}

// Execute the query
if (mysqli_stmt_execute($stmt)) {
    // If update is successful, update session data
    $_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;

    header("location:../home?pesanedit");
} else {
    echo "<script>alert('Error updating profile. Please try again.');</script>";
}

// Close the statement and connection
mysqli_stmt_close($stmt);
mysqli_close($con);
?>