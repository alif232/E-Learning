<?php
session_start();
include '../koneksi.php';

if ($_GET['act'] == 'login') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Query untuk mengambil data pengguna berdasarkan email
        $sql = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        // Periksa apakah email ditemukan di database
        if ($result && mysqli_num_rows($result) > 0) {
            $data = mysqli_fetch_assoc($result);

            // Verifikasi password yang diinput dengan password yang tersimpan
            if (password_verify($password, $data['password'])) {
                // Jika password benar, set session dan arahkan berdasarkan level pengguna
                $_SESSION['id_user'] = $data['id_user'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['nama'] = $data['nama'];
                $_SESSION['kelas'] = $data['kelas'];
                $_SESSION['level'] = $data['level'];

                // Arahkan pengguna berdasarkan level
                if ($data['level'] == "Admin") {
                    header("Location: admin?pesan=berhasil");
                } elseif ($data['level'] == "Guru") {
                    header("Location: guru?pesan=berhasil");
                } elseif ($data['level'] == "Murid") {
                    header("Location: murid?pesan=berhasil");
                } else {
                    header("Location: login?pesan=level_tidak_dikenal");
                }
                exit;
            } else {
                // Password salah
                header("Location: login?pesan=password_salah");
                exit;
            }
        } else {
            // Email tidak ditemukan
            header("Location: login?pesan=email_tidak_ditemukan");
            exit;
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    }
}

if ($_GET['act'] == 'register') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        include '../koneksi.php'; // Ensure the database connection is included
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $repeatPassword = $_POST['repeat_password'];

        // Check if password and repeat password match
        if ($password !== $repeatPassword) {
            // Redirect to register page with an error message
            header("Location: register?pesan=password_tidak_sesuai");
            exit;
        }

        // Hash the password before saving to the database
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Insert new user into the database
        $sql = "INSERT INTO user (nama, kelas, email, password, level) VALUES (?, ?, ?, ?, 'Murid')";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "ssss", $nama, $kelas, $email, $hashedPassword);
        $insertSuccess = mysqli_stmt_execute($stmt);

        if ($insertSuccess) {
            header("Location: login?pesan=registrasi_berhasil");
        } else {
            header("Location: register?pesan=registrasi_gagal");
        }

        mysqli_stmt_close($stmt);
    }
}
?>