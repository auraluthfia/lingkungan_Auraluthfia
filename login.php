<?php
session_start();
include 'koneksi.php';

$email = $_POST['email'];
$password = $_POST['Password'];

$login = mysqli_query($conn, "SELECT * FROM user WHERE email='$email' AND password='$password'");

if ($login) {
    $cek = mysqli_num_rows($login);

    if ($cek > 0) {
        $data = mysqli_fetch_assoc($login);

        if ($data['role'] == "admin") {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "admin";
            header("Location: admin/user/index.php");
        } else if ($data['role'] == "user") {
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "user";
            header("Location: user/index.php");
        } else {
            header("Location: index.php");
        }
    } else {
        header("Location: index.php?pesan=gagal-login");
    }
} else {
    echo "Error: " . mysqli_error($conn);
}
?>