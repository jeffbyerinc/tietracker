<?php
include ('inc.config.php');
$id = $_POST['id'];
$a = $_POST['assign'];

// Insert the data
$query2="UPDATE login SET companyAssigned='$a' WHERE id='$id'";
if ($link->query($query2) === TRUE) {
    $arrResult = array ('response'=>'success','message'=>'Update successful');
		echo json_encode($arrResult);
} else {
    $arrResult = array ('response'=>'error','message'=>'Update failed');
		echo json_encode($arrResult);
}

$link->close();
?>
