<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href = "jadwal.css">
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
<center><h1>Data Jadwal</h1><center>
    <center><a href="tambah_jadwal.php" class="btn">+ &nbsp; Tambah Jadwal</a><center>
    <br/>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Waktu</th>
          <th>Hari</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
	<?php
            include '../../koneksi.php';
            $query_mysql = mysqli_query($conn, "SELECT * FROM jadwal") or die(mysqli_error($conn));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['waktu']; ?></td>
                <td><?php echo $data['hari']; ?></td>
                <td><a href="edit_jadwal.php?id=<?php echo $data['IDjadwal']; ?>" class="btn-edit">Edit</a>
                <a href="proses_hapus.php?id=<?php echo $data['IDjadwal'];  ?>" class="btn-delete" onClick="return confirm('Apakah anda yakin ingin menghapus data tersebut???')">Hapus</a></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </br>
    <a href="../../login.php" class="btn">Log Out</a>
</body>
</html>