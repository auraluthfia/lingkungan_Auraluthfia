<?php
include '../../koneksi.php';
  $id            = $_POST['id'];
  $nama_produk   = $_POST['nama_produk'];
  $deskripsi     = $_POST['deskripsi_produk'];
  $harga         = $_POST['harga'];
  $gambar_produk = $_FILES['gambar']['name'];

  if($gambar_produk != "") {
    $ekstensi_diperbolehkan = array('png','jpg','jpeg'); 
    $x = explode('.', $gambar_produk); 
    $ekstensi = strtolower(end($x));
    $file_tmp = $_FILES['gambar']['tmp_name'];   
    $angka_acak     = rand(1,999);
    $nama_gambar_baru = $angka_acak.'-'.$gambar_produk;
    if(in_array($ekstensi, $ekstensi_diperbolehkan) === true)  {
                  move_uploaded_file($file_tmp, 'gambar/'.$nama_gambar_baru); 
                  $query  = "UPDATE produk SET nama_produk = '$nama_produk', deskripsi_produk = '$deskripsi', harga = '$harga', gambar = '$nama_gambar_baru'";
                  $query .= "WHERE IDproduk = '$id'";
                  $result = mysqli_query($conn, $query);
                    if(!$result){
                        die ("Query gagal dijalankan: ".mysqli_errno($conn).
                             " - ".mysqli_error($conn));
                    } else {
                      echo "<script>alert('Data berhasil diubah.');window.location='index.php';</script>";
                    }
              } else {     
                  echo "<script>alert('Ekstensi gambar yang boleh hanya jpg, jpeg dan png.');window.location='tambah_produk.php';</script>";
              }
    } else {
      $query  = "UPDATE produk SET nama_produk = '$nama_produk', deskripsi_produk = '$deskripsi', harga = '$harga'";
      $query .= "WHERE IDproduk = '$id'";
      $result = mysqli_query($conn, $query);
      if(!$result){
            die ("Query gagal dijalankan: ".mysqli_errno($conn).
                             " - ".mysqli_error($conn));
      } else {
          echo "<script>alert('Data berhasil diubah.');window.location='index.php';</script>";
      }
    }
?>