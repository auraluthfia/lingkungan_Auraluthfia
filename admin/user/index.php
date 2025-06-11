<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href = "userindex.css">
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
<center><h1>Data Pengguna</h1><center>
    <center><a href="../../register.php" class="btn">+ &nbsp; Tambah Pengguna</a><center>
    <br/>
    <table>
      <thead>
        <tr>
          <th>No</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Password</th>
          <th>Nomor handphone</th>
          <th>Role</th>
          <th>Action</th>
        </tr>
    </thead>
    <tbody>
	<?php
            include '../../koneksi.php';
            $query_mysql = mysqli_query($conn, "SELECT * FROM user") or die(mysqli_error($conn));
            $nomor = 1;
            while($data = mysqli_fetch_array($query_mysql)) { 
            ?>
            <tr>
                <td><?php echo $nomor++; ?></td>
                <td><?php echo $data['nama']; ?></td>
                <td><?php echo $data['email']; ?></td>
                <td><?php echo $data['password']; ?></td>
                <td><?php echo str_pad($data['nomorHP'], 10, "0", STR_PAD_LEFT); ?></td> <!--memaksa untuk menambahkan 0 -->
                <td><?php echo $data['role']; ?></td>
                <td><a href="edit_user.php?id=<?php echo $data['ID']; ?>" class="btn-edit">Edit</a>
                <a href="hapus_user.php?id=<?php echo $data['ID'];  ?>" class="btn-delete" onClick="return confirm('Apakah anda yakin ingin menghapus data tersebut???')">Hapus</a></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </br>
    <a href="../../login.php" class="btn">Log Out</a>
</body>
</html>