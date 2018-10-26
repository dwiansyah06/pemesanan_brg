<?php

//if (session_status() !== PHP_SESSION_ACTIVE) {session_start();}
if(session_id() == '' || !isset($_SESSION)){session_start();}

include 'config.php';

$username = $_POST["username"];
$password = $_POST["pwd"];
$flag = 'true';
//$query = $mysqli->query("SELECT email, password from users");

$result = $mysqli->query('SELECT id,username,password,level,level2 from user order by id asc');

if($result === FALSE){
  die(mysql_error());
}

if($result){
  while($obj = $result->fetch_object()){
    if($obj->username === $username && $obj->password === $password) {

      $_SESSION['username'] = $username;
      $_SESSION['id'] = $obj->id;
      $_SESSION['level'] = $obj->level;
      $_SESSION['level2'] = $obj->level2;
      header("location:index.php");
    } else {

        if($flag === 'true'){
          redirect();
          $flag = 'false';
        }
    }
  }
}

function redirect() {
  echo '<script>window.alert("Your Username or Password was incorrect");window.location=("login.php");</script>';
}


?>
