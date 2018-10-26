<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
  if(!isset($_SESSION["username"])) {
     echo '<script>window.alert("Sorry, You should login first");window.location=("index.php");</script>';
  } elseif ($_SESSION["level2"] != "user") {
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
      <center><h2>Products </h2></center>
  </div>
  <div class="row" id="row-search">
    <div class="col-xs-9 col-sm-10 col-md-10 pd-r-0">
      <input type="text" placeholder="Search" class="form-control" id="keyword" style="border-radius: 0; border: 1px solid #337ab7;">
    </div>
    <div class="col-xs-3 col-sm-2 col-md-2 pd-l-0">
      <div class="btn-group">
        <button type="button" class="btn btn-biru" id="btn-search"><i class="fa fa-search"></i></button>
        <button class="btn btn-biru" id="btn-reset"><a href="products.php"><span class="fa fa-times" style="color: #fff;"></a></span></button>
        <button type="button" id="btn-category" class="btn btn-biru dropdown-toggle dropdown-toggle-split" data-toggle="dropdown"><span class="fa fa-angle-down"></span></button>
        <ul class="dropdown-menu" role="menu">
        <?php
          $result2 = $mysqli->query("SELECT * FROM kategori");

          if ($result2) {
            while ($obj2 = $result2->fetch_object()) {
                echo '<input type="hidden" name="kategori" value='.$obj2->kategori.'>';
                echo '<li><a href="products.php?kategori='.$obj2->kategori.'">'.$obj2->kategori.'</a></li>';
            }
          }
        ?>
        </ul>
      </div>
    </div>
  </div>

    <div class="row" style="margin-top:70px;">
       <div class="view"><?php include "view.php"; ?></div>
    </div>
</div>
<?php include 'footer.php'; ?>