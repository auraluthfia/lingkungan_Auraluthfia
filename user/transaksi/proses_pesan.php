<?php
session_start();
include '../koneksi.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_POST['submit'])) {
    $IDuser = mysqli_real_escape_string($conn, $_POST['ID']);
    $IDproduk = mysqli_real_escape_string($conn, $_POST['IDproduk']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $metode = mysqli_real_escape_string($conn, $_POST['metode_pengiriman']);

    if (empty($IDuser) || empty($IDproduk) || empty($jumlah) || empty($tanggal)  || empty($metode)) {
        echo "All fields are required.";
        exit();
    }

    if (!is_numeric($jumlah) || $jumlah <= 0) {
        echo "Invalid quantity.";
        exit();
    }

    $query = "SELECT harga FROM produk WHERE IDproduk = '$IDproduk'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Error in query: " . mysqli_error($conn);
        exit();
    }

    if (mysqli_num_rows($result) == 0) {
        echo "Invalid produk ID.";
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $harga = $row['harga'];

    $total_harga = $harga * $jumlah;

    $insertQuery = "INSERT INTO pesanan (ID, IDproduk, jumlah, total, tanggal, metode_pengiriman, status) 
                    VALUES ('$IDuser', '$IDproduk', '$jumlah', '$total_harga', '$tanggal', '$metode','pending')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        header("Location: /SIJAUKL/user/riwayat/index.php");
        exit();
    } else {
        echo "Transaksi gagal: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Tidak ditemukan";
    exit();
}
?>
