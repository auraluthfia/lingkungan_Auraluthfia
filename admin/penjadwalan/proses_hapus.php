<?php
include_once("../../koneksi.php");
if(!isset($_GET['id'])){
    header('Location: index.php');
}
$id = $_GET ['id'];
$result = mysqli_query($conn, "DELETE FROM penjadwalan WHERE IDpenjadwalan=$id");
header("location:index.php");
?>