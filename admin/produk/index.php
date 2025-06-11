<?php
include '../../koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href = "produkindex.css">
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
<center><h1>Data Produk</h1><center>
    <center><a href="tambah_produk.php" class="btn">+ &nbsp; Tambah Produk</a><center>
    <br/>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Produk</th>
          <th>Dekripsi</th>
          <th>Harga </th>
          <th>Gambar</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
      <?php
      $query = "SELECT * FROM produk ORDER BY IDproduk ASC";
      $result = mysqli_query($conn, $query);
      if(!$result){
        die ("Query Error: ".mysqli_errno($conn).
           " - ".mysqli_error($conn));
      }
      $no = 1; 
      while($row = mysqli_fetch_assoc($result))
      {
      ?>
       <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo $row['nama_produk']; ?></td>
          <td><?php echo substr($row['deskripsi_produk'], 0, 20); ?>...</td>
          <td>Rp <?php echo number_format($row['harga'],0,',','.'); ?></td>
          <td style="text-align: center;"><img src="gambar/<?php echo $row['gambar']; ?>" style="width: 100px  ;"></td>
          <td>
              <a href="edit_produk.php?id=<?php echo $row['IDproduk']; ?>" class="btn-edit">Edit</a>
              <a href="proses_hapus.php?id=<?php echo $row['IDproduk']; ?>" class="btn-delete" onclick="return confirm('Anda yakin akan menghapus data ini?')">Hapus</a>
          </td>
      </tr>
      <?php
        $no++;
      }
      ?>
    </tbody>
    </table>
    </br>
    <a href="../../login.php" class="btn">Log Out</a>
  </body>
</html>