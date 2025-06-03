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
<html>
  <head>
    <title>Halaman Edit Profil</title>
    <link rel = "stylesheet" href = "profil.css">
  </head>
  <body>
  <section class="profil">
      <center>
        <h1>Edit Profil</h1>
      <center>
      <form method="POST" action="profil_edit.php" enctype="multipart/form-data" >
        <table border="1" class="table">
        <input name="id" value="<?php echo $data['ID']; ?>"  hidden />
        <tr>
            <th>Nama</th>
            <td><input type="text" name="nama" value="<?php echo $data['nama']; ?>" ></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><input type="text" name="email" value="<?php echo $data['email']; ?>" ></td>
        </tr>
        <tr>
            <th>Password</th>
            <td><input type="text" name="password" value="<?php echo $data['password']; ?>" ></td>
        </tr>
    </table>
         <button type="submit" class="btn-edit">Simpan Perubahan</button>
        <a href="profil.php" class="btn-delete">Back</a>
        </section>
      </form>
  </body>
</html>