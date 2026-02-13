<?php 
include ('inc.config.php');

if(count($_FILES['attachment']['name']) > 0){
  foreach($_FILES['attachment']['error'] as $error) {
    if($error)
      die( "Error: No files selected. ".$error); 		
  }

  $maxsize = 2 * 1024 * 1024; //2MB maximum allowed.
  foreach($_FILES['attachment']['size'] as $size) {
    if($size > $maxsize)
      die("Error: File size is larger than the allowed limit.");		
  }
		
  $allowed = array( 'jpg', 'jpeg', 'gif', 'png', 'bmp', 'pdf', 'docx', 'doc', 'csv', 'xls', 'xlsx');
  foreach($_FILES['attachment']['name'] as $name) {
    $type = pathinfo($name, PATHINFO_EXTENSION); 
    if(!in_array($type, $allowed)) 
      die("Error: Please select a valid file format.-".$type);	
  }
    
  $Kv_items = array();	
  $Kv = 0;
  $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . "/jenjil/crt/";
//  $uploads_dir = $_SERVER['DOCUMENT_ROOT'] . "/crt/";
  foreach($_FILES['attachment']['name'] as $filename) {
    move_uploaded_file($_FILES["attachment"]["tmp_name"][$Kv], $uploads_dir. basename($filename)); 
    mysqli_query($link, "INSERT INTO certifications (certname, certlink, companyid, certdate) 
                            values ( '".$_FILES["attachment"]["name"][$Kv]."', '".$esroot."crt/".$_FILES["attachment"]["name"][$Kv]."', '".$_POST['company']."', '".date('Y-m-d')."')");
    if(mysqli_insert_id($link)){
      $Kv++;
      $Kv_items[] = mysqli_insert_id($link);  
    }					
  } 
  if(count($Kv_items))
    echo count($Kv_items).' Files Inserted Successfully!' ; 
} 

$link->close();

?>