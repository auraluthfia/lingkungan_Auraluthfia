<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';
$username = $_SESSION['email'];

// Start output buffering
ob_start();

$query = "SELECT ID FROM user WHERE email = '$username'";
$result = mysqli_query($conn, $query);
$userData = mysqli_fetch_assoc($result);
$IDuser = $userData['ID'];
print_r($result);
$query_produk = "
    SELECT pesanan.IDpesanan, produk.nama_produk, pesanan.jumlah, pesanan.total,pesanan.tanggal, pesanan.status, pesanan.metode_pengiriman
    FROM pesanan
    JOIN produk ON pesanan.IDproduk = produk.IDproduk
    WHERE pesanan.ID = '$IDuser'
    ORDER BY pesanan.tanggal DESC
";

$result_produk = mysqli_query($conn, $query_produk);

if (isset($_POST['finish_produk'])) {
    $IDtransaksi = $_POST['IDpesanan'];
    $updateQuery = "UPDATE pesanan SET status = 'successful' WHERE IDpesanan = '$IDtransaksi' AND status = 'pending'";
    mysqli_query($conn, $updateQuery);
    
    header("Location: index.php");
    exit();
}

if (isset($_POST['cancel_produk'])) {
    $IDtransaksi = $_POST['IDpesanan'];
    $updateQuery = "UPDATE pesanan SET status = 'canceled' WHERE IDpesanan = '$IDtransaksi' AND status = 'pending'";
    mysqli_query($conn, $updateQuery);
    
    header("Location: index.php");
    exit();
}
// End output buffering and flush the buffer
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Minyak Jelantah UKL SMK TELKOM SIDOARJO</title>
<!-- font awesome cdn link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<!-- link file css-->
    <link rel="stylesheet" href="../style-user.css">
    <link rel="stylesheet" href="riwayat.css">
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
        <a href="/SIJAUKL/user/penjadwalan/index.php">Penjadwalan</a>
        <a href="/SIJAUKL/user/riwayat/index.php">Riwayat</a>
        <a href="/SIJAUKL/user/index.php#ulasan">Ulasan</a>
    </nav>
    
     <div class="icons">
		<a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell "></i></a>
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>
<!--header section akhir-->


<div class="transaction-history">
    <h2>RIWAYAT PESANAN MIJEL</h2>
    <?php
    function displayprodukTransactions($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class='transaction'>
                    <h3>{$row['nama_produk']}</h3>
                    <p>Jumlah: <span>{$row['jumlah']}</span></p>
                    <p>Total Harga: <span>Rp " . number_format($row['total'], 0, ',', '.') . "</span></p>
                    <p>Tanggal: <span>{$row['tanggal']}</span></p>
                    <p>Status: <span>{$row['status']}</span></p>
                    <p>Pengiriman: <span>{$row['metode_pengiriman']}</span></p>";
                if ($row['status'] == 'pending') {
                    echo "<form method='POST' action=''>
                            <input type='hidden' name='IDpesanan' value='{$row['IDpesanan']}'>
                            <input type='submit' name='finish_produk' value='Selesai' >
                            <input type='submit' name='cancel_produk' value='Batalkan' button class= 'btn-delete'>
                          </form>";
                }
                if ($row['status'] == 'successful') {
                    echo "<a href='/SIJAUKL/user/rating/rating_produk.php?IDpesanan={$row['IDpesanan']}'><button class='rating-btn'>Beri Rating</button></a>";
                }                
                echo "</div>";
            }
        } else {
            echo "<p>Tidak ada Transaksi yang ditemukan.</p>";
        }
    }

    displayprodukTransactions($result_produk);
    ?>
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