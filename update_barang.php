<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}

include 'config.php';
$user   = $_SESSION['username'];
$level  = $_SESSION['level'];
$kode   = $_POST['kode'];
$nama   = $_POST['nama'];
$cocok  = $_POST['cocok']; 
$harga  = $_POST['harga'];
$gambar = $_FILES['gambar']['name'];
$extensi = explode(".", $gambar);
$foto_bru = "item-".round(microtime(true)).".".end($extensi); 
$size   = $_FILES['gambar']['size'];
$asal   = $_FILES['gambar']['tmp_name'];
$id_brg = $_POST['id'];
$tgl    = date('Y-m-d');  
// $ambilid = $mysqli->query("SELECT COUNT(*) FROM history_product ");
// $id=$ambilid->fetch_array();
// $jumlah1 = intval($id['COUNT(*)'])+1;
// echo $jumlah1;

$result = $mysqli->query("SELECT * FROM product WHERE product_code = '$kode' ");
$dataa = $result->fetch_object();

if($nama!=""){
 $result = $mysqli->query("UPDATE product SET product_name ='". $nama ."' WHERE id =".$id_brg." ");
  if($result){
	  $namaberubah =$mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty, price,cocok,gambar, username, level, keterangan, tanggal) VALUES ('$dataa->product_code','$nama','0','0','0','$dataa->price','$dataa->cocok','$dataa->product_img_name','$user','$level','Perubahan nama product','$tgl')");
  }
}

if($harga!=""){
  $result = $mysqli->query("UPDATE product SET price ='". $harga ."' WHERE id =".$id_brg." ");
  if($result){
	  $hargaberubah =$mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty, price,cocok,gambar,username, level, keterangan, tanggal) VALUES ('$dataa->product_code','$dataa->product_name','0','0','0','$harga','$dataa->cocok','$dataa->product_img_name','$user','$level','Perubahan harga product','$tgl')");
  }
}
if($cocok!=""){
  $result = $mysqli->query("UPDATE product SET cocok ='". $cocok ."' WHERE id =".$id_brg." ");
  if($result){
	  $cocokberubah =$mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty,  price, cocok, gambar, username, level, keterangan, tanggal) VALUES ('$dataa->product_code','$dataa->product_name','0','0','0','$dataa->price','$cocok','$dataa->product_img_name','$user','$level','Perubahan tipe yang cocok dengan product','$tgl')");
  }
}
if($gambar!=""){
  $result = $mysqli->query("UPDATE product SET product_img_name ='". $foto_bru ."' WHERE id =".$id_brg." ");
  if($result){
    // $lokasi = $gambar;
    // move_uploaded_file($asal, "asset/images/products/".$gambar); 
    // $asli1 = "asset/images/products/"; 
    // $asli2 = $asli1.$gambar;
      
    // $gambar_asli  = imagecreatefromjpeg ($asli2);
    // $lebar_asli   = imageSX($gambar_asli);
    // $tinggi_asli  = imageSY($gambar_asli);

    // $lebar_baru = 620; 
    // $tinggi_baru = 620;
     
    // $img = imagecreatetruecolor($lebar_baru, $tinggi_baru);
    // imagecopyresampled($img, $gambar_asli, 0, 0, 0, 0, $lebar_baru, $tinggi_baru, $lebar_asli, $tinggi_asli);
      
    // imagejpeg($img,$asli1.$gambar);
    move_uploaded_file($asal, "asset/images/products/".$foto_bru);
    unlink("asset/images/products/".$dataa->product_img_name);

    $gambarberubah =$mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty,  price, cocok, gambar, username, level, keterangan, tanggal) VALUES ('$dataa->product_code','$dataa->product_name','0','0','0','$dataa->price','$dataa->cocok','$foto_bru','$user','$level','Perubahan gambar product','$tgl')");
  }
}

echo '<script>window.alert("Your stuff has been successfully changed");window.location=("stuff.php");</script>';


?>
