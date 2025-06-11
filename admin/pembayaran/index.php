<?php
include '../../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href ="pembayaran.css">
</head>
<body>
<header>
<nav class="navbar">
    <a href="/SIJAUKL/admin/user/index.php">User</a>
    <a href="/SIJAUKL/admin/produk/index.php">Produk</a>
    <a href="/SIJAUKL/admin/jadwal/index.php">Jadwal</a>
    <a href="/SIJAUKL/admin/penjadwalan/index.php">Penjadwalan</a>
    <a href="/SIJAUKL/admin/pengambilan/index.php">Pengambilan</a>
    <a href="/SIJAUKL/admin/transaksi_produk/index.php">Pesanan</a>
    <a href="/SIJAUKL/admin/pembayaran/index.php">Transaksi</a>
    <a href="/SIJAUKL/admin/rating_produk/index.php">Rating Produk</a>
    <a href="/SIJAUKL/admin/rating_pengelola/index.php">Rating Olah</a>
</nav>
</header>
<br>
<br>
<center><h1>Data Transaksi</h1><center>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Produk</th>
          <th>Tanggal Pesan</th>
          <th>Bukti Pembayaran</th>
          <th>Status</th>
        </tr>
    </thead>
    <tbody>
	<?php
    include '../../koneksi.php';
    $query_mysql = mysqli_query($conn, "SELECT pembayaran.IDtransaksi, produk.nama_produk, user.email, pesanan.tanggal, pesanan.status, pembayaran.bukti_pembayaran FROM(( pembayaran
    JOIN produk ON pembayaran.IDproduk=produk.IDproduk
    JOIN pesanan ON pembayaran.IDpesanan=pesanan.IDpesanan) 
    JOIN user ON pembayaran.ID=user.ID);
    ") or die(mysqli_error($conn));
    $nomor = 1;
    while($data = mysqli_fetch_array($query_mysql)) { 
    ?>
        <tr>
        <td><?php echo $nomor++; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td><?php echo $data['nama_produk']; ?></td>
        <td><?php echo $data['tanggal']; ?></td>
        <td style="text-align: center;"><img src="img_bukti/<?php echo $data['bukti_pembayaran']; ?>" style="width: 100px  ;"></td>
        <td><?php echo $data['status']; ?></td>
    </tr>
        <?php } ?>
    </tbody>
</table>
</br>
<a href="../../login.php" class="btn">Log Out</a>
</body>
</html>