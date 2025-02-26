<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman penjadwalan</title>
      <link rel="stylesheet" href="style1.css">
</head>
<body>
    <div class="container">
        <h1 class="title">Buat Penjadwalan</h1><br>
        <form class="form" action="jadwal.php" method="post">
            <input type="email" name="Username" placeholder="username">
            <input type="password" name="Password" placeholder="password">
            <select name="hari" id="hari" autocomplete="off" required>
                <option disable selected>Pilih Hari</option>
                <option value="delapan">Senin</option>
                <option value="sepuluh">Selasa</option>
                <option value="duabls">Rabu</option>
                <option value="duabls">Kamis</option>
            </select>
            <select name="waktu" id="waktu" autocomplete="off" required>
                <option disable selected>Pilih waktu</option>
                <option value="delapan">08.00</option>
                <option value="sepuluh">10.00</option>
                <option value="duabls">12.00</option>
                
            </select><br>
            <a href="pengambilan.php">
               <button class="button">Buat jadwal</button>
            </a>
            <?php
        if(isset($_POST['submit'])){
            $namas= $_POST['nama'];
            $usernames= $_POST['username'];
            $passwords= $_POST['password'];
            $levels= $_POST['level'];

            include_once("koneksi.php");
            
            $result = mysqli_query($mysqli,
            "INSERT INTO penjadwalan(nama,username,password,level) VALUES ('$namas','$usernames','$passwords','$levels')");

            header("location:penjadwalan.php");
        }
        ?>




        </form>
    </div>
</body>
</html>