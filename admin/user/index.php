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
<ul class="navbar">
    <a href="/SIJAUKL/admin/user/index.php">User</a>
    <a href="/SIJAUKL/admin/produk/index.php">Produk</a>
    <a href="/SIJAUKL/admin/penjadwalan/index.php">Penjadwalan</a>
    <a href="/SIJAUKL/admin/transaksi_produk/index.php">Transaksi Produk</a>
    <a href="/SIJAUKL/admin/transaksi_pengambilan/index.php">Transaksi Pengambilan</a>
    <a href="/SIJAUKL/admin/rating_produk/index.php">Rating Produk</a>
    <a href="/SIJAUKL/admin/rating_pengambilan/index.php">Rating Pengambilan</a>
</ul>
</header>
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
                <td><?php echo $data['nomorHP']; ?></td>
                <td><?php echo $data['role']; ?></td>
                <td><a href="hapus-user.php?id=<?php echo $data['ID'];  ?>" class="btn-delete" onClick="return confirm('Apakah anda yakin ingin menghapus data tersebut???')">Hapus</a>
                <a href="edit_user.php?id=<?php echo $data['ID']; ?>" class="btn-edit">Edit</a></td>
            </tr>
            <?php } ?>
            </tbody>
        </table>
        </br>
    <a href="../../login.php" class="btn">Log Out</a>
</body>
</html>