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
  $nomor = $_GET['id_transaksi'];
?>
<div class="container">
<form action="approve_it.php" method="post">
      <div class="judul-content">
        <center><h2>Transaction <span><?php echo $nomor; ?></span></h2></center>
      </div>
          <table class="table table-hover table-bordered table-responsive">
            <thead>
              <tr>
                <th>Code</th>
                <th>Name</th>
                <th>Units</th>
                <th>Stok</th>
                <th>Date</th>
                <th colspan=2>From</th>
        			  <th colspan=2>keterangan Manager</th>
        			  <th colspan=2>keterangan Admin Gudang</th>
              </tr>
            </thead>

      <?php
        $no = 0;

        $result = $mysqli->query("SELECT id,id_transaksi,product_code,product_name,units,price,date,level,action,keteranganmgr FROM approve WHERE id_transaksi ='$nomor' AND action ='B' ");
		
		    // $result3 = $mysqli->query("SELECT id,id_transaksi,product_code,product_name,units,price,date,level,keterangan FROM approve_it WHERE id_transaksi ='$nomor'");

		    // $result4 = $mysqli->query("SELECT id,id_transaksi,product_code,product_name,units,price,date,level,action,keteranganmgr,keteranganti FROM approve WHERE id_transaksi ='$nomor' AND action ='N' ");

        if ($result) {
            while($obj = $result->fetch_object()) {
                $no++;
                echo '<tr>';
                echo '<input type="hidden" name="keranjang['.$no.'][id_transaksi]" value='.$obj->id_transaksi.'>';
                echo '<input type="hidden" name="keranjang['.$no.'][id]" value='.$obj->id.'>';
                echo '<input type="hidden" name="keranjang['.$no.'][product_code]" value='.$obj->product_code.'>';
                echo '<input type="hidden" name="keranjang['.$no.'][price]" value='.$obj->price.'>';
                echo '<td>'.$obj->product_code.'</td>';
                echo '<td>'.$obj->product_name.'</td>';
                echo '<input type="hidden" name="keranjang['.$no.'][units]" value='.$obj->units.'>';
                echo '<td style="width: 7%";><input style="width: 70%;" type="text" class="form-control"  name="keranjang['.$no.'][qty]" value='.$obj->units.'></input></td>';
			  

                $result2 = $mysqli->query("SELECT * FROM product WHERE product_code = '$obj->product_code'");
                  if ($result2) {
                    if($obj2 = $result2->fetch_object()) {
                      echo '<td>'.$obj2->qty.'</td>';
                    }
                  }

                echo '<td>'.$obj->date.'</td>';
                echo '<td colspan="2">'.$obj->level.'</td>';
          			echo '<td colspan="2">'.$obj->keteranganmgr.'</td>';
          			echo '<td colspan=2;style="width: 30%";><input style="width: 100%;" type="text" class="form-control" name="keranjang['.$no.'][keterangan]" value="" required></input></td>';
                echo '</tr>';

              $_SESSION['product_code'] = $obj->product_code;
              $_SESSION['units'] = $obj->units;
			  
            }

                echo '<tr>';
                echo '<td colspan="10"> </td>';
                echo '<td><input style="clear:both;" type="submit" name="approve" class="btn btn-biru" value="Approve">';
    		        echo '<input style="clear:both;float: right;" type="submit" name="batal" class="btn btn-biru" value="Reject"></td>';
                echo '</tr>';
		
		    }		  
		
		    // if($result4){
      //     while($obj = $result4->fetch_object()) {
      //       $no++;
      //         echo '<tr>';
      //         echo '<input type="hidden" name="keranjang['.$no.'][id_transaksi]" value='.$obj->id_transaksi.'>';
      //         echo '<input type="hidden" name="keranjang['.$no.'][id]" value='.$obj->id.'>';
      //         echo '<input type="hidden" name="keranjang['.$no.'][product_code]" value='.$obj->product_code.'>';
      //         echo '<input type="hidden" name="keranjang['.$no.'][price]" value='.$obj->price.'>';
      //         echo '<td>'.$obj->product_code.'</td>';
      //         echo '<td>'.$obj->product_name.'</td>';
      //         echo '<input type="hidden" name="keranjang['.$no.'][units]" value='.$obj->units.'>';
      //         echo '<td style="width: 7%";>'.$obj->units.'</td>';
			  
      // 			  $result2 = $mysqli->query("SELECT * FROM product WHERE product_code = '$obj->product_code'");
      //           if ($result2) {
      //             if($obj2 = $result2->fetch_object()) {
      //               echo '<td>'.$obj2->qty.'</td>';
      //             }
      //           }

      //         echo '<td>'.$obj->date.'</td>';
      //         echo '<td colspan="2">'.$obj->level.'</td>';
      //         echo '<td colspan=2;style="width: 30%";>'.$obj->keteranganmgr.'</td>';
      //         echo '<td colspan=2;style="width: 30%";>'.$obj->keteranganti.'</td>';
      //         echo '</tr>';

      //         $_SESSION['product_code'] = $obj->product_code;
      //         $_SESSION['units'] = $obj->units;
      //     }
      //   }

				// if($result3){
    //       while($obj = $result3->fetch_object()) {
    //         $no++;
    //           echo '<tr>';
    //           echo '<input type="hidden" name="keranjang['.$no.'][id_transaksi]" value='.$obj->id_transaksi.'>';
    //           echo '<input type="hidden" name="keranjang['.$no.'][id]" value='.$obj->id.'>';
    //           echo '<input type="hidden" name="keranjang['.$no.'][product_code]" value='.$obj->product_code.'>';
    //           echo '<input type="hidden" name="keranjang['.$no.'][price]" value='.$obj->price.'>';
    //           echo '<td>'.$obj->product_code.'</td>';
    //           echo '<td>'.$obj->product_name.'</td>';
    //           echo '<input type="hidden" name="keranjang['.$no.'][units]" value='.$obj->units.'>';
    //           echo '<td style="width: 7%";>'.$obj->units.'</td>';
			  
    //   			  $result2 = $mysqli->query("SELECT * FROM product WHERE product_code = '$obj->product_code'");
    //             if ($result2) {
    //               if($obj2 = $result2->fetch_object()) {
    //                 echo '<td>'.$obj2->qty.'</td>';
    //               }
    //             }
		
    //           echo '<td>'.$obj->date.'</td>';
    //           echo '<td colspan="2">'.$obj->level.'</td>';

    //             $keteranganmgr1 = $mysqli->query("SELECT keteranganmgr FROM approve WHERE id_transaksi ='$obj->id_transaksi'");
    //             if ($keteranganmgr1){
    //               if($obj2 = $keteranganmgr1->fetch_object()){
    //                 echo '<td colspan=2;style="width: 30%";>'.$obj2->keteranganmgr.'</td>';
    //               }
    //             }

    //           echo '<td colspan=2;style="width: 30%";>'.$obj->keterangan.'</td>';
    //           echo '</tr>';

    //           $_SESSION['product_code'] = $obj->product_code;
    //           $_SESSION['units'] = $obj->units;
    //       }
    //     }
      ?>

          </table>
</form>
</div>
<?php include 'footer.php'; ?>