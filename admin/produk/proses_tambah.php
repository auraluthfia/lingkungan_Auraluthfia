<?php
include '../../koneksi.php';
  $nama_produk      = $_POST['nama_produk'];
  $deskripsi        = $_POST['deskripsi_produk'];
  $harga            = $_POST['harga'];
  $gambar_produk    = $_FILES['gambar']['name'];
if($gambar_produk != "") {
  $ekstensi_diperbolehkan = array('png','jpg','jpeg'); 
  $x = explode('.', $gambar_produk); 
  $ekstensi = strtolower(end($x));
  $file_tmp = $_FILES['gambar']['tmp_name'];   
  $angka_acak     = rand(1,999);
  $nama_gambar_baru = $angka_acak.'-'.$gambar_produk; 
        if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {     
                move_uploaded_file($file_tmp, 'gambar/'.$nama_gambar_baru);
                  $query = "INSERT INTO produk (nama_produk, deskripsi_produk, harga, gambar) VALUES ('$nama_produk', '$deskripsi', '$harga', '$nama_gambar_baru')";
                  $result = mysqli_query($conn, $query);
                  if(!$result){
                      die ("Query gagal dijalankan: ".mysqli_errno($conn).
                           " - ".mysqli_error($conn));
                  } else {
                    echo "<script>alert('Data berhasil ditambah.');window.location='index.php';</script>";
                  }
            } else {     
                echo "<script>alert('Ekstensi gambar yang boleh hanya jpg png atau jpeg.');window.location='tambah_produk.php';</script>";
            }
} else {
   $query = "INSERT INTO produk (nama_produk, deskripsi_produk, harga, gambar_produk) VALUES ('$nama_produk', '$deskripsi_produk', '$harga', null)";
                  $result = mysqli_query($conn, $query);
                  if(!$result){
                      die ("Query gagal dijalankan: ".mysqli_errno($conn).
                           " - ".mysqli_error($conn));
                  } else {
                    echo "<script>alert('Data berhasil ditambah.');window.location='index.php';</script>";
                  }
}
?>