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

$level = $_SESSION['level'];
  $result = $mysqli->query("SELECT DISTINCT id_transaksi,level,level2 FROM approve_it ");

  $result2 = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM approve WHERE action = 'N' ");
?>
<div class="container">
      <div class="judul-content">
          <center><h2>History <span>Transaction</span></h2></center>
      </div>
        <table class="table table-hover table-bordered">
          <thead>
            <tr>
              <th> ID Transaction </th>
              <th> From </th>
              <th> <p align="center" class="mb-0">Status</p> </th>
            </tr>
          </thead>
        
<?php
if (mysqli_num_rows($result) !==0 ) {
    while($obj = $result->fetch_object()) {
      echo "<tr>
              <td><a href='details_admin.php?id_transaksi=".$obj->id_transaksi."' style='text-decoration-line:none;'> ".$obj->id_transaksi."</a></td>
              <td>".$obj->level2."</td>
              <td align='center'><span class='label label-primary'><i class='fa fa-check mr-5'></i>Success</span></td>
          </tr>";
    }
} 

if (mysqli_num_rows($result2) !==0 ) {
    while($obj2 = $result2->fetch_object()) {
      echo "<tr>
              <td><a href='details_admin.php?id_transaksi=".$obj2->id_transaksi."' style='text-decoration-line:none;'> ".$obj2->id_transaksi."</a></td>
              <td>".$obj2->level2."</td>
              <td align='center'><span class='label label-danger'><i class='fa fa-times mr-5'></i>Rejected by me</span></td>
          </tr>";
    }
} 
?>
</table>
</div>
<?php
if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0) { ?>
  <div clalss="container">
    <center>
      <div class="history-cart">
          <img src="asset/images/history.png">
          <h1>Oops History Is Empty</h1>
          <p>looks, like you have no history transaction in your division, Click <a href="products.php">here</a> to make your history.</p>
      </div>
    </center>
  </div>
<?php } include 'footer.php'; ?>