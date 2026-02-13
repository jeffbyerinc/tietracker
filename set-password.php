<?php
include ('_inc/inc.config.php');
require 'php-mailer/class.phpmailer.php';
$id = $_POST['userid'];
$pw = mysqli_real_escape_string($link, $_POST['password']);

$query2="UPDATE login SET password=md5('$pw'), uniqueid='' WHERE id='$id'";
if ($link->query($query2) === TRUE) {
		$subject = "Password Reset Successfully";
		if ($result = $link->query("SELECT * FROM login WHERE id = '$id'")) {
			if(mysqli_num_rows($result) == 1 ){
				while($row = mysqli_fetch_assoc($result)) {
					$name = $row['name'];
					$company = $row['company'];
					$email = $row['email'];
					$message = "<h1>Password Reset Successfully</h1>";
				  $message .="<p>You have successfully reset your password. If you have any questions or inquiries please contect us.</p>\n";
				  $message .="<p>This is an automated message</p>\n";
				  $mail = new PHPMailer;
					$mail->IsSMTP();   
					/* 
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
					$mail->AddAddress($email);
					$mail->IsHTML(true);      
					$mail->CharSet = 'UTF-8';
					$mail->Subject = $subject;
					$mail->Body    = $message;
					if(!$mail->Send()) {
					   $arrResult = array ('response'=>'error');
					} 
					$arrResult = array ('response'=>'success');
					echo json_encode($arrResult);
				}
			} else {
				$arrResult = array ('response'=>'error');
				echo json_encode($arrResult);
			}
		}
} else {
    $arrResult = array ('response'=>'error');
		echo json_encode($arrResult);
}
$link->close();
?>