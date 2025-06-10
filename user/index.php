<?php
session_start();
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
    <link rel="stylesheet" href="style-user.css">
</head>
<body>

<!--header section awal-->
<header>
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars">
	</label>
    <a href="#" class="logo"><span>M</span>ijel</a>

    <nav class="navbar">
        <a href="#home">Home</a>
        <a href="#toko">Toko kami</a>
        <a href="#about">Tentang kami</a>
        <a href="#ulasan">Ulasan</a>
	<?php if (isset($_SESSION['ID'])): ?>
        <a href="/SIJAUKL/user/penjadwalan/index.php">Penjadwalan</a>
        <a href="/SIJAUKL/user/riwayat/index.php">Riwayat</a>
    <?php endif; ?>
    </nav>

    <div class="icons">
		<a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell "></i></a>
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>
<!--header section akhir-->

<!--home section awal-->
<section class="home" id="home">
    <div class="content">
        <h3>M<span>IJEL</span></h3>
        <p>Platform Solusi Pengelola dan Pemanfaatan Minyak Jelantah.</p>
        <a href="#toko" class="btn">Klik sekarang untuk belanja</a>
    </div>
	<div class="video-container">
        <video src="/SIJAUKL/user/img/videoukl.mp4" id="video-slider" loop autoplay muted></video>
    </div>
</section>
<!--home section akhir-->

<!--toko section awal-->
<?php
    include 'koneksi.php';
    $query_mysql = mysqli_query($conn, "SELECT * FROM produk") or die(mysqli_error($conn));
    ?>
<section class="toko" id="toko">
	<div class="card-container">
		<?php
            while($row = mysqli_fetch_array($query_mysql)) { 
                $IDproduk = $row['IDproduk'];
                $query_rating = mysqli_query($conn, "SELECT AVG(rating) as average_rating FROM rating_produk WHERE IDpesanan IN (SELECT IDpesanan FROM pesanan WHERE IDproduk='$IDproduk')") or die(mysqli_error($conn));
                $rating_data = mysqli_fetch_array($query_rating);
                $average_rating = $rating_data['average_rating'];
            ?>
			<div class="card">
				<img src="../admin/produk/gambar/<?php echo $row['gambar']; ?>">
				<div class="card-content">
					<h3><?php echo $row ['nama_produk']; ?></h3>
					<h5><?php echo $row['deskripsi_produk']; ?></h5>
					<p><strong>Rp.<?php echo number_format($row['harga'],0,',','.'); ?></strong></p>
			<div class="rating">
                            <?php
                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $average_rating ? '★' : '☆';
                            }
                            ?>
                            <span><?php echo number_format($average_rating,1); ?>/5</span>
                    </div>
				<div class="button">
					<a href="../user/transaksi/index.php?id=<?php echo $row['IDproduk']; ?>" class="btn">Beli Sekarang!</a>
				</div>
			</div>
			</div>
		<?php
		}
		?>
	</div>
</section>
<!--toko section akhir-->
<!--tentang kami section awal-->
<section class = "about" id="about">
<div class="sesi-about">
		<div class="container">
			<div class="title">
				<h1>ABOUT US</h1>
			</div>
			<div class="content">
				<h1>Website ini dirancang untuk membantu masyarakat untuk mengolah minyak jelantah secara bertanggung jawab dan menjual produk hasil pengolahan minyak jelantah dengan harga terjangkau.</h1>
				<h2>VISI</h2>
				<h1>Mewujudkan lingkungan yang lebih bersih dan berkelanjutan melalui pengolahan dan pemanfaatan minyak jelantah secara inovatif dan bertanggung jawab. </h1>
				<h2>MISI</h2>
				<h1>1.Meningkatkan kesadaran masyarakat. </h1>
				<h1>2.Memberikan peluang masyarakat untuk berpartisipasi dalam pengolahan minyak jelantah.</h1>
			</div>
		</div>
			<div class="image">
				<img src="img/about.jpg">
			</div>
</div>
</section>
<!--tentang kami section akhir-->
<!-- ulasan pelanggan section awal -->
<section class="ulasan" id="ulasan">
    <d class="feedback-rating">
        <?php
        include 'koneksi.php';

        // Ambil rata-rata rating semua feedback
        $query_rating = mysqli_query($conn, "SELECT AVG(rating) as average_rating FROM rating_pengelola") or die(mysqli_error($conn));
        $rating_data = mysqli_fetch_array($query_rating);
        $average_rating = $rating_data['average_rating'];
        ?>

        <!-- Judul dan average rating -->
            <h2>Ulasan</h2> <span>
            <div class="rating-ulasan">
                <?php
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $average_rating ? '★' : '☆';
                }
                ?>
				</span>
                <p><span><strong><?php echo number_format($average_rating, 1); ?>/5</strong></span></p>
        </div>

        <?php
        // Ambil data feedback pengguna
        $query_feedback = mysqli_query($conn, "SELECT rating_pengelola.rating, rating_pengelola.feedback, user.email FROM rating_pengelola
            INNER JOIN user ON rating_pengelola.ID = user.ID") or die(mysqli_error($conn));

        if (mysqli_num_rows($query_feedback) > 0) {
            while ($feedback = mysqli_fetch_array($query_feedback)) {
                echo "<div class='feedback-item'>";
                echo "<div class='rating'>";
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $feedback['rating'] ? "★" : "☆";
                }
                echo "</div>";
                echo "<p><strong>Nama Pengguna: </strong>" . $feedback['email'] . "</p>";
                echo "<p><strong>Feedback: </strong>" . $feedback['feedback'] . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Belum ada feedback dan rating untuk produk ini.</p>";
        }
        ?>
    </div>
</section>
<!-- ulasan pelanggan section akhir -->
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
                <li><a href="#ulasan">Ulasan</a></li>
            <?php if (isset($_SESSION['ID'])): ?>
                <li><a href="/SIJAUKL/user/penjadwalan/index.php">Penjadwalan</a></li>
                <li><a href="/SIJAUKL/user/riwayat/index.php">Riwayat</a></li>
            <?php endif; ?>
			</ul>
		</div>
		<div class="footer-content">
			<div class="social-icons">
			<h3>Follow Us</h3>
			<li><a href=""><i class="fab fa-instagram"></i></a></li>
			<li><a href=""><i class="fab fa-github"></i></a></li>
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