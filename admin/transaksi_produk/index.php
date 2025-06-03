<?php
include '../../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href ="transaksi-produk.css">
</head>
<body>
<header>
<nav class="navbar">
    <a href="/SIJAUKL/admin/user/index.php">User</a>
    <a href="/SIJAUKL/admin/produk/index.php">Produk</a>
    <a href="/SIJAUKL/admin/jadwal/index.php">Jadwal</a>
    <a href="/SIJAUKL/admin/penjadwalan/index.php">Penjadwalan</a>
    <a href="/SIJAUKL/admin/pengambilan/index.php">Pengambilan</a>
    <a href="/SIJAUKL/admin/transaksi_produk/index.php">Transaksi Produk</a>
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
          <th>Tanggal</th>
          <th>Jumlah</th>
          <th>Total</th>
          <th>Status</th>
          <th>Pengiriman</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
	<?php
    include '../../koneksi.php';
    $query_mysql = mysqli_query($conn, "SELECT pesanan.IDpesanan, produk.nama_produk, pesanan.total, user.email, pesanan.jumlah, pesanan.tanggal, pesanan.status, pesanan.metode_pengiriman FROM(( pesanan
    JOIN produk ON pesanan.IDproduk=produk.IDproduk) 
    JOIN user ON pesanan.ID=user.ID);
    ") or die(mysqli_error($conn));
    $nomor = 1;
    while($data = mysqli_fetch_array($query_mysql)) { 
    ?>
        <tr>
        <td><?php echo $nomor++; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td><?php echo $data['nama_produk']; ?></td>
        <td><?php echo $data['tanggal']; ?></td>
        <td><?php echo $data['jumlah']; ?></td>
        <td><?php echo number_format($data['total'],0,',','.'); ?></td>
        <td><?php echo $data['status']; ?></td>
        <td><?php echo $data['metode_pengiriman']?></td>
        <td>
              <a href="edit_transaksi.php?id=<?php echo $data['IDpesanan']; ?>" class="btn-edit">Edit</a>
              <a href="proses_hapus.php?id=<?php echo $data['IDpesanan']; ?>" class="btn-delete" onclick="return confirm('Anda yakin akan menghapus data ini?')">Hapus</a>
          </td>    
    </tr>
        <?php } ?>
    </tbody>
</table>
</br>
<a href="../../login.php" class="btn">Log Out</a>
</body>
</html>