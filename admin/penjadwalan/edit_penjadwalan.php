<?php

include '../../koneksi.php';
if (isset($_GET['id'])) {

    $id = ($_GET["id"]);
    $query = "SELECT penjadwalan.IDpenjadwalan, penjadwalan.alamat, penjadwalan.jumlah, penjadwalan.tanggal, penjadwalan.catatan,penjadwalan.status,user.email,jadwal.hari,jadwal.waktu, penjadwalan.status
    FROM penjadwalan
    JOIN jadwal ON penjadwalan.IDjadwal = jadwal.IDjadwal
    JOIN user ON penjadwalan.ID = user.ID
    WHERE penjadwalan.IDpenjadwalan = '$id'";

    $result = mysqli_query($conn, $query);
    if(!$result){
      die ("Query Error: ".mysqli_errno($conn).
         " - ".mysqli_error($conn));
    }
    $data = mysqli_fetch_assoc($result);
       if (!count($data)) {
          echo "<script>alert('Data tidak ditemukan pada database');window.location='index.php';</script>";
       }
  } else {

    echo "<script>alert('Masukkan data id.');window.location='index.php';</script>";
  }         
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../edit.css">
    <title>Halaman Admin</title>
</head>
<body>
<center>
        <h1>Edit Pengambilan <?php echo $data['email']; ?></h1>
      <center>
      <form method="POST" action="proses_edit.php" enctype="multipart/form-data" >
      <section class="base">
        <input type="hidden" name="id" value="<?php echo $data['IDpenjadwalan']; ?>" />
        <div>
          <label>Nama </label>
          <?php echo $data['email']; ?>
        </div>
        <div>
          <label>Hari</label>
        <?php echo $data['hari'];?>
        </div>
        <div>
          <label>Waktu</label>
        <?php echo $data['waktu'];?>
        </div>
         <div>
          <label>Tanggal</label>
         <?php echo $data['tanggal'];?>
        </div>
        <div>
        <label>Jumlah</label>
         <?php echo $data['jumlah']; ?>
        </div>
        <label>Catatan</label>
        <?php echo $data['catatan'];?>
        </div>
        <div>
          <label for="status">Status</label>
          <select name="status" required>
           <option disabled selected><?php echo $data['status']; ?></option>
          <option value="canceled">canceled</option>
          <option value="selesai">selesai</option>
        </select>
        </div>
        <div>
         <button type="submit" name="simpan" value="simpan">Simpan Perubahan</button>
        </div>
        </section>
      </form>
</body>
</html>