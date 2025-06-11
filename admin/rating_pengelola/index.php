<?php
include '../../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href = "rating-pengelola.css">
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
<center><h1>Data Rating</h1><center>
    <table>
    <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Rating</th>
          <th>Feedback</th>
          <th>Action</th>
        </tr>
</thead>
<tbody>
	<?php
            include '../../koneksi.php';
            $query_mysql = mysqli_query($conn, "SELECT rating_pengelola.IDratingolah, user.email, rating_pengelola.rating, rating_pengelola.feedback 
            FROM rating_pengelola
            JOIN user ON rating_pengelola.ID=user.ID") or die(mysqli_error($conn));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td> 
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['rating']; ?></td>
                <td><?php echo $data['feedback']; ?></td>
                <td><a href="proses_hapus.php?id=<?php echo $data['IDratingolah'];  ?>" class="btn-delete" onClick="return confirm('Apakah anda yakin ingin menghapus data tersebut???')">Hapus</a>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        <br>
        <a href="../../login.php" class="btn">Log Out</a>
  </body>
</html>