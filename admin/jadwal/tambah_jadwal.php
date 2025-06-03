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
        <h1>Tambah Jadwal</h1>
      <center>
      <form method="POST" action="proses_tambah.php" enctype="multipart/form-data" >
      <section class="base">
        <div>
          <label>Hari</label>
          <input type="text" name="hari" autofocus="" required="" >
        </div>
        <div>
          <label>Waktu</label>
         <input type="time" name="waktu" required="" >
        </div>
        <div>
         <button type="submit">Simpan Jadwal</button>
        </div>
        </section>
      </form>
  </body>
</html>