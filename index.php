<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
  if(!isset($_SESSION["username"])) {
     header("location: login.php");
  }

	include "config.php";
	$id_user = $_SESSION['id_user'];
	$uname = $_SESSION['username'];
	$status_query = $mysqli->query("SELECT status FROM user WHERE id ='$id_user' AND username = '$uname' ");

	$get_s = $status_query->fetch_object();
	if ($get_s->status == '0') {
	  header("location:kick.php");
	}

  include ("header.php");
?>
<div class="container mt-10">
  <div class="jumbotron">
	  <h1>Welcome <?= $level ?>!</h1>
	  <p style="margin-bottom: 0">
	  	Selamat datang di aplikasi pemesanan barang online dan anda login sebagai <strong><?= $level2 ?></strong>, 
	  </p>
	  <?php  
	  		if ($level2 == 'user') {
	  			echo '
	  				<p>Silahkan klik tombol dibawah ini untuk memesan barang</p>
					<a class="btn btn-primary btn-lg" href="products.php" role="button">Produk</a>
	  			';
	  		} elseif ($level2 == 'manager') {
	  			echo '
	  				<p>Silahkan klik tombol dibawah ini untuk mengecek pemintaan barang</p>
					<a class="btn btn-primary btn-lg" href="pesanan.php" role="button">request</a>
	  			';
	  		} elseif ($level2 == 'admin') {
	  			echo '
	  				<p>Silahkan klik tombol dibawah ini untuk menyetujui permintaan barang</p>
					<a class="btn btn-primary btn-lg" href="order_manager.php" role="button">request</a>
	  			';
	  		} elseif ($level2 == 'superadmin') {
	  			echo '
	  				<p>Silahkan klik tombol dibawah ini untuk melihat siapa yang aktif.</p>
					<a class="btn btn-primary btn-lg" href="user.php" role="button">User</a>
	  			';
	  		}
	  	?>
	</div>
</div>

  <?php include ("footer.php"); ?>