<?php
  if(session_id() == '' || !isset($_SESSION)){session_start();}
    if(!isset($_SESSION["username"])) {
       echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
    }

    if($_SESSION["level"]!="Admin") {
      echo '<script>window.alert("Sorry, Your are not Admin");window.location=("index.php");</script>';
    }
  include 'config.php';
  $id_user = $_SESSION['id_user'];
  $uname = $_SESSION['username'];
  $status_query = $mysqli->query("SELECT status FROM user WHERE id ='$id_user' AND username = '$uname' ");

  $get_s = $status_query->fetch_object();
  if ($get_s->status == '0') {
    header("location:kick.php");
  }

  include 'header.php';
?>

    <div class="container">
        <?php 
          $nomor = $_GET['id_transaksi'];
          echo '<div class="judul-content">
                  <center><h2>Transaction <span>'.$nomor.'</span></h2></center>
                </div>';
        ?>
          <table class="table table-hover table-responsive table-bordered">
            <thead>
              <tr>
                <th>Product Code</th>
                <th>Product Name</th>
                <th><center>Units</center></th>
                <th>Price</th>
                <th>Total</th>
                <th>Date</th>
              </tr>
            </thead>

        <?php
            $result = $mysqli->query("SELECT id_transaksi,product_code,product_name,units,price,date FROM approve_it WHERE id_transaksi ='$nomor' ");

              if($result){
                while($obj = $result->fetch_object()) {
                  echo '<tr>';
                  echo '<td>'.$obj->product_code.'</td>';
                  echo '<td>'.$obj->product_name.'</td>';
                  echo '<td><center>'.$obj->units.'</center></td>';
                  echo '<td>Rp '.number_format($obj->price, 0, ',', '.').'</td>';

                  $newprice = $obj->price*$obj->units;
                  
                  echo '<td>Rp '.number_format($newprice, 0, ',', '.').'</td>';
                  echo '<td>'.$obj->date.'</td>';
                  echo '</tr>';
                  
                  $_SESSION['product_code'] = $obj->product_code;
                  error_reporting(E_ALL^(E_NOTICE|E_WARNING));
                  $gt = $gt + $newprice;

                  $_SESSION['gt'] = $gt;
                }
              }

                  echo '<tr>';
                  echo '<td colspan="4" align="left" style="font-size: 16px; font-weight: bold;">Grand Total</td>';
                  echo '<td colspan="2" style="font-size: 16px; font-weight: bold;">Rp '.number_format($gt, 0, ',', '.').'</td>';
                  echo '</tr>';

                  echo '</table>';
                  echo '<a href="laporan_order_pdf.php?id_transaksi='.$nomor.'" class="btn btn-biru btn-circle btn-xl" style="float: right" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a>';
        ?>
  </div>

<?php include 'footer.php'; ?>