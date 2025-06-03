<?php
include '../../koneksi.php';
$id = $_POST['id'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$query = "UPDATE user SET nama = '$nama', email = '$email', password = '$password'";
$query .= "WHERE id = '$id'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query gagal dijalankan: " . mysqli_errno($conn) .
        " - " . mysqli_error($conn));
} else {
    $query = "UPDATE user SET nama = '$nama', email = '$email', password = '$password'";
    $query .= "WHERE id = '$id'";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        die("Query gagal dijalankan: " . mysqli_errno($conn) .
            " - " . mysqli_error($conn));
    } else {
        echo "<script>alert('Data berhasil diubah.');window.location='profil.php';</script>";
    }
}
?>