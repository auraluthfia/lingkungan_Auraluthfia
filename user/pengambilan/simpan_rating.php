<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';

if (isset($_POST['IDpengambilan']) && isset($_POST['rating']) && isset($_POST['feedback'])) {
    $IDpengambilan = $_POST['IDpengambilan'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];
    $email = $_SESSION['email'];

    // Ambil ID user dari email
    $stmt = $conn->prepare("SELECT ID FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userID = $row['ID'];

            // Cek apakah IDpengambilan valid
            $check = $conn->prepare("SELECT IDpengambilan FROM pengambilan WHERE IDpengambilan = ?");
            $check->bind_param("i", $IDpengambilan);

            if ($check->execute()) {
                $result = $check->get_result();
                if ($result->num_rows > 0) {
                    // Simpan rating
                    $insert = $conn->prepare("INSERT INTO rating_pengelola (IDpengambilan, rating, feedback, ID) VALUES (?, ?, ?, ?)");
                    $insert->bind_param("issi", $IDpengambilan, $rating, $feedback, $userID);

                    if ($insert->execute()) {
                        header("Location: /SIJAUKL/user/index.php#ulasan");
                        exit();
                    } else {
                        echo "Gagal memasukkan rating dan feedback.";
                    }

                    $insert->close();
                } else {
                    echo "Transaksi tidak ditemukan.";
                }
            } else {
                echo "Gagal memeriksa IDpengambilan.";
            }

            $check->close();
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    } else {
        echo "Gagal menjalankan query user.";
    }

    $stmt->close();
} else {
    echo "Data tidak lengkap.";
}

$conn->close();
?>
