<?php
include '../../koneksi.php';   
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="profil.css">
    <link rel="stylesheet" href="../style-user.css">
    <title>Halaman Profile</title>
</head>
<body>
<header>
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars">
	</label>
    <a href="#" class="logo"><span>M</span>ijel</a>

    <nav class="navbar">
    <a href="/SIJAUKL/user/index.php">Home</a>
        <a href="/SIJAUKL/user/index.php #toko">Toko kami</a>
        <a href="/SIJAUKL/user/index.php #about">Tentang kami</a>
        <a href="/SIJAUKL/user/riwayat/index.php">Riwayat</a>
        <a href="/SIJAUKL/user/index.php#ulasan">Ulasan</a>
    </nav>
    <div class="icons">
        <a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell"></i></a>
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>

<center>
<section class="profil">
    <h1 class="heading">Profil User</h1>
    <br>
    <?php
    session_start();
    if (!isset($_SESSION['email'])) {
        header("Location: ../../login.php");
        exit();
    }
    
    include '../../koneksi.php';
    $email = $_SESSION['email'];
        $query_mysql = mysqli_query($conn, "SELECT * FROM user WHERE email = '$email'") or die(mysqli_error($conn));
        if ($data = mysqli_fetch_array($query_mysql)) {
    ?>
    <table border="1" class="table">
        <tr>
            <th>Nama</th>
            <td><?php echo $data['nama']; ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?php echo $data['email']; ?></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><?php echo $data['password']; ?></td>
        </tr>
    </table>
    <a href="edit_profil.php?id=<?php echo $data['ID']; ?>" class="btn-edit">Edit Profil</a>
    <?php }
    ?>
    <a href="../../login.php" class="btn-delete">Log Out</a>
</section>
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


