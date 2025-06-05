<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';

$username = $_SESSION['email'];

// Ambil ID user dari email
$queryUser = "SELECT ID FROM user WHERE email = '$username'";
$resultUser = mysqli_query($conn, $queryUser);

if (mysqli_num_rows($resultUser) === 0) {
    die("User tidak ditemukan.");
}

$userData = mysqli_fetch_assoc($resultUser);
$IDuser = $userData['ID'];

// Pastikan IDpenjadwalan ada
if (!isset($_GET['IDpenjadwalan'])) {
    die("ID penjadwalan tidak diberikan.");
}

$IDpenjadwalan = (int)$_GET['IDpenjadwalan'];

// Cek penjadwalan milik user & status valid
$queryPenjadwalan = "SELECT status FROM penjadwalan WHERE IDpenjadwalan = $IDpenjadwalan AND ID = $IDuser";
$resultPenjadwalan = mysqli_query($conn, $queryPenjadwalan);

if (mysqli_num_rows($resultPenjadwalan) === 0) {
    die("Penjadwalan tidak ditemukan atau bukan milik Anda.");
}

$statusData = mysqli_fetch_assoc($resultPenjadwalan);
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
                $checkQuery = "SELECT IDpengambilan FROM pengambilan WHERE ID = $IDuser AND IDpenjadwalan = $IDpenjadwalan";
                $resultCheck = mysqli_query($conn, $checkQuery);

                if (mysqli_num_rows($resultCheck) > 0) {
                    $row = mysqli_fetch_assoc($resultCheck);
                    $IDpengambilan = $row['IDpengambilan'];

                    $updateQuery = "UPDATE pengambilan SET status = 'selesai', foto_bukti = '$targetFilePath', tanggal_diambil = '$tanggal' WHERE IDpengambilan = $IDpengambilan";
                    mysqli_query($conn, $updateQuery);
                } else {
                    $insertQuery = "INSERT INTO pengambilan (ID, IDpenjadwalan, status, foto_bukti, tanggal_diambil) VALUES ($IDuser, $IDpenjadwalan, 'selesai', '$targetFilePath', '$tanggal')";
                    mysqli_query($conn, $insertQuery);
                }

                // Update status penjadwalan jadi 'selesai'
                $updatePenjadwalan = "UPDATE penjadwalan SET status = 'selesai' WHERE IDpenjadwalan = $IDpenjadwalan";
                mysqli_query($conn, $updatePenjadwalan);

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
