<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman login</title>
      <link rel="stylesheet" href="style.css">
</head>
<body>
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