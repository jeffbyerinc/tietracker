<?php
include ('_inc/inc.config.php');
session_start();
if(session_destroy()) // Destroying All Sessions
{
header("Location: certifications"); // Redirecting
}
?>