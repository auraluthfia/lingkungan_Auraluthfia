<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Regist</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div class="container">
    <h1 class="title">Register</h1><br>
    <?php
        if(isset($_POST['submit'])){
            $nama= $_POST['nama'];
            $email= $_POST['email'];
            $password= $_POST['password'];
            $nomorHP= $_POST['nomorHP'];
            $role= $_POST['role'];

            include_once("koneksi.php");

            $query = mysqli_query($conn,
            "INSERT INTO user(nama,email,password,nomorHP,role) VALUES ('$nama','$email','$password','$nomorHP','$role')");
            if($query){
                echo'<script>alret("Selamat, anda berhasil. Silahkan Login.")</script>';
            }else{
                echo'<script>alret("Maaf anda gagal.")</script>';
            }
        }
        ?>
        <form class="form" action="register.php" method="post">
            <input type="text" name="nama" placeholder="nama" autocomplete="off" required>
            <input type="text" name="email" placeholder="email" autocomplete="off" required>
            <input type="password" name="password" placeholder="password" autocomplete="off" required>
            <input type="text" name="nomorHP" placeholder="nomor handphone" autocomplete="off" required>
            <select name="role" id="role">
                <option disable selected>Pilih</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>
            <br>
           <br><button class="button" name="submit">Register</button>
           <div class="forgot">
        Already have an account? <a href="index.php">Login</a>
        </div>
    </div>
</body>
</html>