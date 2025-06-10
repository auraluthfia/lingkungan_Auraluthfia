<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman login</title>
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
    </nav>

    <div class="icons">
        <a href="/SIJAUKL/user/profil/profil.php"><i class="fas fa-user "></i></a>
    </div>
</header>
<!--header section akhir-->
    <div class="container">
        <h1 class="title">Login</h1><br>
        <form class="form" action="login.php" method="post">
            <input type="email" name="email" placeholder="email" autocomplete="off" required>
            <input type="password" name="password" placeholder="password" autocomplete="off" required>
            <a href="login.php">
               <button class="button">Login</button>
            </a>
        </form>
        <div class="forgot">
        Don't have account? <a href="register.php">Register</a>
        </div>
    </div>
</body>
</html>