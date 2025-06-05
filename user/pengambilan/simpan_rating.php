<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';

if (isset($_POST['IDpengambilan']) && isset($_POST['rating']) && isset($_POST['feedback'])) {
    $IDpengambilan = (int)$_POST['IDpengambilan'];
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $feedback = mysqli_real_escape_string($conn, $_POST['feedback']);
    $email = mysqli_real_escape_string($conn, $_SESSION['email']);

    // Ambil ID user dari email
    $queryUser = "SELECT ID FROM user WHERE email = '$email'";
    $resultUser = mysqli_query($conn, $queryUser);

    if ($resultUser && mysqli_num_rows($resultUser) > 0) {
        $userData = mysqli_fetch_assoc($resultUser);
        $userID = $userData['ID'];

        // Cek apakah IDpengambilan valid
        $queryCheck = "SELECT IDpengambilan FROM pengambilan WHERE IDpengambilan = $IDpengambilan";
        $resultCheck = mysqli_query($conn, $queryCheck);

        if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
            // Simpan rating
            $queryInsert = "INSERT INTO rating_pengelola (IDpengambilan, rating, feedback, ID) 
                            VALUES ($IDpengambilan, '$rating', '$feedback', $userID)";
            $resultInsert = mysqli_query($conn, $queryInsert);

            if ($resultInsert) {
                header("Location: /SIJAUKL/user/index.php#ulasan");
                exit();
            } else {
                echo "Gagal memasukkan rating dan feedback: " . mysqli_error($conn);
            }
        } else {
            echo "Transaksi tidak ditemukan.";
        }
    } else {
        echo "Pengguna tidak ditemukan.";
    }
} else {
    echo "Data tidak lengkap.";
}

mysqli_close($conn);
?>
