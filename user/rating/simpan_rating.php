<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';

if (isset($_POST['IDpesanan']) && isset($_POST['rating']) && isset($_POST['feedback'])) {
    $IDtransaksi = $_POST['IDpesanan'];
    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];
    $username = $_SESSION['email'];

    // Ambil ID pengguna berdasarkan username
    $stmt = $conn->prepare("SELECT ID FROM user WHERE email = ?");
    $stmt->bind_param("s", $username);
    
    // Eksekusi pernyataan
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $userID = $row['ID'];

            // Ambil IDproduk berdasarkan IDtransaksi_produk
            $stmt = $conn->prepare("SELECT IDproduk FROM pesanan WHERE IDpesanan = ?");
            $stmt->bind_param("s", $IDtransaksi);

            if ($stmt->execute()) {
                $result = $stmt->get_result();
                if ($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    $IDproduk = $row['IDproduk'];

                    // Masukkan rating dan feedback
                    $insertStmt = $conn->prepare("INSERT INTO rating_produk (IDpesanan, IDproduk, rating, feedback, ID) VALUES (?, ?, ?, ?, ?)");
                    $insertStmt->bind_param("sisss", $IDtransaksi, $IDproduk, $rating, $feedback, $userID);

                    if ($insertStmt->execute()) {
                        header("Location: /SIJAUKL/user/riwayat/index.php");
                        exit();
                    } else {
                        echo "Gagal memasukkan rating dan feedback.";
                    }
                } else {
                    echo "Transaksi yang sesuai tidak ditemukan.";
                }
            } else {
                echo "Gagal menjalankan kueri.";
            }
        } else {
            echo "Pengguna tidak ditemukan.";
        }
    } else {
        echo "Gagal menjalankan kueri.";
    }

    $stmt->close();
} else {
    echo "Data tidak lengkap.";
}

$conn->close();
?>
