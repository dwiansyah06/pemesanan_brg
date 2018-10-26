<?php  

	include 'config.php';
	session_start();

	if (isset($_POST['login'])) {
		
		$username = $_POST["username"];
		//mysqli_real_escape_string(stripslashes(strip_tags($_GET["username"])));
		$password = $_POST["password"];
			//mysqli_real_escape_string(stripslashes(strip_tags($_POST["password"])));
		
		$result = $mysqli->query("SELECT * FROM user WHERE username = '$username' ");
		$count = $result->num_rows;
		$get = $result->fetch_object();

		if ($count > 0) {
			if ($username === $get->username && $password === $get->password){
				if ($get->status == 0) {
					$_SESSION["mulai"]  = time();
					$_SESSION['id_user'] 	= 	$get->id;
					$_SESSION['username'] 	= 	$get->username;
					$_SESSION['level'] 		= 	$get->level;
					$_SESSION['level2'] 	= 	$get->level2;
					$id_user = $_SESSION['id_user'];

					$mysqli->query("UPDATE user SET status = '1' WHERE id = '$id_user' AND username = '$username'");
					header("location:index.php");
				} else {
					echo '<script>window.alert("akun sedang dipakai");window.location=("login.php");</script>';
				}
			} elseif ($username === $get->username && $password !== $get->password) {
				$_SESSION['pesan'] = "Your Password was incorrect";
				header("location:login.php");
			}
		} else {
			$result = $mysqli->query("SELECT * FROM user");
			$get = $result->fetch_object();

			if ($username !== $get->username && $password !== $get->password) {
				$_SESSION['pesan'] = "Your Username and Password was incorrect";
				header("location:login.php");	
			} else {
				$_SESSION['pesan'] = "Your Username was incorrect";
				header("location:login.php");
			}
		}
		
	} else {
		header("location:login.php");
	}
?>