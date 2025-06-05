<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';
$username = $_SESSION['email'];

$query = "SELECT ID FROM user WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
$IDuser = $userData['ID'];

// Proses pembatalan penjadwalan
if (isset($_POST['cancel_penjadwalan'])) {
    $IDpenjadwalan = $_POST['IDpenjadwalan'];
    $cancelQuery = "UPDATE penjadwalan SET status = 'canceled' WHERE IDpenjadwalan = ? AND status IN ('pending', 'pengambilan')";
    $stmt_cancel = $conn->prepare($cancelQuery);
    $stmt_cancel->bind_param("i", $IDpenjadwalan);
    $stmt_cancel->execute();
    
    header("Location: proses.php");
    exit();
}

// Ambil data penjadwalan
$query_penjadwalan = "
    SELECT p.IDpenjadwalan, p.alamat, p.jumlah, p.status, p.tanggal, p.catatan,
           j.hari, j.waktu, u.email
    FROM penjadwalan p
    JOIN jadwal j ON p.IDjadwal = j.IDjadwal
    JOIN user u ON p.ID = u.ID
    WHERE p.ID = ?
    ORDER BY p.tanggal DESC
";
$stmt_penjadwalan = $conn->prepare($query_penjadwalan);
$stmt_penjadwalan->bind_param("i", $IDuser);
$stmt_penjadwalan->execute();
$result_penjadwalan = $stmt_penjadwalan->get_result();
?>

<!-- HTML start -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Penjadwalan - Minyak Jelantah UKL</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="../style-user.css" />
    <link rel="stylesheet" href="proses.css" />
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
    <a href="/SIJAUKL/user/penjadwalan/index.php">Penjadwalan</a>
    <a href="/SIJAUKL/user/riwayat/index.php">Riwayat</a>
    <a href="/SIJAUKL/user/index.php#ulasan">Ulasan</a>
</nav>
<div class="icons">
    <a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell"></i></a>
    <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
</div>
</header>

<div class="transaction-history">
    <h2>Penjadwalan dan Pengambilan Minyak</h2>
    <?php if (mysqli_num_rows($result_penjadwalan) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($result_penjadwalan)): ?>
        <?php
            // Ambil IDpengambilan dari tabel pengambilan berdasar IDpenjadwalan
            $IDpenjadwalan = (int)$row['IDpenjadwalan'];
            $query_pengambilan = "SELECT IDpengambilan FROM pengambilan WHERE IDpenjadwalan = $IDpenjadwalan";
            $result_pengambilan = mysqli_query($conn, $query_pengambilan);
            $row_pengambilan = mysqli_fetch_assoc($result_pengambilan);
            $IDpengambilan = $row_pengambilan['IDpengambilan'] ?? null;
        ?>
        <div class='transaction'>
            <p>Email: <span><?= htmlspecialchars($row['email']) ?></span></p>
            <p>Jumlah: <span><?= htmlspecialchars($row['jumlah']) ?></span></p>
            <p>Alamat: <span><?= htmlspecialchars($row['alamat']) ?></span></p>
            <p>Tanggal: <span><?= htmlspecialchars($row['tanggal']) ?></span></p>
            <p>Status: <span><?= htmlspecialchars($row['status']) ?></span></p>
            <p>Catatan: <span><?= htmlspecialchars($row['catatan']) ?></span></p>

            <?php if ($row['status'] === 'pending'): ?>
                <a href="/SIJAUKL/user/pengambilan/index.php?IDpenjadwalan=<?= $row['IDpenjadwalan'] ?>">
                    <button class='input-btn'>Input Bukti</button>
                </a>
            <?php elseif ($row['status'] === 'selesai' && $IDpengambilan): ?>
                <p><strong>Status selesai.</strong> Terima kasih!</p>
                <a href="/SIJAUKL/user/pengambilan/rating_pengelola.php?IDpengambilan=<?= $IDpengambilan ?>">
                    <button class='rating-btn'>Beri Rating</button>
                </a>
            <?php elseif ($row['status'] === 'canceled'): ?>
                <p><em>Penjadwalan dibatalkan</em></p>
            <?php endif ?>

            <?php if (in_array($row['status'], ['pending', 'pengambilan'])): ?>
                <form method="POST" action="">
                    <input type="hidden" name="IDpenjadwalan" value="<?= $row['IDpenjadwalan'] ?>">
                    <input type="submit" name="cancel_penjadwalan" value="Batalkan" class="btn-delete" onclick="return confirm('Yakin ingin membatalkan penjadwalan ini?');">
                </form>
            <?php endif; ?>
        </div>
    <?php endwhile; ?>
<?php else: ?>
    <p>Belum ada penjadwalan.</p>
<?php endif; ?>

</div>

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
                <li><a href="#home">Home</a></li>
                <li><a href="#toko">Toko Kami</a></li>
                <li><a href="#about">Tentang Kami</a></li>
                <li><a href="">Riwayat</a></li>
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
</body>
</html>
