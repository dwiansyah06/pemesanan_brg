<?php
  if(session_id() == '' || !isset($_SESSION)){session_start();}
    if(!isset($_SESSION["username"])) {
       echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
    } elseif ($_SESSION["level2"] != "admin") {
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

  $result = $mysqli->query("SELECT DISTINCT id_transaksi,level,action FROM approve WHERE action = 'B'");

  ?>
<div class="container">
          <?php
  
  if (mysqli_num_rows($result) !==0 ) { ?>
  <div class="judul-content">
        <center><h2>Data <span>Transaction</span></h2></center>
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
              while($obj = $result->fetch_object()) {
                echo "    
                    <tr>
                      <td width=25%><a href='details.php?id_transaksi=".$obj->id_transaksi."' style='text-decoration-line:none;'> ".$obj->id_transaksi."</a></td>
                      <td width=55%>".$obj->level."</td>   
                      <td width=20% align='center'><span class='label label-warning'>Pending</span></td>    
                    </tr> ";
              }
          ?>

          </table>
</div>
<?php }
else { ?>
  <div class="container">
   <center>
      <div class="empty-cart">
        <img src="asset/images/img-no-cartitems.png">
        <h1>Oops Request Is Empty</h1>
        <p>looks, like you have no request in this time.</p>
      </div>
  </center>
  </div>
<?php } ?>

<?php include 'footer.php'; ?>
