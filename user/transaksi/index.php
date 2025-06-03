<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../koneksi.php';
$user = $_SESSION['email'];

$query = "SELECT * FROM user WHERE email = '$user'";
$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

$userData = mysqli_fetch_assoc($result);
$ID = $userData['ID'];

if (isset($_GET['id'])) {
    $IDproduk = $_GET['id'];
    $query = "
        SELECT produk.IDproduk, produk.nama_produk, produk.harga, produk.gambar 
        FROM produk 
        WHERE produk.IDproduk = '$IDproduk'
    ";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        ?>
<?php

    } ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Transaksi Produk MIJEL</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="transaksi.css">
</head>
<body>
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
    </nav>
     <div class="icons">
		<a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell "></i></a>
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>
<br>

<div class="product-details">
    <h2><?php echo $row['nama_produk']; ?></h2>
  <center><img src="/SIJAUKL/admin/produk/gambar/<?php echo $row['gambar']; ?>" alt="<?php echo $row['nama_produk']; ?>"> </center> 
    <p>Harga:<?php echo number_format($row['harga'],0,',','.'); ?></p>
    <p>Email:<?php echo $userData['email']; ?></p>

    <form action="proses_pesan.php" method="POST">
        <input type="hidden" name="ID" value="<?php echo $ID; ?>">
        <input type="hidden" name="IDproduk" value="<?php echo $row['IDproduk']; ?>">
        <label for="jumlah">Jumlah Pesanan:</label>
        <input type="number" id="jumlah" name="jumlah" value="1" min="1" required>
        <label for="tanggal">Tanggal:</label>
        <input type="date" id="tanggal" name="tanggal" required><br>
        <label for="tanggal">Metode Pengiriman:</label>
        <div class="metode">
            <input type="radio" id="metode_pengiriman" name="metode_pengiriman" value="online"  required><label for="online" title="online">Online</label>
            <input type="radio" id="metode_pengiriman" name="metode_pengiriman" value="offline" required><label for="offline" title="offline">Offline</label>
    </div>
    <br>
        <input type="submit" value="Pesan" name="submit">
    </form>
</div>
<?php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    include '../koneksi.php';
    $query_mysql = mysqli_query($conn, "SELECT * FROM produk WHERE IDproduk='$id'") or die(mysqli_error($conn));
    if ($data = mysqli_fetch_array($query_mysql)) {
        $query_rating = mysqli_query($conn                                                                                                                                                                                                                                   , "SELECT AVG(rating) as average_rating FROM rating_produk WHERE IDpesanan IN (SELECT IDpesanan FROM pesanan WHERE IDproduk='$id')") or die(mysqli_error($mysqli));
        $rating_data = mysqli_fetch_array($query_rating);
        $average_rating = $rating_data['average_rating'];
?>

<div class="container-rating">
<div class="feedback-rating">
        <h2>Ulasan</h2>
        <?php
            $query_feedback = mysqli_query($conn, "SELECT rating_produk.rating, rating_produk.feedback, user.email FROM rating_produk 
            INNER JOIN pesanan ON rating_produk.IDpesanan = pesanan.IDpesanan 
            INNER JOIN user ON pesanan.ID = user.ID WHERE pesanan.IDproduk='$id'") or die(mysqli_error($conn));
            if (mysqli_num_rows($query_feedback) > 0) {
                while ($feedback = mysqli_fetch_array($query_feedback)) {
                    echo "<div class='feedback-item'>";
                    echo "<p><strong>Nama Pengguna: </strong>" . $feedback['email'] . "</p>";
                    echo "<p><strong>Rating: </strong>";
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $feedback['rating']) {
                            echo "★";
                        } else {
                            echo "☆";
                        }
                    }
                    echo "</p>";
                    echo "<p><strong>Feedback: </strong>" . $feedback['feedback'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>Belum ada feedback dan rating untuk produk ini.</p>";
            }
        ?>
    </div>
</div>
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
<!--section footer akhir-->
<?php
    } else {
        echo "<p>produk tidak ditemukan.</p>";
    }
} else {
    echo "<p>ID produk tidak ditemukan.</p>";
}
?>
<?php 
    }?>
</body>
</html>