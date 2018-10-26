<?php
  if(session_id() == '' || !isset($_SESSION)){session_start();}
    if(!isset($_SESSION["username"])) {
       echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
    } elseif ($_SESSION["level2"] != "superadmin") {
      header("location:404.php");
    }

  include 'config.php';
  include 'header.php';
?>
    <div class="container">
      <div class="judul-content">
        <center><h2>User <span>Data</span></h2></center>
      </div>
      <table class="table table-hover table-responsive table-bordered" id="dataTabel">
          <thead>
            <tr>
              <th class="text-center"> Nomor </th>
              <th> Username </th>
              <th> Password </th>
              <th> Level </th>
              <th class="text-center"> Status </th>
            </tr>
          </thead>
          <tbody>
          <?php
          include 'config.php';

          $result = $mysqli->query("SELECT * FROM user");

          if($result){
            $i=1;
            while($obj = $result->fetch_object()) { ?>   
                  <tr>
                    <td class="text-center"><?php echo $i; ?></td>
                    <td><?php echo $obj->username ?></td>
                    <td><?php echo $obj->password ?></td>
                    <td><?php echo $obj->level ?></td>
                <?php  
                  if ($obj->status == 1) { 
                    if ($obj->level2 != "superadmin") { ?>
                      <td class="text-center"><a href="proses_kick.php?id_user=<?php echo $obj->id; ?>&usrnm=<?php echo $obj->username; ?>" class="btn btn-success btn-sm"><i class="fa fa-user-times"></i> Kick</a></td>
                  <?php } else { ?>
                      <td class="text-center"><span class="label label-info"><i class="fa fa-check-circle"></i> Online</span></td> 
                  <?php } ?>       
                <?php  } else { ?>
                    <td class="text-center"><span class="label label-danger"><i class="fa fa-times"></i> Offline</span></td>
                <?php } ?>
                  </tr>
          <?php  $i++;
            }
          }
          ?>
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-12">
            <a href="laporan_user_pdf.php" class="btn btn-biru btn-circle btn-xl" style="float: right;" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a>
          </div>
        </div>
    </div>
    
<?php include 'footer.php'; ?>