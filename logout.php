<?php
	session_start();
	if(!isset($_SESSION["username"])) {
	  	header("location: login.php");
	} else {	
		include 'config.php';
		$id_user = $_SESSION['id_user'];
		$username = $_SESSION['username'];

		$query = $mysqli->query("UPDATE user SET status = '0' WHERE id = '$id_user' AND username = '$username' ");
		if ($query) {
			session_destroy();
			header("location:login.php");
		}else{

		}
	}
?>