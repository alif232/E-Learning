<?php

$user = "root";
$pass = "";
$db = "elearning";
$host = "localhost";

$con = mysqli_connect($host, $user, $pass, $db);
if(!$con){
    die("Koneksi database gagal". mysqli_connect_error());
} 
?>