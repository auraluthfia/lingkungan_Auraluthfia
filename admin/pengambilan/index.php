<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href = "pengambilan.css">
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
<center><h1>Data Pengambilan</h1><center>
    <br/>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Hari jadwal</th>
          <th>Waktu jadwal</th>
          <th>Foto Bukti</th>
          <th>Tanggal ambil</th>
          <th>Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
include '../../koneksi.php';

$query_mysql = mysqli_query($conn, "SELECT penjadwalan.tanggal,jadwal.hari,jadwal.waktu,pengambilan.IDpengambilan,pengambilan.status,pengambilan.foto_bukti,pengambilan.tanggal_diambil,user.nama 
FROM pengambilan
JOIN penjadwalan ON pengambilan.IDpenjadwalan = penjadwalan.IDpenjadwalan
JOIN jadwal ON penjadwalan.IDjadwal = jadwal.IDjadwal
JOIN user ON pengambilan.ID = user.ID") or die(mysqli_error($conn));

$nomor = 1;
while($data = mysqli_fetch_array($query_mysql)) {
?>
<tr>
    <td><?php echo $nomor++; ?></td>
    <td><?php echo $data['nama']; ?></td>
    <td><?php echo $data['hari']; ?></td>
    <td><?php echo $data['waktu']; ?></td>
    <td>
        <img src="/SIJAUKL/admin/pengambilan/bukti/<?php echo basename($data['foto_bukti']); ?>" alt="Bukti" width="100">

</td>
    <td><?php echo $data['tanggal_diambil']; ?></td>
    <td><?php echo $data['status']; ?></td>
</tr>
<?php } ?>

</tbody>
        </table>
        </br>
    <a href="../../login.php" class="btn">Log Out</a>
</body>
</html>