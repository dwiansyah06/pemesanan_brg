<?php  
	include "config.php";
	$id = $_GET['id_user'];
	$username = $_GET['usrnm'];

	$kick = $mysqli->query("UPDATE user SET status ='0' WHERE id ='$id' ");
	if ($kick) {
		echo '<script>window.alert("berhasil mengeluarkan user '.$username.' dari aplikasi");window.location=("user.php");</script>';
	}
?>