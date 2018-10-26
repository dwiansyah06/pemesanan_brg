 <?php
  include 'config.php';
  if (isset($_GET['kategori'])) {
    $kategori = $_GET['kategori'];
    $result = $mysqli->query("SELECT * FROM product WHERE kategori ='$kategori' ");
  } elseif (isset($keyword)) {
    $param = '%'.$keyword.'%';
    $result = $mysqli->query(" SELECT * FROM product WHERE product_name LIKE '$param' ");
  } else {
    $result = $mysqli->query('SELECT * FROM product');
  }
?>

          <?php
            if($result) {
              $count = $result->num_rows;
              if($count > 0){
              while($obj = $result->fetch_object()) {
          ?>
          <form action="admin-update.php?id=<?php echo $obj->id ?>&kode=<?php  echo $obj->product_code ?>" method="post" id="<?php echo $obj->id ?>">
            <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
              <div class="panel panel-default">
                <div class="panel-header" style="padding: 25px 25px 25px 25px">
                  <div style="overflow: hidden;max-height: 240px;">
                    <center><img src="asset/images/products/<?php echo $obj->product_img_name; ?>" width="100%;"></center>
                  </div>
                </div>
                <div class="panel-body">
                  <h4 class="text-center" id="judul-product"><strong><?php echo $obj->product_name; ?></strong></h4>
                  <p style="margin-top: 20px;"><strong>Product Code:</strong> <?php echo $obj->product_code ;?></p>
                  <p><strong>Category:</strong> <?php echo $obj->kategori; ?></p>
                  <div class="row ml-0 mr-0 mb-5">
                    <div class="col-sm-6 col-md-6" style="padding-left: 0;">
                      <p><strong>Quantity :</strong> <?php echo $obj->qty; ?> </p>
                    </div>
                    <div class="col-sm-6 col-md-6">
                      <?php  
                        if (isset($_SESSION['pesan-upt'])){
                          if ($_SESSION['id-upt'] == $obj->id) { ?>
                            <i class="fa fa-check-circle" style="color: #337ab7;"></i>
                      <?php unset($_SESSION['pesan-upt']); }
                        }
                      ?>
                    </div>
                  </div>
                  <div class="row ml-0 mr-0">
                    <div class="col-sm-5 col-md-5" style="padding-left: 0">
                      <p><strong>New Qty :</strong></p>
                    </div>
                    <div class="col-sm-7 col-md-7 pd-r-0 pd-l-0">
                      <input type="number" min="1" class="form-control mb-20" name="quantity" required autocomplete="off">
                    </div>
                    <div class="col-sm-12 col-md-12">
                      <center><input type="submit" class="btn btn-biru mb-20" value="Update" name="upd-stok"></center>
                    </div> 
                  </div>
                </div>
              </div>
            </div>  
          </form>
          <?php  
              }
            } else {?>
              <center>
                <div class="empty-cart">
                  <img src="asset/images/result-not-found-12.png" style="width: 45%; margin-top: 0">
                  <h1>Oops No Results Found</h1>
                  <p>looks like you wrong fill the name products.</p>
                </div>
              </center>
        <?php  } }
          ?>