<?php

include("../../koneksi.php");

if(isset($_POST['simpan'])){

    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nomorHP = $_POST['nomorHP'];
    $role = $_POST['role'];

    $result = mysqli_query($conn,"UPDATE user
    SET nama='$nama', email='$email',password='$password', nomorHP=$nomorHP, role='$role'
    WHERE id=$id");
    header('Location: index.php');
} else {
    die("Tidak bisa diakses...");
}
?>