<?php
include '../../koneksi.php';
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href = "../tambah.css">
  </head>
  <body>
      <center>
        <h1>Tambah Produk</h1>
      <center>
      <form method="POST" action="proses_tambah.php" enctype="multipart/form-data" >
      <section class="base">
        <div>
          <label>Nama Produk</label>
          <input type="text" name="nama_produk" autofocus="" required="" >
        </div>
        <div>
          <label>Deskripsi</label>
         <input type="text" name="deskripsi_produk" required="" >
        </div>
        <div>
          <label>Harga</label>
         <input type="text" name="harga" required="" >
        </div>
        <div>
          <label>Gambar Produk</label>
         <input type="file" name="gambar" required="" >
        </div>
        <div>
         <button type="submit">Simpan Produk</button>
        </div>
        </section>
      </form>
  </body>
</html>