<?php 
include ('inc.config.php');
function timeDiff($firstTime,$lastTime)
{
  $firstTime=strtotime($firstTime);
  $lastTime=strtotime($lastTime);
  $timeDiff=$lastTime-$firstTime;
  $years = abs(floor($timeDiff / 31536000));
  $days = abs(floor(($timeDiff-($years * 31536000))/86400));
  $hours = abs(floor(($timeDiff-($years * 31536000)-($days * 86400))/3600));
  $mins = abs(floor(($timeDiff-($years * 31536000)-($days * 86400)-($hours * 3600))/60));
  $minfrac = round($hours + ($mins / 60), 2);
  return $minfrac;
}

if(isset($_POST['client'])) {
  $name = mysqli_real_escape_string($link, $_POST['name']);
  $client = mysqli_real_escape_string($link, $_POST['client']);
  $project = mysqli_real_escape_string($link, $_POST['project']);
  $start = $_POST['start'];
  $finish = $_POST['finish'];
  $total = timeDiff($start,$finish);
  $notes = mysqli_real_escape_string($link, $_POST['notes']);
  $startdate = date("Y-m-d", strtotime($start));
  $finishdate = date("Y-m-d", strtotime($finish));
  $query2="INSERT INTO TimeTable(name, client, task, start, finish, total, Notes, startdate, finishdate) VALUES ('$name', '$client', '$project', '$start', '$finish', '$total', '$notes', '$startdate', '$finishdate')";
  if ($link->query($query2) === TRUE) {
    $arrResult = array ('response'=>'success','message'=>'Insert successful');
    echo json_encode($arrResult);
  } else {
    $arrResult = array ('response'=>'error','message'=>'Insert failed');
    echo json_encode($arrResult);
    printf("Errormessage: %s\n", mysqli_error($link));
  }
} else {
  $arrResult = array ('response'=>'error','message'=>'Company name is missing');
  echo json_encode($arrResult);
  die();
} 
?>