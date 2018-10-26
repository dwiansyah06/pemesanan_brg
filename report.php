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
?>
  <div class="container">
		<div class="judul-content">
      <center><h2 style=" margin-bottom: 5%;">Transaction <span>Report</span></h2></center>
    </div>
    <form method="post" action="report.php" style="border-bottom: 2px solid #da251c; margin-bottom: 2%;">
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="dtp_input2" class="col-md-2 control-label">Start</label>
          <div class="input-group date start col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="start" data-link-format="yyyy-mm-dd">
            <input class="form-control" size="16" type="text" value="" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          </div>
          <input type="hidden" id="start" value="" name="start" /><br/>
        </div> <br>
        <div class="form-group">
          <label for="dtp_input2" class="col-md-2 control-label">Finish</label>
          <div class="input-group date finish col-md-5" data-date="" data-date-format="dd MM yyyy" data-link-field="finish" data-link-format="yyyy-mm-dd">
            <input class="form-control" size="16" type="text" value="" readonly>
            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
          </div>
          <input type="hidden" id="finish" value="" name="finish" /><br/>
        </div>
      </div>      

      <div class="col-md-6" style="margin-bottom: 20px;">
        <h4 style="margin-top: 0"><span class="fa fa-users"></span> Pilih Level</h4>
        <?php  
          $query = $mysqli->query("SELECT level FROM user WHERE level2='user'");
          while ($obj = $query->fetch_object()) { ?>
          <input type="checkbox" name="level[]" value="<?php echo $obj->level; ?>"> <?php echo "$obj->level <br>"; ?>
        <?php  
          }
        ?>
        <input type="submit" name="filter" class="btn btn-primary btn-block mt-10" value="Filter">
      </div>
    </div>
  </form>

<?php
  $level = $_SESSION['level'];
  if (isset($_POST['filter'])) {
      // if (isset($_POST['start']) && isset($_POST['finish'])) {
      //   echo $_POST['start'];
      //   echo $_POST['finish'];
      // } elseif (isset($_POST['level'])) {
      //   $level_bru = $_POST['level'];
      //   $lvl = implode(", ",$level_bru);
      //   echo $lvl;
      // }
    $start = $_POST['start'];
    $finish = $_POST['finish'];
    $_SESSION['start'] = $start;
    $_SESSION['finish'] = $finish;

    $mulai = date('d F Y', strtotime($start));
    $akhir = date('d F Y', strtotime($finish));

    if (isset($_POST['level'])) {
      $level_bru = $_POST['level'];
      $lvl = implode(", ",$level_bru);
      $level_filter = "'".implode("','" ,$level_bru)."'";
      
      $_SESSION['level_filter'] = $level_filter;
      $result = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM approve_it WHERE date BETWEEN '$start' AND '$finish' AND level2 in($level_filter) ORDER BY id_transaksi ASC");
    } else {
      $result = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM approve_it WHERE date BETWEEN '$start' AND '$finish' ORDER BY id_transaksi ASC");
    }
  } else {
    $result = $mysqli->query("SELECT DISTINCT id_transaksi,level2 FROM approve_it ORDER BY id_transaksi ASC");
  }
?>

  <table class="table table-hover table-responsive table-bordered" id="dataTabel">
    <thead>
      <p>Periode: <strong><?php if(isset($_POST['filter'])){echo "$mulai - $akhir";}else{echo "Setiap Hari";} ?></strong></p>
      <tr>
        <th> Number </th>
        <th> ID Transaction </th>
        <th> Divisi </th>
        <th> <p align="center" class="mb-0">Status</p> </th>
      </tr>
    </thead>
    <tbody>
      <?php 
          if($result){
            $i=1;
            while($obj = $result->fetch_object()) {
              echo "    
                <tr>
                  <td>".$i."</td>
                  <td><a href='details_report.php?id_transaksi=".$obj->id_transaksi."' style='text-decoration-line:none;' target='_blank'> ".$obj->id_transaksi."</a></td>
                  <td>".$obj->level2."</td>   
                  <td align='center'><span class='label label-primary'><i class='fa fa-check mr-5'></i>Success</span></td>
                </tr> ";
              $i++;
            }
          }
        ?>
    </tbody>
  </table>   

  <div class="form-group">
    <table align='right'>
      <tr>
        <td align='center' width="50%"> Laporan per transaksi</td>
        <td align='center' width="50%"> Laporan pemakaian per divisi</td>
      </tr>
      <tr>
        <td align = 'center' width="50%"> <a href="laporan_transactions.php?tgl_start=<?php if(isset($_POST['filter'])){echo $start;}else{echo "all";}?>&tgl_finish=<?php if(isset($_POST['filter'])){echo $finish;}else{echo "all";}?>&level=<?php if(isset($_POST['level'])){echo $lvl;}else{echo "all";}?>" class="btn btn-biru btn-circle btn-xl" style="float: center;" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a>
        </td>
        <td align = 'center' width="50%"><a href="laporan_pemakaian.php?tgl_start=<?php if(isset($_POST['filter'])){echo $start;}else{echo "all";}?>&tgl_finish=<?php if(isset($_POST['filter'])){echo $finish;}else{echo "all";}?>&level=<?php if(isset($_POST['level'])){echo $lvl;}else{echo "all";}?>" class="btn btn-biru btn-circle btn-xl" style="float: center;" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a>
        </td>
      </tr>
   </table>
  </div>
</div>
<?php include 'footer.php'; ?>