<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../login.php");
    exit();
}

if (isset($_GET['id'])) {
    $IDpesanan = $_GET['id'];
    $updateQuery = "UPDATE pesanan SET status = 'canceled' WHERE IDpesanan = '$IDpesanan'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        header("Location:/SIJAUKL/user/riwayat/index.php");
    } else {
        echo "Failed to cancel order: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request.";
}
?>
