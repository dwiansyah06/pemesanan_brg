<?php
	//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(session_id() == '' || !isset($_SESSION)){session_start();}

	include "config.php";
		if (isset($_POST["approve"])) {
			
	error_reporting(E_ALL^(E_NOTICE|E_WARNING));
	$level 		= $_SESSION['level'];
	// $id 		= $_SESSION['id'];
	
	$keranjang 	= $_POST['keranjang'];
	// $get_qty 	= $_POST['qty'];
	// $qty 		= $_POST['qty'];	
	// foreach ($keranjang as $cart) { 
	// echo $cart['qty'];
	// }
	
	foreach ($keranjang as $cart) { 
		$result = $mysqli->query("SELECT * FROM trash WHERE id_transaksi = '$cart[id_transaksi]' AND product_code = '$cart[product_code]' ");
		$ambilid = $mysqli->query("SELECT COUNT(*) FROM approve ");
		$id=$ambilid->fetch_array();
		$jumlah1 = intval($id['COUNT(*)'])+1;
			if ($result) {
			 	if($obj = $result->fetch_object()) {
			 		// echo "$obj->product_code $obj->product_name $cart[keterangan] <br>";
					$query = $mysqli->query("INSERT INTO approve (id, id_transaksi, product_code, product_name, units, price, user, level, level2, keteranganmgr) VALUES('$jumlah1','$obj->id_transaksi', '$obj->product_code', '$obj->product_name', '$obj->units','$obj->price', '$obj->user', '$obj->level', '$obj->level2', '$cart[keterangan]') ");


					if($query){
			          	if($mysqli->query("UPDATE trash SET action = 'Y' WHERE id_transaksi = '$obj->id_transaksi' ")){
			          	}
			        }
				}
			}
	}

		if ($query) {
			echo '<script>window.alert("Your request has been sent to IT");window.location=("pesanan.php");</script>';
			
		} else {
			echo '<script>window.alert("You have no items in your shopping cart");window.location=("pesanan.php");</script>';
		}

	}
	
	if (isset($_POST["batal"])) {		
		error_reporting(E_ALL^(E_NOTICE|E_WARNING));
		$level 		= $_SESSION['level'];
		
		$keranjang 	= $_POST['keranjang'];
		
		foreach ($keranjang as $cart) {
			// echo "$cart[keterangan]";
			$query2 = $mysqli->query("UPDATE trash SET action = 'N', keterangan = '$cart[keterangan]' WHERE id_transaksi = '$cart[id_transaksi]' AND product_code = '$cart[product_code]' ");
		}
			if ($query2) {
				echo '<script>window.alert("Your request has been sent to User");window.location=("pesanan.php");</script>';
				
			} else {
				echo '<script>window.alert("You have no items in your shopping cart");window.location=("pesanan.php");</script>';
			}
	}
?>