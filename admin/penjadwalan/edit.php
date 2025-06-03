<?php

include '../../koneksi.php';
if (isset($_GET['id'])) {

    $id = ($_GET["id"]);
    $query = "SELECT penjadwalan.IDpenjadwalan, penjadwalan.alamat, penjadwalan.jumlah
    FROM penjadwalan
    JOIN jadwal ON pesanan.IDproduk = produk.IDproduk
    JOIN user ON pesanan.ID = user.ID
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
        <h1>Edit Pesanan <?php echo $data['email']; ?></h1>
      <center>
      <form method="POST" action="proses_edit.php" enctype="multipart/form-data" >
      <section class="base">
        <input type="hidden" name="id" value="<?php echo $data['IDpenjadwalan']; ?>" />
        <div>
          <label>Nama </label>
          <?php echo $data['email']; ?>
        </div>
        <div>
          <label>jadwal</label>
        <?php echo $data['ari,'];?>
        </div>
         <div>
          <label>Tanggal</label>
         <?php echo $data['tanggal'];?>
        </div>
        <div>
        <label>Jumlah</label>
         <?php echo $data['jumlah']; ?>
        </div>
        <label>Total</label>
        <?php echo $data['total'];?>
        </div>
        <div>
          <label for="status">Status</label>
          <select name="status" required>
           <option disabled selected><?php echo $data['status']; ?></option>
          <option value="canceled">canceled</option>
          <option value="successful">successful</option>
        </select>
        </div>
        <div>
         <button type="submit" name="simpan" value="simpan">Simpan Perubahan</button>
        </div>
        </section>
      </form>
</body>
</html>