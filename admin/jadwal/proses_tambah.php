<?php
include '../../koneksi.php';

$hari  = $_POST['hari'];
$waktu  = $_POST['waktu'];

$query = "INSERT INTO jadwal (hari, waktu) VALUES ('$hari', '$waktu')";
$result = mysqli_query($conn, $query);

if(!$result){
    die ("Query gagal dijalankan: ".mysqli_errno($conn)." - ".mysqli_error($conn));
} else {
    echo "<script>alert('Data berhasil ditambah.');window.location='index.php';</script>";
}
?>
