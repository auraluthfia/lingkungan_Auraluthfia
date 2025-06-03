<?php
include '../../koneksi.php';

$id            = $_POST['id'];
$hari          = $_POST['hari'];
$waktu         = $_POST['waktu'];


$query = "UPDATE jadwal SET hari = '$hari', waktu = '$waktu' WHERE IDjadwal = '$id'";
$result = mysqli_query($conn, $query);

if(!$result){
    die ("Query gagal dijalankan: ".mysqli_errno($conn)." - ".mysqli_error($conn));
} else {
    echo "<script>alert('Data berhasil diubah.');window.location='index.php';</script>";
}
?>
