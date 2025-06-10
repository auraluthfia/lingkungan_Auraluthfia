<?php
include("../../koneksi.php");

if (isset($_POST['simpan'])) {

    
    if (isset($_POST['id']) && isset($_POST['status'])) {
        $id = mysqli_real_escape_string($conn, $_POST['id']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        $sql = "UPDATE penjadwalan SET status='$status' WHERE IDpenjadwalan='$id'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            header('Location: index.php');
            exit;
        } else {
            echo "Query gagal: " . mysqli_error($conn);
        }
    } else {
        echo "Data 'id' atau 'status' tidak ditemukan di POST.";
    }

} else {
    die("Tidak bisa diakses langsung...");
}
?>
