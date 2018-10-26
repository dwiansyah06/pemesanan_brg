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
        <center><h2>History Product <span>Report</span></h2></center>
      </div>
          <table class="table table-hover table-responsive table-bordered" id="dataTabel">
            <thead>
              <tr>
                <th> Number </th>
                <th> Product Name </th>
        				<th> Barang Masuk </th>
        				<th> Barang Keluar </th>
        				<th> Sisa Stok Barang </th>
                <th> Harga </th>
                <th> Cocok </th>
                <th> Gambar </th>
        				<th> Request From </th>
        				<th> Divisi </th>
        				<th> Keterangan </th>
                <th> Tanggal </th>
              </tr>
            </thead>
            <tbody>
        <?php
          $level = $_SESSION['level'];
          $result = $mysqli->query("SELECT * FROM history_product");
            
            if($result){
              $i=1;
              while($obj = $result->fetch_object()) {
                echo "    
                    <tr>
                      <td class='text-center'>".$i."</td>
                      <td>".$obj->product_name."</td>
          					  <td class='text-center'>".$obj->masuk."</td>
          					  <td class='text-center'>".$obj->keluar."</td>
          					  <td class='text-center'>".$obj->qty."</td>
                      <td>Rp ".number_format($obj->price, 0, ",", ".")."</td>
                      <td>".$obj->cocok."</td>
                      <td>".$obj->gambar."</td>
          					  <td>".$obj->username."</td>
          					  <td>".$obj->level."</td>
          					  <td>".$obj->keterangan."</td>
                      <td>".$obj->tanggal."</td>
                    </tr> ";
              $i++;
              }
            }
        ?>
            </tbody>

          </table>
		  <table align= 'right'>
		  <tr>
		  <td align = 'center' width="50%">
		  <a href="laporan_history_barang.php" class="btn btn-biru btn-circle btn-xl" style="float: center;" target="_blank"><span class="fa fa-file-pdf-o" style="margin-left: 5px;"></span></a></td>
		  </tr>
		  </table>
		  
    </div>
<?php include 'footer.php'; ?>