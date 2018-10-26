<?php
//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}

include 'config.php';

// membuat query max
 
    $carikode = $mysqli->query("SELECT  max(id_transaksi) from trash") or die (mysqli_error());

    // menjadikannya array
    
    $datakode = mysqli_fetch_array($carikode);
    
    // jika $datakode
    
    if ($datakode) {
     $nilaikode = substr($datakode[0], 1);
     
     // menjadikan $nilaikode ( int )
     
     $kode = (int) $nilaikode;
     
     // setiap $kode di tambah 1
     
     $kode = $kode + 1;
     $kode_otomatis = "T".str_pad($kode, 2, "0", STR_PAD_LEFT);
    
    } else {
    
     $kode_otomatis = "T01";
    
    }

if(isset($_SESSION['cart'])) {

  $total = 0;
   error_reporting(E_ALL^(E_NOTICE|E_WARNING));
  foreach($_SESSION['cart'] as $product_id => $quantity) {

    $result = $mysqli->query("SELECT * FROM product WHERE id = ".$product_id);
	$user=$_SESSION["username"];
	$ambilid = $mysqli->query("SELECT COUNT(*) FROM trash ");
	$id=$ambilid->fetch_array();
	$jumlah1 = intval($id['COUNT(*)'])+1;

    if($result){
      if($obj = $result->fetch_object()) {
        $cost = $obj->price * $quantity;
        $user = $_SESSION["username"];
        $level = $_SESSION["level"];

        $query = $mysqli->query("INSERT INTO trash (id, id_transaksi, product_code, product_name, units, price, user, level, level2, keterangan) VALUES('$jumlah1', '$kode_otomatis', '$obj->product_code', '$obj->product_name', $quantity, '$obj->price', '$user', 'Manager $level', '$level', '')");
      }
    }
  }
}

unset($_SESSION['cart']);
if ($query) {
    echo '<script>window.alert("Your requests has been sent to be review");window.location=("index.php");</script>';
    
  } else {
    echo '<script>window.alert("You have no items in your shopping cart");window.location=("products.php");</script>';
  }
?>
