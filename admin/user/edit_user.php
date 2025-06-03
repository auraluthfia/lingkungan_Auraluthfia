<?php

include '../../koneksi.php';
if (isset($_GET['id'])) {

    $id = ($_GET["id"]);
    $query = "SELECT * FROM user WHERE ID='$id'";
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
        <h1>Edit Pengguna <?php echo $data['nama']; ?></h1>
      <center>
      <form method="POST" action="proses_edit.php" enctype="multipart/form-data" >
      <section class="base">
        <input name="id" value="<?php echo $data['ID']; ?>"  hidden />
        <div>
          <label>Nama </label>
          <input type="text" name="nama" value="<?php echo $data['nama']; ?>" autofocus="" required="" >
        </div>
        <div>
          <label>Email</label>
         <input type="email" name="email" value="<?php echo $data['email'];?>" >
        </div>
        <div>
        <label>Password</label>
         <input type="text" name="password" required=""value="<?php echo $data['password']; ?>" >
        </div>
        <label>nomor handphone</label>
         <input type="text" name="nomorHP" required=""value="<?php echo $data['nomorHP'];?>" >
        </div>
        <div>
          <label>Role</label>
          <select name="role" id="role" required>
                        <option disabled selected> <?php echo $data['role']; ?></option>
                        <option value="admin">Admin</option>
                        <option value="user">User</option>
                    </select>
        </div>
        <div>
         <button type="submit" name="simpan" value="simpan">Simpan Perubahan</button>
        </div>
        </section>
      </form>
</body>
</html>


