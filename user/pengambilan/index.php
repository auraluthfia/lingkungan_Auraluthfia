<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';

$username = $_SESSION['email'];

$queryUser = "SELECT ID FROM user WHERE email = ?";
$stmtUser = $conn->prepare($queryUser);
$stmtUser->bind_param("s", $username);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows === 0) {
    die("User tidak ditemukan.");
}

$userData = $resultUser->fetch_assoc();
$IDuser = $userData['ID'];

if (!isset($_GET['IDpenjadwalan'])) {
    die("ID penjadwalan tidak diberikan.");
}

$IDpenjadwalan = (int)$_GET['IDpenjadwalan'];

// Cek penjadwalan milik user & status pending atau pengambilan
$queryPenjadwalan = "SELECT status FROM penjadwalan WHERE IDpenjadwalan = ? AND ID = ?";
$stmtPenjadwalan = $conn->prepare($queryPenjadwalan);
$stmtPenjadwalan->bind_param("ii", $IDpenjadwalan, $IDuser);
$stmtPenjadwalan->execute();
$resultPenjadwalan = $stmtPenjadwalan->get_result();

if ($resultPenjadwalan->num_rows === 0) {
    die("Penjadwalan tidak ditemukan atau bukan milik Anda.");
}

$statusData = $resultPenjadwalan->fetch_assoc();
$status = $statusData['status'];

if (!in_array($status, ['pending', 'pengambilan'])) {
    die("Status penjadwalan ini bukan 'pending' atau 'pengambilan'.");
}

$message = '';

// Proses upload bukti
if (isset($_POST['submit_bukti'])) {
    if (isset($_FILES['foto_bukti']) && $_FILES['foto_bukti']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['foto_bukti']['tmp_name'];
        $fileName = basename($_FILES['foto_bukti']['name']);
        $fileSize = $_FILES['foto_bukti']['size'];
        $fileType = $_FILES['foto_bukti']['type'];

        $uploadDir = '../../admin/pengambilan/bukti/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $newFileName = time() . '_' . preg_replace("/[^a-zA-Z0-9\.]/", "_", $fileName);
        $targetFilePath = $uploadDir . $newFileName;

        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        if (!in_array($fileType, $allowedTypes)) {
            $message = "Format file tidak didukung. Gunakan JPG, PNG, atau PDF.";
        } elseif ($fileSize > 5 * 1024 * 1024) {
            $message = "Ukuran file terlalu besar. Maksimal 5MB.";
        } else {
            if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
                $tanggal = date('Y-m-d H:i:s');

                // Cek apakah sudah ada record pengambilan
                $checkQuery = "SELECT IDpengambilan FROM pengambilan WHERE ID = ? AND IDpenjadwalan = ?";
                $stmtCheck = $conn->prepare($checkQuery);
                $stmtCheck->bind_param("ii", $IDuser, $IDpenjadwalan);
                $stmtCheck->execute();
                $resultCheck = $stmtCheck->get_result();

                if ($resultCheck->num_rows > 0) {
                    $row = $resultCheck->fetch_assoc();
                    $IDpengambilan = $row['IDpengambilan'];

                    $updateQuery = "UPDATE pengambilan SET status = 'selesai', foto_bukti = ?, tanggal_diambil = ? WHERE IDpengambilan = ?";
                    $stmtUpdate = $conn->prepare($updateQuery);
                    $stmtUpdate->bind_param("ssi", $targetFilePath, $tanggal, $IDpengambilan);
                    $stmtUpdate->execute();
                } else {
                    $insertQuery = "INSERT INTO pengambilan (ID, IDpenjadwalan, status, foto_bukti, tanggal_diambil) VALUES (?, ?, 'selesai', ?, ?)";
                    $stmtInsert = $conn->prepare($insertQuery);
                    $stmtInsert->bind_param("iiss", $IDuser, $IDpenjadwalan, $targetFilePath, $tanggal);
                    $stmtInsert->execute();
                }

                // Update status penjadwalan jadi 'selesai'
                $updatePenjadwalan = "UPDATE penjadwalan SET status = 'selesai' WHERE IDpenjadwalan = ?";
                $stmtPenjadwalanUpdate = $conn->prepare($updatePenjadwalan);
                $stmtPenjadwalanUpdate->bind_param("i", $IDpenjadwalan);
                $stmtPenjadwalanUpdate->execute();

                header("Location: /SIJAUKL/user/penjadwalan/proses.php");
                exit();

            } else {
                $message = "Terjadi kesalahan saat upload file.";
            }
        }
    } else {
        $message = "File bukti harus diupload.";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Upload Bukti Pengambilan - Minyak Jelantah UKL</title>
    <link rel="stylesheet" href="../style-user.css" />
    <link rel="stylesheet" href="pengambilan.css" />
</head>
<body>
<main>
    <center><h1>Upload Bukti Pengambilan</h1></center>
    <?php if ($message): ?>
        <p style="color: red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form action="" method="POST" enctype="multipart/form-data" class="bukti-form">
        <input type="hidden" name="IDpenjadwalan" value="<?= htmlspecialchars($IDpenjadwalan) ?>">
        <label for="foto_bukti">Pilih file bukti (JPG, PNG, PDF, max 5MB):</label><br>
        <input type="file" name="foto_bukti" id="foto_bukti" accept=".jpg,.jpeg,.png,.pdf" required><br><br>
        <button type="submit" name="submit_bukti">Upload Bukti</button>
    </form>
</main>
</body>
</html>
