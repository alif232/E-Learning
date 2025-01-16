<?php

include '../../../koneksi.php';

#Proses Tambah
if ($_GET['act'] == 'tambah') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama = $_POST['nama'];

        mysqli_query($con,"INSERT INTO kelas (nama) VALUES('$nama')");

        header("location:../kelas?pesan=tambah");
    }
}

#Proses Edit
if ($_GET['act'] == 'edit') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_kelas = $_POST['id_kelas'];
        $nama = $_POST['nama'];

        $result = mysqli_query($con, "UPDATE kelas SET nama = '$nama' WHERE id_kelas = '$id_kelas'");

        header("location:../kelas?pesan=edit");
    }
}

#Proses Hapus
if ($_GET['act'] == 'hapus') {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_kelas = $_GET['id'];

        $result = mysqli_query($con, "DELETE FROM kelas WHERE id_kelas = '$id_kelas'");

        header("location:../kelas?pesan=hapus");
    }
}