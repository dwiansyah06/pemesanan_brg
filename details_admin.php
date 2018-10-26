<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
  if(!isset($_SESSION["username"])) {
     echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
  }elseif ($_SESSION["level2"] != "admin") {
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
      <div class="judul-content">
        <center><h2>Transaction <span><?php echo "$nomor"; ?></span></h2></center>
      </div>
          <table class="table table-hover table-responsive table-bordered">
            <thead>
              <tr>
                <th>ID Transaction</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Units</th>
                <th>Date</th>
  			        <th>Keterangan Manager</th>
                <th>Keterangan IT</th>
              </tr>
            </thead>
            
          <?php
            $nomor = $_GET['id_transaksi'];
			       $result = $mysqli->query("SELECT * FROM approve_it WHERE id_transaksi ='$nomor' ");

             $result2 = $mysqli->query("SELECT * FROM approve WHERE id_transaksi ='$nomor' AND action = 'N' ");
			
              if($result){
                while($obj = $result->fetch_object()) {
                  echo '<tr>';
                  echo '<td>'.$obj->id_transaksi.'</td>';
                  echo '<td>'.$obj->product_code.'</td>';
                  echo '<td>'.$obj->product_name.'</td>';
                  echo '<td>'.$obj->units.'</td>';
                  echo '<td>'.$obj->date.'</td>';
        				  echo '<td>'.$obj->keterangan.'</td>';
                  echo '<td>'.$obj->keteranganti.'</td>';
                  echo '</tr>';
                  $_SESSION['product_code'] = $obj->product_code;
				          $_SESSION['id_transaksi'] = $obj->id_transaksi;
                }
              }

              if($result2){
                while($obj2 = $result2->fetch_object()) {
                  echo '<tr>';
                  echo '<td>'.$obj2->id_transaksi.'</td>';
                  echo '<td>'.$obj2->product_code.'</td>';
                  echo '<td>'.$obj2->product_name.'</td>';
                  echo '<td>'.$obj2->units.'</td>';
                  echo '<td>'.$obj2->date.'</td>';
                  echo '<td>'.$obj2->keteranganmgr.'</td>';
                  echo '<td>'.$obj2->keteranganti.'</td>';
                  echo '</tr>';
                  $_SESSION['product_code'] = $obj2->product_code;
                  $_SESSION['id_transaksi'] = $obj2->id_transaksi;
                }
              }  
          ?>

          </table>
          <?php if(mysqli_num_rows($result) > 0){ ?>
            <a href="suratkerja.php?id_transaksi=<?php echo $nomor ?>" class="btn btn-biru btn-circle btn-xl" style="float: right;" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a>
          <?php } ?>
</div>      
<?php include 'footer.php'; ?>