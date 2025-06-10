<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../../koneksi.php';

// Ambil email dari session
$email = $_SESSION['email'];

// Ambil ID user berdasarkan email
$result = $conn->query("SELECT ID FROM user WHERE email = '$email'");
if ($result->num_rows === 0) {
    die("User tidak ditemukan.");
}
$row = $result->fetch_assoc();
$id_user = $row['ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penjadwalan = $_POST['IDpenjadwalan'];
    $jadwal = $_POST['IDjadwal'];
    $alamat = $_POST['alamat'];
    $tanggal = $_POST['tanggal'];   
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['catatan'];
    $sql = "INSERT INTO penjadwalan (IDpenjadwalan, IDjadwal, alamat, tanggal, jumlah, catatan, ID)
    VALUES ('$penjadwalan', '$jadwal', '$alamat', '$tanggal', '$jumlah', '$deskripsi', '$id_user')";   

    if ($conn->query($sql) === TRUE) {
        header("Location: /SIJAUKL/user/penjadwalan/proses.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <!-- font awesome cdn link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="penjadwalan.css">
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

    <div class="container">
        <h1>Penjadwalan</h1>
        <form method="POST">
            <!-- ID user tidak perlu ditampilkan karena sudah dari session -->
            
            <label for="IDjadwal">Pilih jadwal:</label>
            <select name="IDjadwal" required>
                <option value="">-- Pilih Jadwal --</option>
                <?php
                $jadwal = $conn->query("SELECT IDjadwal, hari, waktu FROM jadwal");
                while ($w = $jadwal->fetch_assoc()) {
                    echo "<option value='{$w['IDjadwal']}'>{$w['hari']} - {$w['waktu']}</option>";
                }
                ?>
            </select>
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>
            <label for="alamat">Alamat:</label>
            <input type="text" name="alamat" required>
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" required min="1">
            <label for="catatan">Catatan:</label>
            <input type="text" name="catatan" required>
            <!-- IDpenjadwalan jika dibutuhkan -->
            <input type="hidden" name="IDpenjadwalan" value="<?php echo uniqid('PJ-'); ?>">
            <button type="submit">Simpan</button>
            <button type="button" onclick="window.history.back();" style="background-color: #777; margin-top: 10px;">Back</button>
        </form>
    </div>
    <br>
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
