<?php
include ('_inc/inc.config.php');
@ob_start();
if(!isset($_SESSION)) 
{ 
	session_start(); 
}
$user_check = $_SESSION['login_user'];
$ses_sql = $link->query("SELECT email, name, level FROM login WHERE email='$user_check'");
$row = mysqli_fetch_assoc($ses_sql);
$login_session = $row['email'];
$login_name = $row['name'];
$login_level = $row['level'];
if(!isset($login_session)){
	$ses_sql->close();
/*	header('Location: ../'); */
}
?>