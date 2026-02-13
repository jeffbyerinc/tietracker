<?php
include ('../_inc/inc.config.php');
$id = $_POST['id'];

// Insert the data
$query2="DELETE FROM login WHERE id='$id'";
if ($link->query($query2) === TRUE) {
    echo "Record deleted successfully";
} else {
    echo "Error: " . $query2 . "<br>" . $link->error;
}

$link->close();
?>
