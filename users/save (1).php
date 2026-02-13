<?php
include ('../_inc/inc.config.php');
header('Expires: ' . gmdate('r', 0));
header('Content-type: application/json');
$e = mysqli_real_escape_string($link, $_POST['email']);
$n = mysqli_real_escape_string($link, $_POST['name']);
$c = mysqli_real_escape_string($link, $_POST['company']);
$p = mysqli_real_escape_string($link, $_POST['phone']);
// $a = mysqli_real_escape_string($link, $_POST['assign']);
$ak = rand(100, 9999);
$ak = md5($ak);
$pw = rand(100, 9999);
$check="SELECT email FROM login WHERE email = '$e'";
$res = $link->query($check);

if ($res ->num_rows && !$_POST['id']) {
	$arrResult = array ('response'=>'error', 'message'=>'Email already exists');
	echo json_encode($arrResult);
	$link->close();	
} elseif (!$_POST['id']) {
	$query2="INSERT INTO login(email, name, company, phone, password, activationkey, status, level, companyAssigned) VALUES ('$e', '$n', '$c', '$p', md5('$pw'), '$ak', '1', '0', '0')";
	if ($link->query($query2) === TRUE) {

	} else {

	}
	$link->close();
	session_cache_limiter('nocache');
	require '../php-mailer/class.phpmailer.php';
	$subject = 'JenJil Account Verification';
	if($e) {
		$message = "<h1>JenJil Account Verification</h1>";
	  $message .="<p>This message has been sent because a request was made to create an account. If you did not not request an account you do not need to do anything, your account will not be created.</p>\n";
	  $message .="<p>If you did request a new account, please click the link below to verify your account:</p>\n";
	  $message .="<p><a href='".$esroot."user-verify/".$ak."'>Verify Your Account</a></p>\n";
	  $message .="<p>If the link above is not clickable you can copy the link below and paste it into your browser</p>\n";
	  $message .=$esroot."user-verify/".$ak."<br>\n";
	  $message .="<p>This is an automated message</p>\n";
		$mail = new PHPMailer;
		$mail->IsSMTP();   
/*
		//Enable SMTP debugging
	// 0 = off (for production use)
	// 1 = client messages
	// 2 = client and server messages
	$mail->SMTPDebug = 0;
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->SMTPSecure = 'ssl';
	$mail->SMTPAuth = true;
	$mail->Username = 'globaldogg@gmail.com';
	$mail->Password = 'cobalt';
*/
		$mail->From = 'info@jenjilpackaging.com';
		$mail->FromName = 'JenJil Packaging';
		$mail->AddAddress($e);
		$mail->AddReplyTo('info@jenjilpackaging.com', 'JenJil Packaging');
		$mail->IsHTML(true);      
		$mail->CharSet = 'UTF-8';
		$mail->Subject = $subject;
		$mail->Body    = $message;
		if(!$mail->Send()) {
		  $arrResult = array ('response'=>'error');
		}
		$arrResult = array ('response'=>'success');
		echo json_encode($arrResult);
	} else {
		$arrResult = array ('response'=>'error');
		echo json_encode($arrResult);
	}
} else {
	$id = $_POST['id'];
	$query2="UPDATE login SET email='$e', name='$n', company='$c', phone='$p', companyAssigned='$a' WHERE id='$id'";
	if ($link->query($query2) === TRUE) {
		$arrResult = array ('response'=>'success');
		echo json_encode($arrResult);
	} else {
		$arrResult = array ('response'=>'error');
		echo json_encode($arrResult);
	}
	$link->close();
}
?>
