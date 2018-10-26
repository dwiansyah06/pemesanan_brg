<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
  if(!isset($_SESSION["username"])) {
     echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
  } elseif ($_SESSION["level2"] != "user") {
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
          <table class="table table-hover table-bordered table-responsive">
            <thead>
              <tr>
                <th>ID Transaction</th>
                <th>Product Code</th>
                <th>Product Name</th>
                <th>Units</th>
                <th>Date</th>
        			  <th>Keterangan Manager</th>
        			  <th>Keterangan TI</th>
              </tr>
            </thead>
            
          <?php
            //melihat detail pesanan yang telah sukses di acc admin
            $result = $mysqli->query("SELECT * FROM approve_it WHERE id_transaksi ='$nomor' ");

             //melihat detail pesanan yang di batalkan oleh manager
			       $result2 = $mysqli->query("SELECT * FROM trash WHERE id_transaksi ='$nomor' and Action='N' ");

            //melihat detail pesanan yang dibatalkan admin
      			$result3 = $mysqli->query("SELECT id_transaksi,product_code,product_name,units,date, keteranganmgr, keteranganti FROM approve WHERE id_transaksi ='$nomor' and Action='N' ");

            //melihat detail pesanan yang masih di review manager
      			$result4 = $mysqli->query("SELECT id_transaksi,product_code,product_name,units,date FROM trash WHERE id_transaksi ='$nomor' and Action='B' ");

            //melihat detail pesanan yang masih di review admin
      			$result5 = $mysqli->query("SELECT id_transaksi,product_code,product_name,units,date,keteranganmgr FROM approve WHERE id_transaksi ='$nomor' and Action='B' ");

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
                }
              }
			  if($result2){
                while($obj = $result2->fetch_object()) {
                  echo '<tr>';
                  echo '<td>'.$obj->id_transaksi.'</td>';
                  echo '<td>'.$obj->product_code.'</td>';
                  echo '<td>'.$obj->product_name.'</td>';
                  echo '<td>'.$obj->units.'</td>';
                  echo '<td>'.$obj->date.'</td>';
				  echo '<td>'.$obj->keterangan.'</td>';
				  echo '<td>Tidak ada keterangan</td>';
                  echo '</tr>';
                  $_SESSION['product_code'] = $obj->product_code;
                }
              }
			   if($result3){
                while($obj = $result3->fetch_object()) {
                  echo '<tr>';
                  echo '<td>'.$obj->id_transaksi.'</td>';
                  echo '<td>'.$obj->product_code.'</td>';
                  echo '<td>'.$obj->product_name.'</td>';
                  echo '<td>'.$obj->units.'</td>';
                  echo '<td>'.$obj->date.'</td>';
				  echo '<td>'.$obj->keteranganmgr.'</td>';
				  echo '<td>'.$obj->keteranganti.'</td>';
                  echo '</tr>';
                  $_SESSION['product_code'] = $obj->product_code;
                }
              }
			  if($result4){
                while($obj = $result4->fetch_object()) {
                  echo '<tr>';
                  echo '<td>'.$obj->id_transaksi.'</td>';
                  echo '<td>'.$obj->product_code.'</td>';
                  echo '<td>'.$obj->product_name.'</td>';
                  echo '<td>'.$obj->units.'</td>';
                  echo '<td>'.$obj->date.'</td>';
				  echo '<td>Belum ada keterangan</td>';
				  echo '<td>Belum ada keterangan</td>';
                  echo '</tr>';
                  $_SESSION['product_code'] = $obj->product_code;
                }
              }
			  if($result5){
                while($obj = $result5->fetch_object()) {
                  echo '<tr>';
                  echo '<td>'.$obj->id_transaksi.'</td>';
                  echo '<td>'.$obj->product_code.'</td>';
                  echo '<td>'.$obj->product_name.'</td>';
                  echo '<td>'.$obj->units.'</td>';
                  echo '<td>'.$obj->date.'</td>';
				  echo '<td>'.$obj->keteranganmgr.'</td>';
				  echo '<td>Belum ada keterangan</td>';
                  echo '</tr>';
                  $_SESSION['product_code'] = $obj->product_code;
                }
              }
          ?>
          </table>
</div>      
<?php include 'footer.php'; ?>