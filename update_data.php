<?php
	//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
	if(session_id() == '' || !isset($_SESSION)){session_start();}

if (isset($_POST['update'])) {
	include 'config.php';
	$id = $_SESSION['id_user'];
	$old = $_POST['old_pass'];
	$new = $_POST['new_pass'];
	$re  = $_POST['re_pass'];

	$result = $mysqli->query("SELECT * FROM user WHERE id = '$id' ");
	$get = $result->fetch_object();
	if ($result) {
		if ($old === $get->password) {
			if ($new === $re) {
				$result0 = preg_match('/[a-zA-Z]/', $new);
				$result2 = preg_match('/[\d]/', $new);
				$result3 = preg_match('/[`!@#$%^&*()+=\-\[\]\';,.\/{}|":<>?~_\\\\]/', $new);

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
				    $_SESSION['pesan4'] = "Password yang anda masukan kurang $kalimat";
				    header("location:profile.php");
				} else {
					$query = $mysqli->query('UPDATE user SET password ="'. $new .'" WHERE id ='.$_SESSION['id_user']);
					if ($query) {
						$_SESSION['pesan6'] = "Success for update password";
				    	header("location:profile.php");	
					}
				}
			} else {
				$_SESSION['pesan4'] = "password tidak sama";
				header("location:profile.php");	
			}
		} else {
			$_SESSION['pesan4'] = "password tidak sesuai dengan yang lama";
			header("location:profile.php");	
		}
	}

} else {
	header("location:profile.php");
}

?>