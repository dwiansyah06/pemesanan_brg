<?php
if(session_id() == '' || !isset($_SESSION)){session_start();}

  if(!isset($_SESSION["username"])) {
    header("location:index.php");
  } elseif ($_SESSION["level2"] != "superadmin") {
    header("location:404.php");
  }

include 'config.php';
include 'header.php';

if(isset($_POST['submit'])){
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level = $_POST['level'];

  if($level == "Admin"){
	  $level2 = "admin";
  } elseif($level == "Super Admin"){
	  $level2 = "superadmin";
  } elseif($level == "user1" ){
    $level2 = "user";
  } else {
	  $level2="manager";
  }

  $cek_username = $mysqli->query("SELECT username FROM user  WHERE username= '$username'");

  if ($cek_username) {
    if (mysqli_num_rows($cek_username) == 0){
        $result0 = preg_match('/[a-zA-Z]/', $password);
        $result2 = preg_match('/[\d]/', $password);
        $result3 = preg_match('/[`!@#$%^&*()+=\-\[\]\';,.\/{}|":<>?~_\\\\]/', $password);

        $not_passed_parameter = array();
        if (!$result0) {
            $not_passed_parameter[] = "huruf";
        }
        if (!$result2) {
            $not_passed_parameter[] = "angka";
        }
        if (!$result3) {
            $not_passed_parameter[] = "simbol";
        }
        $kalimat = implode(", ",$not_passed_parameter);

        if (count($not_passed_parameter) > 0) {
          $_SESSION['regis'] = "Password yang anda masukan kurang $kalimat";
        } else {
          $query = $mysqli->query("INSERT INTO user (username,password,level,level2,status) VALUES('$username','$password','$level','$level2',0)");
          
          if($query){
              echo '<script>window.alert("User has been Added");window.location=("index.php");</script>'; 
          } else {
              echo '<script>window.alert("Sorry, there is something wrong while saving this file to the database");window.location=("tambah_user.php");</script>';
          }
        }
    } else {
      echo '<script>window.alert("username telah digunakan");window.location=("tambah_user.php");</script>';
    }
  }
}
?>
<div class="container">
  <div class="row">
    <div class="col-md-4"></div>
    <div class="col-md-4">
      <form action="tambah_user.php" method="post" enctype="multipart/form-data" class="form-horizontal" id="form1">
        
        <div class="judul-content" style="margin-top: 10%; margin-bottom: 7%;">
          <center><h2>Add <span>User</span></h2></center>
        </div>
		    
        <?php 
          if (isset($_SESSION['regis'])) { 
        ?>
          <div class="alert alert-danger alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <p><?php echo $_SESSION['regis']; ?></p>
          </div>
        <?php 
          unset($_SESSION['regis']); } 
        ?>

		    <div class="form-group">
          <label class="col-md-4">User Name </label>
            <div class="col-md-8">
              <input type="text" class="form-control mb-20" name="username" required>
            </div>
        </div>
		
		        <div class="form-group">
          <label class="col-md-4">Password </label>
            <div class="col-md-8">
              <input type="password" class="form-control mb-20" name="password" required>
            </div>
        </div>
		
        <div class="form-group">
          <label class="col-md-4">Level</label>
            <div class="col-md-8">
              <?php
                echo "<select name='level' class='form-control mb-20'>";
                  $result = $mysqli->query("SELECT DISTINCT level FROM user ORDER BY level");
                  while($obj = $result->fetch_array()) { ?>
                   <option value="<?php echo $obj['level'] ?>"><?php echo $obj['level'] ?></option>
              <?php 
                  }
                echo "</select>";
              ?>
            </div>
            <p><i> *password harus mengandung huruf, angka, dan simbol.</i> </p>
        </div>
        <input type="submit" name="submit" class="btn btn-biru mb-20 btn-block" value="Add User">
      </form>
    </div>
    <div class="col-md-4"></div>
  </div>   
</div>

<?php include 'footer.php'; ?>