<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}
  if(!isset($_SESSION["username"])) {
    echo '<script>window.alert("Please Login");window.location=("login.php");</script>';
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
      <center><h2>Change <span>Password</span></h2></center>
  </div>

    <form method="POST" action="update_data.php">
      <div class="row">
          <div class="col-md-4"></div>
          <div class="col-md-4">

            <?php if (isset($_SESSION['pesan4'])) { ?>
              <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <p><?php echo $_SESSION['pesan4']; ?></p>
              </div>
            <?php unset($_SESSION['pesan4']); } 
              elseif (isset($_SESSION['pesan6'])) { ?>
                <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <p><?php echo $_SESSION['pesan6']; ?></p>
                </div>
            <?php unset($_SESSION['pesan6']); } ?>
    
            <div class="form-group">
              <label class="col-md-5 control-label">Old Password </label>
                <div class="col-md-7">
                  <input type="password" class="form-control mb-20" name="old_pass" placeholder="Old Password" required>
                </div>
            </div>
            <div class="form-group">
              <label class="col-md-5 control-label">New Password </label>
                <div class="col-md-7">
                  <input type="password" class="form-control mb-20" name="new_pass" placeholder="New Password" required>
                </div>
            </div>
            <div class="form-group">
              <label class="col-md-5 control-label">Re-type Password </label>
                <div class="col-md-7">
                  <input type="password" class="form-control mb-20" name="re_pass" placeholder="Re-type Password" required>
                </div>
                <p><i> *password harus mengandung huruf, angka, dan simbol.</i> </p>
                <input type="submit" value="Update" name="update" class="btn btn-biru btn-block">
            </div>
        </div>
      </div>
    </form>
</div>
<?php include 'footer.php'; ?>