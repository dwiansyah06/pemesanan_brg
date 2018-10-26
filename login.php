<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
if(isset($_SESSION["username"])){
  header("location:index.php");
}

?>

<!doctype html>
<html class="no-js" lang="en">
  <head>
    <title>Login || Pemesanan Barang</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" type="text/css" href="asset/css/bootstrap.min.css">
  </head>
  <body style="background: #f5f5f5">
<br>
<div class="container">
<div class="loader">
  <div class="loader_html"></div>
</div>

<div class="row">
  <div class="col-sm-4 col-md-4"></div>
  <div class="col-sm-4 col-md-4">

  <div class="panel panel-default" style="margin-top: 130px;">
    <div class="panel-heading">
      <center><h3 class="panel-title">Login</h3></center>
    </div>
    <div class="panel-body">
          <?php  
            if (isset($_SESSION['pesan'])) { ?>
              <div class="alert alert-danger alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <p><?php echo $_SESSION['pesan']; ?></p>
              </div>
          <?php unset($_SESSION['pesan']); }?>
        <form method="post" action="proses_login.php">
          <label for="username">Username</label>
            <input type="text" id="username" class="form-control wdth-100" style="margin-bottom: 20px;" name="username" autocomplete="off" required>

          <label for="password">Password</label>
            <input type="password" id="password" class="form-control wdth-100" style="margin-bottom: 20px;" name="password" autocomplete="off" required>

          <input type="submit" name="login" id="right-label" value="Log In" style="background: #32599C; border: none; color: #fff; font-family: 'Helvetica Neue', sans-serif; font-size: 1em; padding: 10px;" class="btn btn-block">
      </form>

    </div>
  </div>
    <center><p>&copy; Lorem ipsum dolor sit amet, consectetur.</p></center>
  </div>
  <div class="col-sm-4 col-md-4"></div>
</div>

</div>
    <script src="asset/js/vendor/jquery.js"></script>
    <script src="asset/js/vendor/bootstrap.min.js"></script>
    <script>
      $(window).load(function(){
        $(".loader").fadeOut("slow");
      });
    </script>
  </body>
</html>
