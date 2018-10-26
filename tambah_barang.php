<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
  if(!isset($_SESSION["username"])) {
    header("location:index.php");
  } elseif ($_SESSION["level2"] != "admin") {
    header("location:404.php");
  }

include 'config.php';
$id_user = $_SESSION['id_user'];
$uname = $_SESSION['username'];
$tgl = date('Y-m-d');
$status_query = $mysqli->query("SELECT status FROM user WHERE id ='$id_user' AND username = '$uname' ");

$get_s = $status_query->fetch_object();
if ($get_s->status == '0') {
  header("location:kick.php");
}

include 'header.php';

if(isset($_POST['submit'])){
  $nama_foto = $_FILES['gambar']['name'];
  $extensi = explode(".", $nama_foto);
  $foto_bru = "item-".round(microtime(true)).".".end($extensi); 
  // $format = pathinfo($nama_foto, PATHINFO_EXTENSION);
  // if ($format === "jpg") {
    $name = $_POST['product_name'];
    $cek_product_name = $mysqli->query("SELECT * FROM product WHERE product_name= '$name'");
    if ($cek_product_name) {
      ($obj = $cek_product_name->fetch_object());
        if ($obj->product_name !== $name) {
          $user = $_SESSION["username"];
          $level = $_SESSION["level"];
          $kategori = $_POST['kategori'];
          
          $totalkode =  $mysqli->query("SELECT COUNT(*) from product where kategori ='$_POST[kategori]' "); 
          $ambilkode = $mysqli->query("SELECT kode FROM kategori where kategori = '$_POST[kategori]'");
          $fe1=$ambilkode->fetch_array();
          $fe=$totalkode->fetch_array();
          $jumlah = intval($fe['COUNT(*)'])+1;
          // echo $fe1['kode'],$jumlah;
          
          $fit = $_POST['fit_on'];
          $size = $_FILES['gambar']['size'];   
          $error = $_FILES['gambar']['error'];   
          $asal = $_FILES['gambar']['tmp_name'];
          $kuantiti = $_POST['qty'];
          $harga = $_POST['price']; 

          $query = $mysqli->query("INSERT INTO product (product_code,kategori, cocok, product_name, product_img_name, qty, price) VALUES('$fe1[kode]$jumlah','$kategori','$fit', '$name','$foto_bru', $kuantiti, '$harga')");

          $update2 = $mysqli->query("INSERT INTO history_product (product_code, product_name, masuk, keluar, qty, price,cocok,gambar, username, level, keterangan,tanggal) VALUES ('$fe1[kode]$jumlah','$name','$kuantiti','0','$kuantiti','$harga','$fit','$foto_bru','$user','$level', 'Penambahan barang','$tgl')");
 
          if($query){
            move_uploaded_file($asal, "asset/images/products/".$foto_bru);
            // $lokasi = $nama_foto;
            // move_uploaded_file($asal, "asset/images/products/".$nama_foto); 
            // $asli1 = "asset/images/products/"; 
            // $asli2 = $asli1.$nama_foto;
              
            // $gambar_asli  = imagecreatefromjpeg ($asli2);
            // $lebar_asli   = imageSX($gambar_asli);
            // $tinggi_asli  = imageSY($gambar_asli);

            // $lebar_baru = 620; 
            // $tinggi_baru = 620;
             
            // $img = imagecreatetruecolor($lebar_baru, $tinggi_baru);
            // imagecopyresampled($img, $gambar_asli, 0, 0, 0, 0, $lebar_baru, $tinggi_baru, $lebar_asli, $tinggi_asli);
              
            // imagejpeg($img,$asli1.$nama_foto);

            echo '<script>window.alert("Your Stuff has been Added");window.location=("index.php");</script>'; 
          }else{
            echo '<script>window.alert("Sorry, there is something wrong while saving this file to the database");window.location=("tambah_barang.php");</script>';
          }

        } else {
          echo '<script>window.alert("produk tersebut telah ada");window.location=("tambah_barang.php");</script>';
        }
    }
  // } else {
  //   echo '<script>window.alert("format gambar harus jpg");window.location=("tambah_barang.php");</script>';
  // }
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <form action="tambah_barang.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="form1">
        
        <div class="judul-content" style="margin-top: 10%; margin-bottom: 7%;">
          <center><h2>Add <span>Stuff</span></h2></center>
        </div>
		
        <div class="form-group">
          <label class="col-md-4 control-label">Category </label>
            <div class="col-md-8">
              <?php
                echo "<select name='kategori' class='form-control mb-20'>";
                  $result = $mysqli->query("SELECT * FROM kategori ORDER BY id");
                  while($obj = $result->fetch_object()) {
                    echo "<option value=$obj->kategori> $obj->kategori </option>";
                  }
                echo "</select>";
              ?>
            </div>
        </div>
		
		
        <div class="form-group">
          <label class="col-md-4 control-label">Product Name </label>
            <div class="col-md-8">
              <input type="text" class="form-control mb-20" name="product_name" required>
            </div>
        </div>   
          
        <div class="form-group">
          <label class="col-md-4 control-label">Fit on </label>
            <div class="col-md-8">
              <input type="text" class="form-control mb-20" name="fit_on" required>
            </div>
        </div>
        
        <div class="form-group">
          <label class="col-md-4 control-label"> Quantity </label>
            <div class="col-md-8">
              <input type="number" class="form-control mb-20" name="qty" required>
            </div>
        </div> 
         
        <div class="form-group">
          <label class="col-md-4 control-label"> Picture (.jpg)</label>
            <div class="col-md-8">
              <div id="hilang"><img src="asset/images/tambah.png" style="width: 100%;margin-bottom: 10px;"></div>
              
              <div id="hasil" style="display: none;"><img src="#" id="tampil" style="width: 100%;margin-bottom: 10px;"></div>

              <input type="file" class="form-control mb-20" name="gambar" id="upload" required>
            </div>
        </div> 
        
        <div class="form-group">
          <label class="col-md-4 control-label"> Price </label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="price" required>
            </div>
        </div>
         
        <input type="submit" name="submit" class="btn btn-biru btn-block mb-20" value="Add Stuff" style="float: right;">
      </form>

      <!-- Add Kategori -->
      <form class="gone" id="form2" action="tambah_kategori.php" method="post">
        <div class="judul-content" style="margin-top: 10%; margin-bottom: 7%;">
          <center><h2>Add <span>Category</span></h2></center>
        </div>
        <div class="form-group">
          <label class="col-md-5 control-label"> Nama Kategori </label>
            <div class="col-md-7">
              <input type="text" class="form-control mb-20" name="kategori" required>
            </div>
        </div>
        <div class="form-group">
          <label class="col-md-5 control-label"> Kode Kategori </label>
            <div class="col-md-7">
              <input type="text" class="form-control mb-20" name="kode_kategori" required>
            </div>
        </div>
        <input type="submit" name="btn_kategori" class="btn btn-biru btn-block mb-20" value="Add Category">
      </form>

      <div class="form-group">
        <div class="col-md-12">
            <div class="checkbox">
              <label>
                <input type="checkbox" onClick="gone(this)"> if the category is not in the list
              </label>
            </div>
        </div>
      </div>

    </div>
    <div class="col-md-4"></div>
  </div>   
</div>

<?php include 'footer.php'; ?>