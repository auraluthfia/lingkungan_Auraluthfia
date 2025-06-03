<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: ../../login.php");
    exit();
}

include '../../koneksi.php';

// Ambil email dari session
$email = $_SESSION['email'];

// Ambil ID user berdasarkan email
$result = $conn->query("SELECT ID FROM user WHERE email = '$email'");
if ($result->num_rows === 0) {
    die("User tidak ditemukan.");
}
$row = $result->fetch_assoc();
$id_user = $row['ID'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $penjadwalan = $_POST['IDpenjadwalan'];
    $jadwal = $_POST['IDjadwal'];
    $alamat = $_POST['alamat'];
    $tanggal = $_POST['tanggal'];   
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['catatan'];
    $sql = "INSERT INTO penjadwalan (IDpenjadwalan, IDjadwal, alamat, tanggal, jumlah, catatan, ID)
    VALUES ('$penjadwalan', '$jadwal', '$alamat', '$tanggal', '$jumlah', '$deskripsi', '$id_user')";   

    if ($conn->query($sql) === TRUE) {
        header("Location: /SIJAUKL/user/penjadwalan/proses.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="penjadwalan.css">
    <title>Penjadwalan</title>
</head>
<body>
    <div class="container">
        <h1>Penjadwalan</h1>
        <form method="POST">
            <!-- ID user tidak perlu ditampilkan karena sudah dari session -->
            
            <label for="IDjadwal">Pilih jadwal:</label>
            <select name="IDjadwal" required>
                <option value="">-- Pilih Jadwal --</option>
                <?php
                $jadwal = $conn->query("SELECT IDjadwal, hari, waktu FROM jadwal");
                while ($w = $jadwal->fetch_assoc()) {
                    echo "<option value='{$w['IDjadwal']}'>{$w['hari']} - {$w['waktu']}</option>";
                }
                ?>
            </select>
            <label for="tanggal">Tanggal:</label>
            <input type="date" name="tanggal" required>
            <label for="alamat">Alamat:</label>
            <input type="text" name="alamat" required>
            <label for="jumlah">Jumlah:</label>
            <input type="number" name="jumlah" required min="1">
            <label for="catatan">Catatan:</label>
            <input type="text" name="catatan" required>
            <br>
            <!-- IDpenjadwalan jika dibutuhkan -->
            <input type="hidden" name="IDpenjadwalan" value="<?php echo uniqid('PJ-'); ?>">
            <button type="submit">Simpan</button>
            <button type="button" onclick="window.history.back();" style="background-color: #777; margin-top: 10px;">Back</button>
        </form>
    </div>
</body>
</html>