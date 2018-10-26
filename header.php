<?php 
  $telah_berlalu = time() - $_SESSION["mulai"];
  $temp_waktu = (15*60) - $telah_berlalu;
  $temp_menit = (int)($temp_waktu/60);
  $temp_detik = $temp_waktu%60;
  $menit  = $temp_menit; 
  $detik = $temp_detik;

  //manager
  $level = $_SESSION['level'];
  $result = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM trash WHERE level = '$level' AND action ='N'");

  $count = mysqli_num_rows($result);
  $_SESSION['count'] = $count;

  //admin
  $result_admin = $mysqli->query("SELECT DISTINCT id_transaksi,level FROM approve WHERE action = 'N'");

  $count_admin = mysqli_num_rows($result_admin);
  $_SESSION['count-admin'] = $count_admin;
?>

<!DOCTYPE html>
<html class="no-js" lang="en">
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pemesanan Barang</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="asset/DataTables/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css">
    <link rel="stylesheet" href="asset/css/style.css" />
    <link rel="stylesheet" href="asset/datepicker/css/bootstrap-datetimepicker.min.css">
    <script src="asset/js/vendor/jquery.js"></script>
  </head>
  <body>
  
  <div class="container">
  <br>
<!-- start hader -->
  <header>
    <!-- <div id='timer'></div> -->
    <img src="asset/images/logo.png"; style="width: 10%;" /> 
    <img src="asset/images/logo.png"; style="width: 10%;float: right;" /> 

    <nav>
    <ul class="topnav">
       <?php

          /* Login untuk user */
       if (isset($_SESSION['level'])) {
          $level = $_SESSION['level']; 
          $level2 = $_SESSION['level2']; ?>
          <h3><i class="fa fa-user mr-5"></i><?php echo $level; ?></h3> 
        <?php
          $masuk1 = $level2 == "user";

                        if ($masuk1){ ?>
                          <li><a class="dropdown-btn" style="cursor: pointer;"> User <span class="fa fa-caret-down"></span></a>
                            <ul class="drop">
                              <li><a href="profile.php"> Change Password </a></li>
                              <li><a href="logout.php"> Log Out </a></li>
                            </ul>
                          </li>
                        <?php 
                          if (!isset($_SESSION['cart'])) {
                        ?>
                          <li><a href="cart.php">Cart</a></li>
                        <?php } else { ?>
                          <li><a href="cart.php">Cart <span class="badge" style="background: #fff; color: #337ab7;"><?php echo $_SESSION['tp']; ?></span> </a></li>
                        <?php } ?>
                        <li><a href="products.php">Products</a></li>
                        <li><a href="history_user.php">History</a></li>
                        <li><a href="index.php">Home</a></li>
                  <?php }

          //Untuk Admin
          $masuk2 = $level2 == "admin";
                        if ($masuk2){ 
                          $count_adm =  $_SESSION['count-admin'];
                        ?>
						            <li><a href="logout.php"> Log Out </a></li>
                        <li><a href="profile.php"> Change Password </a></li>
                        <li><a class="dropdown-btn" style="cursor: pointer;">Report <span class="fa fa-caret-down"></span> </a>
                          <ul class="drop">
				                    <li><a href="report.php"><span class="fa fa-tags"></span> transaction</a></li>
                            <li><a href="stuff.php"><span class="fa fa-archive"></span> Stuff</a></li>
                          </ul>
                        </li>
                        <li><a href="tambah_barang.php">Add Stuff</a></li>
                        <li><a href="admin.php">Update Stock</a></li>
								        <li><a href="order_manager.php">request</a></li>
                        <li><a href="history.php">History</a></li>
                        <li><a href="index.php">Home</a></li>
                  <?php }


          /* Login untuk manager */
          $masuk3 = $level2 == "manager";
                        if ($masuk3){ 
                          $count2 = $_SESSION['count'];?>
                        <li><a href="logout.php"> Log Out </a></li>
                        <li><a href="profile.php"> Change Password </a></li>
                        <li><a href="history_manager.php">History</a></li>
                      <?php if ($count2 == 0) { ?>
                        <li><a href="pesanan.php"> Request </a></li>
                     <?php } else { ?>
                        <li><a href="pesanan.php"> Request <span class="badge"></span> </a></li>
                     <?php } ?>
                     <li><a href="index.php">Home</a></li>
                  <?php } 

		/* Login untuk superadmin */
          $masuk4 = $level2 == "superadmin";
                        if ($masuk4){ 
                          $count2 = $_SESSION['count'];
                          ?>
                           

                                    <li><a href="logout.php"> Log Out </a></li>
                                    <li><a href="profile.php"> Change Password </a></li>
								                    <li><a class="dropdown-btn" style="cursor: pointer;"> Report <span class="fa fa-caret-down"></span> </a>
                                    <ul class="drop">
                                      <li><a href="user.php"><span class="fa fa-user"></span> User</a></li>
                                      <li><a href="history_barang.php"><span class="fa fa-archive"></span> Products</a></li>
                                    </ul>
                                </li>
                             
                               <li><a href="tambah_user.php">Add User</a></li>
                                
                               <li><a href="index.php">Home</a></li>
                  <?php } 
        }        
      ?>
      <li class="icon">
                <a href="javascript:void(0);" onclick="myFunction()">☰</a>
              </li>
    </ul>
  </nav>
  <center><div class="box"></div></center>
</header>
</div>
<body>
<div class="loader">
  <div class="loader_html"></div>
</div>