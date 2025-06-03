<?php
include '../../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href ="penjadwalan.css">
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
<center><h1>Data Penjadwalan</h1><center>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>hari</th>
          <th>Waktu</th>
          <th>Alamat</th>
          <th>Jumlah</th>
          <th>Tanggal Penjadwalan</th>
          <th>Catatan</th>
          <th>Status</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
	<?php
    include '../../koneksi.php';
    $query_mysql = mysqli_query($conn, "SELECT penjadwalan.IDpenjadwalan, penjadwalan.alamat, penjadwalan.jumlah, user.email, jadwal.IDjadwal, jadwal.hari, jadwal.waktu, penjadwalan.status, penjadwalan.tanggal, penjadwalan.catatan FROM(( penjadwalan
    JOIN jadwal ON penjadwalan.IDjadwal = jadwal.IDjadwal) 
    JOIN user ON penjadwalan.ID=user.ID);
    ") or die(mysqli_error($conn));
    $nomor = 1;
    while($data = mysqli_fetch_array($query_mysql)) { 
    ?>
        <tr>
        <td><?php echo $nomor++; ?></td>
        <td><?php echo $data['email']; ?></td>
        <td><?php echo $data['hari']; ?></td>
        <td><?php echo $data['waktu']; ?></td>
        <td><?php echo $data['alamat']; ?></td>
        <td><?php echo $data['jumlah']; ?></td>
        <td><?php echo $data['tanggal']; ?></td>
        <td><?php echo $data['status']; ?></td>
        <td><?php echo $data['catatan']; ?></td>
        <td>
        <div class="action-buttons">
            <a href="edit_penjadwalan.php?id=<?php echo $data['IDpenjadwalan']; ?>" class="btn-edit">Edit</a>
            <a href="proses_hapus.php?id=<?php echo $data['IDpenjadwalan']; ?>" class="btn-delete" onclick="return confirm('Anda yakin akan menghapus data ini?')">Hapus</a>
        </div>
        </td>   
    </tr>
        <?php } ?>
    </tbody>
</table>
</br>
<a href="../../login.php" class="btn">Log Out</a>
</body>
</html>