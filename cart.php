<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
include 'config.php';
$telah_berlalu = time() - $_SESSION["mulai"];
$temp_waktu = (15*60) - $telah_berlalu;
$temp_menit = (int)($temp_waktu/60);
$temp_detik = $temp_waktu%60;
$menit  = $temp_menit; 
$detik = $temp_detik;

$id_user = $_SESSION['id_user'];
$uname = $_SESSION['username'];
$status_query = $mysqli->query("SELECT status FROM user WHERE id ='$id_user' AND username = '$uname' ");

$get_s = $status_query->fetch_object();
if ($get_s->status == '0') {
  header("location:kick.php");
}

  if(!isset($_SESSION["username"])) {
     echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
  } elseif ($_SESSION["level2"] != "user") {
    header("location:404.php");
  }
    $carikode = $mysqli->query("SELECT  max(id_transaksi) from trash") or die (mysqli_error());
    $datakode = mysqli_fetch_array($carikode);
    if ($datakode) {
        $nilaikode = substr($datakode[0], 1);
        $kode = (int) $nilaikode;
        $kode = $kode + 1;
        $kode_otomatis = "T".str_pad($kode, 2, "0", STR_PAD_LEFT);
    } else {
        $kode_otomatis = "T01";
    }   
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Pemesanan Barang</title>
  <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="asset/DataTables/datatables.min.css">
  <link rel="stylesheet" type="text/css" href="asset/css/font-awesome.min.css">
  <link rel="stylesheet" href="asset/css/style.css" />
  <script src="asset/js/vendor/jquery.js"></script>
</head>

<header>
  <!-- <div id='timer'></div> -->
  <div class="container">
  <br>
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
                <li><a href="#" class="dropdown-btn"> User <span class="fa fa-caret-down"></span></a>
                                    <ul class="drop">
                                      <li><a href="profile.php"> Change Password </a></li>
                                      <li><a href="logout.php"> Log Out </a></li>
                                    </ul>
                                </li>

                                  <li><a href="cart.php">Cart</a></li>
                                <li><a href="products.php">Products</a></li>
                                <li><a href="history_user.php">History</a></li>
                                <li><a href="index.php">Home</a></li>
              <?php }  
        } ?>
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
  <div class="container">
    <input type="hidden" value="<?php echo "$kode_otomatis";?>" name="kode_transaksi">
    <?php
      if(isset($_SESSION['cart'])) {
        echo '<div class="judul-cart">';
        echo '<h2><span class="fa fa-shopping-cart mb-20" style="margin-right: 1%"></span>Shopping Cart</h2>';
        $total = 0;
        $i = 0;
        echo '<table class="table table-hover">';
        echo '<tr>';
        echo '<th>Code</th>';
        echo '<th>Name</th>';
        echo '<th>Quantity</th>';
        echo '</tr>';

        foreach($_SESSION['cart'] as $product_id => $quantity) {
          $result = $mysqli->query("SELECT product_code, product_name, product_desc, qty, price FROM product WHERE id = ".$product_id);
          if($result){
            while($obj = $result->fetch_object()) {
              $cost = $obj->price * $quantity;
              $total = $total + $cost;

              echo '<tr>';
              echo '<td>'.$obj->product_code.'</td>';
              echo '<td>'.$obj->product_name.'</td>';
              echo '<td>'.$quantity.'&nbsp;<a class="btn btn-success" style="padding:5px;" href="update-cart.php?action=add&id='.$product_id.'">+</a>&nbsp;<a class="btn btn-danger" style="padding:5px;" href="update-cart.php?action=remove&id='.$product_id.'">-</a> <a class="btn btn-danger" style="padding:5px;" href="update-cart.php?action=delete&id='.$product_id.'">Delete</a> </td>';
              echo '</tr>';
    $i++;  }
          }
        }

              echo '<tr>';
              echo '</tr>';

              echo '<tr>';
              echo '<td colspan="4" align="right"><a href="update-cart.php?action=empty" class="btn btn-danger">Clear Cart</a>&nbsp;<a href="products.php" class="btn btn-success">Continue Shopping</a>&nbsp;<a href="orders-update.php" class="btn btn-primary">Submit</a>';

              echo '</td>';

              echo '</tr>';
              echo '</table>';
              echo '</div>';
        $tp = max([$i]); $_SESSION['tp'] = $tp;
      } else { ?>
          <center>
            <div class="empty-cart">
              <img src="asset/images/empty-states.png">
              <h1>Oops Cart Is Empty</h1>
              <p>looks like you have no items in your cart, Click <a href="products.php">here</a> to get your items.</p>
            </div>
          </center>
  <?php } ?>
</div>
<?php include 'footer.php'; ?>