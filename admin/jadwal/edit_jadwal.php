<?php
include '../../koneksi.php';
  if (isset($_GET['id'])) {
    $id = ($_GET["id"]);
    $query = "SELECT * FROM jadwal WHERE IDjadwal='$id'";
    $result = mysqli_query($conn, $query);
    if(!$result){
      die ("Query Error: ".mysqli_errno($conn).
         " - ".mysqli_error($conn));
    }
    $data = mysqli_fetch_assoc($result);
       if (!count($data)) {
          echo "<script>alert('Data Jadwal tidak ditemukan pada database');window.location='index.php';</script>";
       }
  } else {
    echo "<script>alert('Masukkan data id.');window.location='index.php';</script>";
  }         
  ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Halaman Admin</title>
    <link rel = "stylesheet" href = "../edit.css">
  </head>
  <body>
      <center>
        <h1>Edit Jadwal</h1>
      <center>
      <form method="POST" action="proses_edit.php" enctype="multipart/form-data" >
      <section class="base">
        <input name="id" value="<?php echo $data['IDjadwal']; ?>"  hidden />
        <div>
          <label>Hari</label>
          <input type="text" name="hari" value="<?php echo $data['hari']; ?>" autofocus="" required="" >
        </div>
        <div>
          <label>Waktu</label>
         <input type="text" name="waktu" value="<?php echo $data['waktu']; ?>" >
        </div>
        <div>
         <button type="submit">Simpan Perubahan</button>
        </div>
        </section>
      </form>
  </body>
</html>