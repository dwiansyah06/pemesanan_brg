<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}

if($_SESSION['level'] !== "Admin") {
  header("location:index.php");
}

if (isset($_POST['upd-stok'])) {
  
  include 'config.php';
  $user     = $_SESSION['username'];
  $level    = $_SESSION['level'];
  $id_brg   = $_GET['id'];
  $kode     = $_GET['kode'];
  $quantity = $_POST['quantity'];
  $tgl      = date('Y-m-d');

  $result = $mysqli->query("SELECT * FROM product WHERE id = '$id_brg' AND product_code = '$kode'");
  if ($result) {
    $obj = $result->fetch_object();
    $qty_lama      = $obj->qty;
    $newqty        = $qty_lama + $quantity;
  	$product_code  = $obj->product_code;
  	$product_name  = $obj->product_name;
  	$price         = $obj->price;
    $cocok         = $obj->cocok;
    $gambar        = $obj->product_img_name; 
    // echo "$id_brg <br> $kode <br> $quantity <br> $user <br> $level <br> $qty_lama <br> $newqty <br> $product_name <br> $price";


    $update = $mysqli->query("UPDATE product SET qty = '$newqty' WHERE id = '$id_brg' AND product_code = '$kode' ");
	
		// $ambilid = $mysqli->query("SELECT COUNT(*) FROM history_product ");
		// $id=$ambilid->fetch_array();
		// $jumlah1 = intval($id['COUNT(*)'])+1;

		$update2=$mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty, price,cocok,gambar, username, level, keterangan, tanggal) VALUES ('$product_code','$product_name','$quantity','0','$newqty','$price','$cocok','$gambar','$user','$level', 'Penambahan stok barang','$tgl')");
    
    if ($update) {
		  $_SESSION['pesan-upt'] = "";
		  $_SESSION['id-upt'] = $id_brg;
		  header("location:admin.php");
    }   
  }

} else {
  header("location:admin.php");
}

?>
