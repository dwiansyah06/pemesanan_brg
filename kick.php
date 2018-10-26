<?php
  if(session_id() == '' || !isset($_SESSION)){session_start();}
  include "config.php";
  $id_user = $_SESSION['id_user'];
  $status = $mysqli->query("SELECT status FROM user WHERE id ='$id_user' ");
  $obj = $status->fetch_object();
    
    if(!isset($_SESSION["username"])) {
      header("location: login.php");
    } elseif ($obj->status == '1') {
      header("location: index.php");
    }
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Pemesanan Barang</title>
	<link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="asset/css/kick.css">
	<script src="asset/js/vendor/jquery.js"></script>
</head>
<body>
<div class="site-wrapper">
      <div class="site-wrapper-inner">
        <div class="cover-container">
          <div class="inner cover">
          	<img src="asset/images/logo.png" style="width: 20%;">
            <h3><i class="fa fa-warning"></i> Warning!!!</h3>
            <p>Kamu telah di keluarkan oleh pihak super admin karena dianggap bukan user yang sebenarnya, silahkan logout.</p>
            <a href="logout.php" class="btn btn-danger btn-flat"><span class="fa fa-sign-out"></span> Log Out</a>
          </div>

          <div class="mastfoot">
              <p>&copy; Lorem ipsum dolor sit amet, consectetur.</p>
          </div>
        </div>
      </div>
    </div>
<script src="asset/js/vendor/bootstrap.min.js"></script>
</body>
</html>