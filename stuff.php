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
            <center><h2 style="margin-top: 9%; margin-bottom: 6%;">Data <span>Stuff</span></h2></center>
          </div>
          <table class="table table-hover table-responsive table-bordered" id="dataTabel">
            <thead>
              <tr>
                <th class="text-center"> Number </th>
                <th> Product Code </th>
                <th> Product Name </th>
                <th><center> Quantity </center></th>
                <th class="text-center"> Price </th>
                <th><center> Action </center></th>
              </tr>
            </thead>
            <tbody>
        <?php
            $result = $mysqli->query("SELECT id, product_code, product_name, qty, price,product_img_name FROM product");
            
            $i = 1;
            if($result){
              while($obj = $result->fetch_object()) {
                echo "    
                    <tr>
                    <input type='hidden' name='id' value=".$obj->id." />
                    <td class='text-center'>".$i."</td>
                    <td>".$obj->product_code."</td>
                    <td>".$obj->product_name."</td>
                    <td><center>".$obj->qty."</center></td>
                    <td> Rp ".number_format($obj->price, 0, ',', '.')."</td>
                    <td><center><a class='btn btn-merah btn-circle' style='padding:5px;' href='delete.php?id=".$obj->id."&code=".$obj->product_code."' OnClick=\"return confirm('Are You Sure Want to delete?');\"><span class='fa fa-trash-o'></span></a>
                        <a class='btn btn-ijo btn-circle' style='padding:5px;' href='edit.php?id=".$obj->id."&code=".$obj->product_code."'><span class='fa fa-pencil'></span></a></center></td>
                    
                    </tr> ";
            $i++;  
              }
            }
        ?>            
        </tbody>
          </table>
            <a href="laporan_stuff_pdf.php" class="btn btn-biru btn-circle btn-xl" style="float: right;" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a>
      </div>
<?php include 'footer.php'; ?>