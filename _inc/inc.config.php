<?php 
set_include_path($_SERVER['DOCUMENT_ROOT']);

$root = "https://apps.byer.co/timetracker/";
$approot = "https://apps.byer.co/";
ini_set( "display_errors", true );
$user = 'byer9745_byadmin';
$password = 'Rc*1EA!+&*Kw';
$db = 'byer9745_byerstrap';
$host = 'localhost';
$port = 2083;

/*
$root = "http://localhost:8888/timetracker/";
ini_set( "display_errors", true );
$user = 'root';
$password = 'root';
$db = 'timetracker';
$host = 'localhost';
$port = 3306;
*/
$link = mysqli_init();
$success = mysqli_real_connect(
   $link, 
   $host, 
   $user, 
   $password, 
   $db,
   $port
);
?>