<?php
include ('inc.config.php');
if(isset($_POST['name']) && ($_POST['name']!=="")) {
    $n = $_POST['name'];
} else {
	$arrResult = array ('response'=>'error','message'=>'Company name is missing');
	echo json_encode($arrResult);
	die();
}

$check="SELECT name FROM company WHERE name = '$n'";
$res = $link->query($check);

if ($res ->num_rows && !$_POST['id']) {
	$arrResult = array ('response'=>'error', 'message'=>'Company name already exists');
	echo json_encode($arrResult);
	$link->close();	
} elseif (!$_POST['id']) {
	$query2="INSERT INTO company(name, active) VALUES ('$n', '1')";
	if ($link->query($query2) === TRUE) {
		$arrResult = array ('response'=>'success','message'=>'Insert successful');
		echo json_encode($arrResult);
	} else {
		$arrResult = array ('response'=>'error','message'=>'Insert failed');
		echo json_encode($arrResult);
	}
} else {
	$id = $_POST['id'];
	$query2="UPDATE company SET name='$n' WHERE id='$id'";
	if ($link->query($query2) === TRUE) {
		$arrResult = array ('response'=>'success','message'=>'Update successful');
		echo json_encode($arrResult);
	} else {
		$arrResult = array ('response'=>'error','message'=>'Update failed');
		echo json_encode($arrResult);
	}
	$link->close();
}
?>
