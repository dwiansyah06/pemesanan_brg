<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}

  if(!isset($_SESSION["username"])) {
    header("location:index.php");
  }

  if($_SESSION["level"]!="Admin") {
    header("location:index.php");
  }

include 'config.php';

if(isset($_POST['btn_kategori'])){
  $kategori = $_POST['kategori'];
  $kode_kategori = $_POST['kode_kategori'];

  $query = $mysqli->query("INSERT INTO kategori (kategori,kode) VALUES('$kategori','$kode_kategori')");
 
  if($query){
    echo '<script>window.alert("Your Category has been Added");window.location=("tambah_barang.php");</script>';
  }else{
   echo '<script>window.alert("Sorry, there is something wrong while saving this file to the database");window.location=("tambah_barang.php");</script>';
  }
}
?>