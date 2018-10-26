<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
error_reporting(E_ALL^(E_NOTICE|E_WARNING));
  if(!isset($_SESSION["username"])) {
     echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
  } elseif ($_SESSION["level2"] != "manager") {
    header("location:404.php");
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
$nomor = $_GET['id_transaksi'];
?>
<div class="container">
  <form action="approve_manager.php" method="post">
      <div class="judul-content">
        <center><h2>Order <span><?php echo "$nomor"; ?></span></h2></center>
      </div>
          <table class="table table-hover table-responsive table-bordered">
            <thead>
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Units</th>
                <th>Dates</th>
  			        <th colspan=2>keterangan</th>
              </tr>
            </thead>
        
        <?php
            $no = 0;
            $level = $_SESSION['level'];
            $total = 0;

            $data = array($result = $mysqli->query("SELECT * FROM trash WHERE id_transaksi ='$nomor' "));
            
            if($result){
              while($obj = $result->fetch_object()) {
              $no++;

              echo "    
                  <tr>
                  <input type='hidden' name='keranjang[".$no."][id]' value='$obj->id'>
                  <input type='hidden' name='keranjang[".$no."][id_transaksi]' value='$obj->id_transaksi'>
                  <input type='hidden' name='keranjang[".$no."][product_code]' value='$obj->product_code'>
                  <td>".$obj->product_code."</td>
                  <td>".$obj->product_name."</td>
                  <td style='width: 7%';>".$obj->units."</td>
                  <td style='width: 20%'>".$obj->date."</td> 
				  
                  <td colspan=2;style='width: 30%';><input style='width: 100%;' type='text' class='form-control' name='keranjang[".$no."][keterangan]' required></input></td>
                  </tr> ";
                  $_SESSION['id'] = $obj->id;
                  $_SESSION['product_code'] = $obj->product_code;
                  $_SESSION['units'] = $obj->units;
                }
              }

          echo '<tr>';
          echo '<td colspan="4"></td>';
		      echo '<td>';
          echo '<input style="clear:both;" type="submit" name="approve" class="btn btn-biru" value="Approve">';
		      echo '<input style="clear:both;float:right" type="submit" name="batal" class="btn btn-biru" value="Reject"> </td>';
          echo '</tr>';
        ?>
        
          </table>
  </form>
</div>
<?php include 'footer.php'; ?>