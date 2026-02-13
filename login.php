<?php
include ('_inc/inc.config.php');
ob_start();
session_start();

$now = time();
if (isset($_SESSION['discard_after']) && $now > $_SESSION['discard_after']) {
    // this session has worn out its welcome; kill it and start a brand new one
    session_unset();
    session_destroy();
    session_start();
}

// either new or old, it should live at most for another hour
$_SESSION['discard_after'] = $now + 3600;

$error=''; 
if (isset($_POST['submit'])) {
	if (empty($_POST['email']) || empty($_POST['password'])) {
		$error = "Email or Password is missing";
	} else {
		/* session_start(); */
		$email = $_POST['email'];
		$password = md5($_POST['password']);
		$email = stripslashes($email);
		$password = stripslashes($password);
		$email = mysqli_real_escape_string($link, $email);
		$password = mysqli_real_escape_string($link, $password);
		$result = $link->query("SELECT * FROM login WHERE password='$password' AND email='$email'");
    $rows = mysqli_num_rows($result);
    
		if ($rows == 1) {
      $_SESSION['login_user']=$email; 
			header("Refresh:0");
		} else {
			$error = "Email or Password is invalid";
		}
		$result->close(); 
	}
}
if(!isset($login_session)){
//	$ses_sql->close();
//	header('Location: '.$esroot.'certifications');
}
?>