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

        $allowedTypes = ['image/jpeg', 'image/png'];
        if (!in_array($fileType, $allowedTypes)) {
            $message = "Format file tidak didukung. Gunakan JPG, PNG.";
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
<!-- font awesome cdn link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="pengambilan.css">
    <title>Penjadwalan</title>
   </head>
<body>

<!--header section awal-->
<header>
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars">
	</label>
    <a href="#" class="logo"><span>M</span>ijel</a>

    <nav class="navbar">
    <a href="/SIJAUKL/user/index.php#home">Home</a>
    <a href="/SIJAUKL/user/index.php#toko">Toko kami</a>
    <a href="/SIJAUKL/user/index.php#about">Tentang kami</a>
    <a href="/SIJAUKL/user/index.php#ulasan">Ulasan</a>
    <a href="/SIJAUKL/user/penjadwalan/index.php">Penjadwalan</a>
    <a href="/SIJAUKL/user/riwayat/index.php">Riwayat</a>
    </nav>

    <div class="icons">
		<a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell "></i></a>
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>
<!--header section akhir-->
<main>
    <center><h1>Upload Bukti Pengambilan</h1></center>
    <form action="" method="POST" enctype="multipart/form-data" class="bukti-form">
        <input type="hidden" name="IDpenjadwalan" value="<?= htmlspecialchars($IDpenjadwalan) ?>">
        <label for="foto_bukti">Pilih file bukti (JPG, PNG, max 5MB):</label><br>
        <input type="file" name="foto_bukti" id="foto_bukti" accept=".jpg,.jpeg,.png,.pdf" required><br><br>
        <input type="submit" name="submit_bukti" value="Upload Bukti" class="btn-up">
    </form>
</main>
<!--footer section awal -->
<footer>
	<div class="footer">
		<div class="footer-content">
			<h3>Contact Us</h3>
			<p>Email:aurelukltelkom1@gmail.com</p>
			<p>Phone:+62 881-0360-11635</p>
			<p>Address: SMK Telkom Sidoarjo</p>
		</div>
		<div class="footer-content">
			<h3>Quick Links</h3>
			<ul class="list">
				<li><a href="/SIJAUKL/user/index.php#home">Home</a></li>
				<li><a href="/SIJAUKL/user/index.php#toko">Toko Kami</a></li>
				<li><a href="/SIJAUKL/user/index.php#about">Tentang Kami</a></li>
                <li><a href="/SIJAUKL/user/index.php#ulasan">Ulasan</a></li>
                <li><a href="/SIJAUKL/user/penjadwalan/index.php">Penjadwalan</a></li>
                <li><a href="/SIJAUKL/user/riwayat/index.php">Riwayat</a></li>
			</ul>
		</div>
		<div class="footer-content">
			<div class="social-icons">
			<h3>Follow Us</h3>
			<li><a href=""><i class="fab fa-instagram"></i></a></li>
			<li><a href="https://github.com/auraluthfia"><i class="fab fa-github"></i></a></li>
			<li><a href=""><i class="fab fa-linkedin"></i></a></li>
		</div>
	</div>
	</div>
	<div class="bottom-bar">
		<p>Created By Aura Luthfia &copy; 2025</p>
	</div>
</footer>
<!--section footer akhir-->
</body>
</html>
