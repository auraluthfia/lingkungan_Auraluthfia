<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

if (isset($_GET['IDpengambilan'])) {
    $IDpengambilan = $_GET['IDpengambilan'];
} else {
    header("Location: riwayat.php");
    exit();
}

include '../koneksi.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beri Rating</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" href="rating.css">
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
        <a href="/SIJAUKL/user/index.php#ulasan">Ulasan</a>
    </nav>
   <div class="icons">
		<a href="/SIJAUKL/user/penjadwalan/proses.php"><i class="fas fa-bell "></i></a>
        <a href="profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>
<div class="rating-form">
    <h2>Beri Rating Pengambialnmu</h2>
    <form action="simpan_rating.php" method="POST">
        <input type="hidden" name="IDpengambilan" value="<?php echo $IDpengambilan; ?>">
        <div class="rating">
            <input type="radio" id="star5" name="rating" value="5" required><label for="star5" title="5 stars">☆</label>
            <input type="radio" id="star4" name="rating" value="4"><label for="star4" title="4 stars">☆</label>
            <input type="radio" id="star3" name="rating" value="3"><label for="star3" title="3 stars">☆</label>
            <input type="radio" id="star2" name="rating" value="2"><label for="star2" title="2 stars">☆</label>
            <input type="radio" id="star1" name="rating" value="1"><label for="star1" title="1 star">☆</label>
        </div>
        <div>
            <label for="feedback">Ulasan:</label>
            <textarea id="feedback" name="feedback" rows="4" required></textarea>
        </div>
        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
