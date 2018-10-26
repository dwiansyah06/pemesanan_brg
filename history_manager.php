<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
  if(!isset($_SESSION["username"])) {
     echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
  }

  if($_SESSION["level2"]!="manager") {
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
  $result = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM approve_it WHERE level = '$level'");
  
  $result2 = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM approve WHERE level = '$level' AND action ='B'");
  
  $result3 = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM trash WHERE level = '$level' AND action ='N'");
  
  $result4 = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM approve WHERE level = '$level' AND action ='N'");

?>

  <div class="container">
      <div class="judul-content">
        <center><h2>History <span>Transaction</span></h2></center>
      </div>
          <table class="table table-hover table-responsive table-bordered">
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
      echo "    
          <tr>
            <td><a href='details_manager.php?id_transaksi=".$obj->id_transaksi."' style='text-decoration-line:none;'> ".$obj->id_transaksi."</a></td>
            <td>".$obj->level2."</td>
            <td align='center'><span class='label label-primary'><i class='fa fa-check mr-5'></i>Success</span></td>
          </tr> ";
    } 
  }

  if (mysqli_num_rows($result2) !==0 ) {
    while($obj = $result2->fetch_object()) {
     echo "<tr>
              <td><a href='details_manager.php?id_transaksi=".$obj->id_transaksi."' style='text-decoration-line:none;'> ".$obj->id_transaksi."</a></td>
	            <td>".$obj->level2."</td>
              <td align='center'><span class='label label-warning'>Pending In TI</span></td>
          </tr>";
    }
  }

  if (mysqli_num_rows($result3) !==0 ) {
    while($obj = $result3->fetch_object()) {
      echo "<tr>
              <td><a href='details_manager.php?id_transaksi=".$obj->id_transaksi."' style='text-decoration-line:none;'> ".$obj->id_transaksi."</a></td>
	            <td>".$obj->level2."</td>
              <td align='center'><span class='label label-danger'><span class='fa fa-times'></span> Rejected by Me</span></td>
          </tr>";
    }
  }

  if (mysqli_num_rows($result4) !==0 ) {
    while($obj = $result4->fetch_object()) {
      echo "<tr>
              <td><a href='details_manager.php?id_transaksi=".$obj->id_transaksi."' style='text-decoration-line:none;'> ".$obj->id_transaksi."</a></td>
	            <td>".$obj->level2."</td>
              <td align='center'><span class='label label-danger'><span class='fa fa-times'></span> Rejected by TI</span></td>
          </tr>";
    }
  } 
?>

          </table>
  </div>

<?php
  if(mysqli_num_rows($result) == 0 && mysqli_num_rows($result2) == 0 && mysqli_num_rows($result3) == 0 && mysqli_num_rows($result4) == 0) { 
?>

  <div class="container">
    <center>
      <div class="history-cart">
          <img src="asset/images/history.png">
          <h1>Oops History Is Empty</h1>
          <p>looks, like you have no history transaction in your division.</p>
      </div>
    </center>
  </div>
<?php } ?>
<div class="container">
<a href="laporan_pemakaian_divisi.php" class="btn btn-biru btn-circle btn-xl" style="float: right;" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a>
</div>
<?php include 'footer.php'; ?>