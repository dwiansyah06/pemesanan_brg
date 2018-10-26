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
  $i=0;
  $product_id = array();
  $product_quantity = array();
        
  if($result){
    $count = $result->num_rows;
    if($count > 0){
      while($obj = $result->fetch_object()) { ?>
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
              <p id="cocok"><strong>Fit On:</strong> <?php echo $obj->cocok; ?> </p>
              <br>
              <?php if($obj->qty == 0){ ?>
                <center><a href="" class="btn btn-merah disabled"><span class="fa fa-times mr-3"></span> Empty Stock</a></center>
              <?php } else { ?>
                <center><a href="update-cart.php?action=add&id=<?php echo $obj->id; ?>" class="btn btn-biru"><span class="fa fa-shopping-cart mr-3"></span> Add to Cart</a></center>
              <?php } ?>
            </div>
          </div>
        </div>

    <?php $i++;
      }
    } else { ?>
      <center>
        <div class="empty-cart">
          <img src="asset/images/result-not-found-12.png" style="width: 45%; margin-top: 0">
          <h1>Oops No Results Found</h1>
          <p>looks like you wrong fill the name products.</p>
        </div>
      </center>
<?php }
  }
  $_SESSION['product_id'] = $product_id; 
    ?>