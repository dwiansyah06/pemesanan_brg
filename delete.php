<?php  
	if(session_id() == '' || !isset($_SESSION)){session_start();}
	include 'config.php';

	$id_brg = $_GET['id'];
	$kode 	= $_GET['code'];
	$tgl 	= date('Y-m-d');
	$user   = $_SESSION['username'];
	$level  = $_SESSION['level'];
	
	$data_barang = $mysqli->query("SELECT * FROM product WHERE id = '$id_brg' AND product_code = '$kode'");
	$dataa = $data_barang->fetch_object();
	// echo "$dataa->product_code <br> $dataa->product_name <br> $dataa->price <br> $dataa->cocok <br> $dataa->product_img_name <br> $tgl";

	$hapus_barang =$mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty, price,cocok,gambar, username, level, keterangan, tanggal) VALUES ('$dataa->product_code','$dataa->product_name','0','0','0','$dataa->price','$dataa->cocok','$dataa->product_img_name','$user','$level','Menghapus produk','$tgl')");

	if ($hapus_barang) {
		$del = $mysqli->query("DELETE FROM product WHERE id = '$id_brg' AND product_code = '$kode'");
		unlink("asset/images/products/".$dataa->product_img_name);

		echo '<script>window.alert("produk '.$dataa->product_name.' telah terhapus");window.location=("stuff.php");</script>';
	} else {
		echo '<script>window.alert("produk gagal terhapus");window.location=("stuff.php");</script>';
	}
?>