<?php 
if(session_id() == '' || !isset($_SESSION)){session_start();}
	if(!isset($_SESSION["username"])) {
     	header("location: login.php");
  	}
include "config.php";
include "header.php";
?>
	<div class="container">
		<center>
			<div class="not-found">
				<img src="asset/images/404.png" alt="">
				<h1>404</h1>
				<p>Ooops... This page is not found</p>
			</div>
		</center>
	</div>
<?php include 'footer.php' ?>