<?php

include '../../../koneksi.php';

#Proses Tambah
if ($_GET['act'] == 'tambah') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash password menggunakan bcrypt
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        mysqli_query($con,"INSERT INTO user (nama, kelas, email, password, level) 
                    VALUES('$nama', '$kelas', '$email', '$hashedPassword', 'Murid')");

        header("location:../murid?pesan=tambah");
    }
}

#Proses Edit
if ($_GET['act'] == 'edit') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_user = $_POST['id_user'];
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash password menggunakan bcrypt
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $result = mysqli_query($con, "UPDATE user SET nama = '$nama', kelas = '$kelas', 
                    email = '$email', password = '$hashedPassword' WHERE id_user = '$id_user'");

        header("location:../murid?pesan=edit");
    }
}

#Proses Hapus
if ($_GET['act'] == 'hapus') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_user = $_GET['id'];

        $result = mysqli_query($con, "DELETE FROM user WHERE id_user = '$id_user'");

        header("location:../murid?pesan=hapus");
    }
}