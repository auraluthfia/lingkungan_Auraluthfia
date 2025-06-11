<?php 
session_start();
include '../koneksi.php'; 

if (!isset($_SESSION['email'])) {
    header('Location: ../../login.php');
    exit();
}

$email = $_SESSION['email'];
$queryUser = "SELECT ID FROM user WHERE email = '$email'";
$resultUser = mysqli_query($conn, $queryUser);

if (mysqli_num_rows($resultUser) === 0) {
    die("User tidak ditemukan.");
}

$userData = mysqli_fetch_assoc($resultUser);
$IDuser = $userData['ID'];
$message = '';
$inserted_order = false;

$id_pesanan = $_POST['IDpesanan'] ?? ($_GET['IDpesanan'] ?? null);
$id_produk = $_GET['IDproduk'] ?? null;

if (!$id_pesanan) {
    header('Location: /SIJAUKL/transaksi/index.php?error=invalid_id_transaksi');
    exit();
}

$stmt = $conn->prepare("SELECT * FROM pembayaran WHERE IDpesanan = ? AND ID = ?");
$stmt->bind_param("ii", $id_pesanan, $IDuser);
$stmt->execute();
$result = $stmt->get_result();
$pesanan = $result->fetch_assoc();
$stmt->close();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['bukti_pembayaran'])) {
    if ($pesanan && $pesanan['bukti_pembayaran']) {
        $message = 'Bukti pembayaran sudah diunggah.';
    } else {
        $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/SIJAUKL/admin/pembayaran/img_bukti/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        $file = $_FILES['bukti_pembayaran'];
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        $maxFileSize = 5 * 1024 * 1024;

        if ($file['error'] === UPLOAD_ERR_OK) {
            if (in_array($file['type'], $allowedTypes)) {
                if ($file['size'] <= $maxFileSize) {
                    $fileName = uniqid('bukti_') . '_' . preg_replace("/[^A-Za-z0-9_.-]/", '', basename($file['name']));
                    $targetFile = $uploadDir . $fileName;

                    if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                        if ($pesanan) {
                            $stmt = $conn->prepare("UPDATE pembayaran SET bukti_pembayaran = ? WHERE IDpesanan = ? AND ID = ?");
                            $stmt->bind_param("sii", $fileName, $id_pesanan, $IDuser);
                            if ($stmt->execute()) {
                                $message = 'Bukti pembayaran berhasil diunggah dan pesanan Anda telah diproses.';
                                $inserted_order = true;
                                $pesanan['bukti_pembayaran'] = $fileName; // update manual agar JS deteksi
                            } else {
                                $message = 'Gagal memperbarui bukti pembayaran: ' . $conn->error;
                            }
                            $stmt->close();
                        } else {
                            $stmt = $conn->prepare("INSERT INTO pembayaran (IDpesanan, bukti_pembayaran, ID, IDproduk) VALUES (?, ?, ?, ?)");
                            $stmt->bind_param("isii", $id_pesanan, $fileName, $IDuser, $id_produk);
                            if ($stmt->execute()) {
                                $message = 'Bukti pembayaran berhasil diunggah dan pesanan Anda telah diproses.';
                                $inserted_order = true;
                                $pesanan['bukti_pembayaran'] = $fileName;
                            } else {
                                $message = 'Gagal menyimpan bukti pembayaran: ' . $conn->error;
                            }
                            $stmt->close();
                        }
                    } else {
                        $message = 'Gagal mengunggah file.';
                    }
                } else {
                    $message = 'Ukuran file terlalu besar. Maksimal 5MB.';
                }
            } else {
                $message = 'Tipe file tidak diizinkan. Hanya JPG, PNG, GIF yang diperbolehkan.';
            }
        } else {
            $message = 'Terjadi kesalahan saat mengunggah file.';
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['finish_pesanan'])) {
    $status = 'successful';
    $stmt = $conn->prepare("UPDATE pembayaran SET status = ? WHERE IDpesanan = ? AND ID = ?");
    $stmt->bind_param("sii", $status, $id_pesanan, $IDuser);
    $stmt->execute();
    $stmt->close();

    header('Location: /SIJAUKL/user/riwayat/index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Transaksi</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../style-user.css">
    <link rel="stylesheet" href="css/transaksi.css" />
</head>
<body>
<header>
    <input type="checkbox" id="toggler">
    <label for="toggler" class="fas fa-bars"></label>
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
        <a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell"></i></a>
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user"></i></a>
    </div>
</header>

<div class="payment-container">
    <img src="/SIJAUKL/user/img/qris.png" alt="qris" />
    <p>Silahkan scan untuk membayar pesanan anda</p>

    <?php if ($message): ?>
        <p class="upload-message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if (!$pesanan || !$pesanan['bukti_pembayaran']): ?>
        <form action="transaksi.php?IDpesanan=<?= htmlspecialchars($id_pesanan) ?>&IDproduk=<?= htmlspecialchars($id_produk) ?>" method="post" enctype="multipart/form-data">
            <label for="bukti_pembayaran">Unggah bukti pembayaran (screenshot):</label><br/>
            <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*" required />
            <button type="submit">Kirim Bukti Pembayaran</button>
        </form>
    <?php else: ?>
        <div class="thankyou-box">
            <h2>Terima kasih atas pembelian Anda!</h2>
        </div>
    <?php endif; ?>

    <br>

    <div class="button-wrapper">
        <form method="POST" action="" id="finishForm">
            <a href="/SIJAUKL/user/transaksi/index.php?id=<?= htmlspecialchars($id_produk) ?>" class="btn-batal">Batalkan</a>
            <input type="hidden" name="id_pesanan" value="<?= htmlspecialchars($id_pesanan) ?>">
            <button type="submit" name="finish_pesanan" class="btnSelesai" id="btnSelesai">Selesai</button>
        </form>
    </div>
</div>

<footer>
    <div class="footer">
        <div class="footer-content">
            <h3>Contact Us</h3>
            <p>Email: aurelukltelkom1@gmail.com</p>
            <p>Phone: +62 881-0360-11635</p>
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
                <li><a href=""><i class="fab fa-tiktok"></i></a></li>
                <li><a href=""><i class="fab fa-linkedin"></i></a></li>
            </div>
        </div>
    </div>
    <div class="bottom-bar">
        <p>Created By Aura Luthfia &copy; 2025</p>
    </div>
</footer>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const btnSelesai = document.getElementById('btnSelesai');
    const buktiSudahAda = <?= ($pesanan && !empty($pesanan['bukti_pembayaran'])) ? 'true' : 'false' ?>;

    // Jika belum ada bukti, nonaktifkan tombol selesai
    if (!buktiSudahAda) {
        btnSelesai.disabled = true;
        btnSelesai.style.opacity = 0.6;
        btnSelesai.style.cursor = 'not-allowed';

        btnSelesai.addEventListener('click', function (e) {
            e.preventDefault();
            alert('Silakan kirim bukti pembayaran terlebih dahulu sebelum menekan tombol Selesai.');
        });
    }
});
</script>

</body>
</html>
