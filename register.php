<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Regist</title>
<!-- font awesome cdn link-->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

      <link rel="stylesheet" href="style.css">
</head>
<body>
<!--header section awal-->
<header>
    <input type="checkbox" name="" id="toggler">
    <label for="toggler" class="fas fa-bars">
	</label>
    <a href="#" class="logo"><span>M</span>ijel</a>

    <nav class="navbar">
        <a href="/SIJAUKL/user/index.php#home">Home</a>
        <a href="/SIJAUKL/user/index.php#toko">Toko kami</a>
        <a href="/SIJAUKL/user/index.php#about">Tentang kami</a>
        <a href="/SIJAUKL/user/index.php#ulasan">Ulasan</a>
    </nav>

    <div class="icons">
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>
<!--header section akhir-->
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