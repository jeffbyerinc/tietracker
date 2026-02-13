<?php
include ('../_inc/inc.config.php');
$id = $_POST['id'];
$n = mysqli_real_escape_string($link, $_POST['name']);
$c = mysqli_real_escape_string($link, $_POST['company']);
$e = mysqli_real_escape_string($link, $_POST['email']);
$p = mysqli_real_escape_string($link, $_POST['phone']);

// Insert the data
$query2="UPDATE login SET name='$n', company='$c', email='$e', phone='$p' WHERE id='$id'";
if ($link->query($query2) === TRUE) {
    echo "Record updated successfully";
} else {
    echo "Error: " . $query2 . "<br>" . $link->error;
}

$link->close();
?>
