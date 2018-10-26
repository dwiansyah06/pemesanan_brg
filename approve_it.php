<?php
	//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(session_id() == '' || !isset($_SESSION)){session_start();}

	include "config.php";
	if (isset($_POST["approve"])) {
			
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$level 		= $_SESSION['level'];
	// $id 		= $_SESSION['id'];
	
	$keranjang 	= $_POST['keranjang'];
	$tanggal = date('Y-m-d');
	// $get_qty 	= $_POST['qty'];
	// $qty 		= $_POST['qty'];	
	// foreach ($keranjang as $cart) { 
	// $newprice = $cart['price']*$cart['qty'];
	// echo ' '.$newprice.' ';
	// }
	
	foreach ($keranjang as $cart) { 
		$result = $mysqli->query("SELECT * FROM approve WHERE id_transaksi = '$cart[id_transaksi]' AND product_code = '$cart[product_code]' ");
		$useradmin = $_SESSION["username"];
		$ambiluser = $mysqli->query("SELECT user FROM trash WHERE id_transaksi = '$cart[id_transaksi]' AND product_code = '$cart[product_code]' ");

		$user= $ambiluser->fetch_object();
		$ambilid = $mysqli->query("SELECT COUNT(*) FROM approve_it ");
		$id = $ambilid->fetch_array();
		$jumlah1 = intval($id['COUNT(*)'])+1;	
	
		if ($result) {
		 	if($obj = $result->fetch_object()) {
		 		$newprice = $cart['price']*$cart['qty'];
				$query = $mysqli->query("INSERT INTO approve_it (id, id_transaksi, product_code, product_name, units, price, total, user, level, level2, keterangan, keteranganti) VALUES('$jumlah1','$obj->id_transaksi', '$obj->product_code', '$obj->product_name', '$cart[qty]','$obj->price','$newprice', '$obj->user', '$obj->level', '$obj->level2', '$obj->keteranganmgr', '$cart[keterangan]') ");


		 if($query){
          	if($mysqli->query("UPDATE approve SET action = 'Y', keteranganti='$cart[keterangan]' WHERE id_transaksi = '$obj->id_transaksi' AND product_code = '$cart[product_code]' ")){
          		
					$ambilqty = $mysqli->query("SELECT * FROM product WHERE product_code = '$obj->product_code'");
					$idqty = $ambilqty->fetch_object();
					$tqty = intval($idqty->qty);
				$update2 = $mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty, price, cocok, gambar, username, level, keterangan, tanggal) VALUES ('$obj->product_code','$obj->product_name','0','$cart[qty]','$tqty','$obj->price', '-', '-', '$user->user','$obj->level','disetujui oleh admin gudang dengan id $useradmin','$tanggal')");
          	}
        } 

			$result2 = $mysqli->query("SELECT * FROM product WHERE product_code = '$cart[product_code]'");
			if ($result2) {
				if($obj2 = $result2->fetch_object()) {
					if($query){			
						$newqty = $obj2->qty - $cart['qty'];			
          				// $newqty = $obj2->qty + ($cart['units'] - $cart['qty']);
						 if ($mysqli->query("UPDATE product SET qty = ".$newqty." WHERE product_code = '$cart[product_code]'")){
						 }
						 // echo "$obj->product_code $obj->product_name $cart[qty] $obj->price $newprice $cart[keterangan] $newqty <br>";	
        			}			
				}
			}
			} 
		}
	}

		if ($query) {
			echo '<script>window.alert("This request has been approveds");window.location=("index.php");</script>';
			
		} else {
			echo '<script>window.alert("You have no items in your shopping cart");window.location=("index.php");</script>';
		}

	}
	
	if (isset($_POST["batal"])) {
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$level 		= $_SESSION['level'];
	
	$keranjang 	= $_POST['keranjang'];
	
	foreach ($keranjang as $cart) { 
		$query2 = $mysqli->query("UPDATE approve SET action = 'N', keteranganti = '$cart[keterangan]' WHERE id_transaksi = '$cart[id_transaksi]' AND product_code = '$cart[product_code]' "); 
	}
	
		if ($query2) {
			echo '<script>window.alert("This request has been rejected");window.location=("index.php");</script>';
			
		} else {
			echo '<script>window.alert("You have no items in your shopping cart");window.location=("index.php");</script>';
		}

	}
?>