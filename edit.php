<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
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

// ambil variabel dari database
  $id = $_GET['id'];
  $kode =$_GET['code'];

  $query = $mysqli->query("SELECT * FROM product WHERE id = '$id' AND product_code = '$kode'");
  $get = $query->fetch_object();

  //value
  $nama = $get->product_name;
  $cocok = $get->cocok;
  $gambar = $get->product_img_name;
  $harga = $get->price;
?>
  <div class="container">
    <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-5">
          <form method="POST" action="update_barang.php" enctype="multipart/form-data">
             <div class="judul-content" style="margin-top: 10%; margin-bottom: 7%;">
                  <center><h2>Update <span>Items</span></h2></center>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Product Code</label>
                  <div class="col-md-8">
                    <input type="hidden" value="<?php echo $id ?>" name="id">
                    <input type="hidden" name="kode" value="<?php echo $kode ?>">
                    <input  class="form-control mb-20" placeholder="<?php echo $kode ?>"readonly>
                  </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Product Name</label>
                <div class="col-md-8">
                  <input type="text" class="form-control mb-20" placeholder="<?php echo $nama ?>" name="nama">
                </div>
              </div>

              <div class="form-group">
                  <label class="col-md-4 control-label">Cocok</label>
                <div class="col-md-8">
                  <label class="control-label"><?php echo $cocok ?></label>
                  <input type="text" class="form-control mb-20" placeholder="Cocok" name="cocok">
                </div>
              </div>

              <div class="form-group">
                  <label class="col-md-4 control-label">Price</label>
                <div class="col-md-8">
                  <input type="text" class="form-control mb-20" placeholder="<?php echo $harga ?>" name="harga">
                </div>
              </div>

              <div class="form-group">
                <label class="col-md-4 control-label">Gambar Produk</label>
                <div class="col-md-8">
                  <div id="hilang"><img src="asset/images/products/<?php echo $gambar; ?>" style="width: 100%;margin-bottom: 10px;"></div>
                  <div id="hasil" style="display: none;"><img src="#" id="tampil" style="width: 100%;margin-bottom: 10px;"></div>

                  <input type="file" class="form-control mb-20" name="gambar" id="upload">
                </div>
              </div>
              <input type="submit" class="btn btn-biru btn-block" value="Update">
            </form>
        </div>
        <div class="col-md-3"></div>
    </div>
  </div>
<?php
  include 'footer.php';
?>
  </body>
</html>
