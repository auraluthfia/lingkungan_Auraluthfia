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
    $metode = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    if (empty($IDuser) || empty($IDproduk) || empty($jumlah) || empty($tanggal) || empty($metode) || empty($alamat)) {
        echo "Semua field harus diisi.";
        exit();
    }

    if (!is_numeric($jumlah) || $jumlah <= 0) {
        echo "Jumlah tidak valid.";
        exit();
    }

    $query = "SELECT harga FROM produk WHERE IDproduk = '$IDproduk'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        echo "Query error: " . mysqli_error($conn);
        exit();
    }

    if (mysqli_num_rows($result) == 0) {
        echo "Produk tidak ditemukan.";
        exit();
    }

    $row = mysqli_fetch_assoc($result);
    $harga = $row['harga'];

    $total_harga = $harga * $jumlah;

    $insertQuery = "INSERT INTO pesanan (ID, IDproduk, jumlah, total, tanggal, metode_pembayaran,alamat, status) 
                    VALUES ('$IDuser', '$IDproduk', '$jumlah', '$total_harga', '$tanggal', '$metode','$alamat','pending')";
    $insertResult = mysqli_query($conn, $insertQuery);

    if ($insertResult) {
        $IDpesanan_baru = mysqli_insert_id($conn);
        header("Location: /SIJAUKL/user/pembayaran/transaksi.php?IDpesanan=$IDpesanan_baru&IDproduk=$IDproduk");
        exit();
    } else {
        echo "Transaksi gagal: " . mysqli_error($conn);
        exit();
    }
} else {
    echo "Permintaan tidak valid.";
    exit();
}
