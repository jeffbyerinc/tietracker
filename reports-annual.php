<?php
include ('../_inc/inc.config.php');
// include ('login.php');
$nav = 0;
$title = "Timetracker: Annual Budget Report";
$description = "";
$canon = $root;
if (isset($_POST['client'], $_POST['rate'], $_POST['year'], $_POST['months'], $_POST['budget'])) {
  $client = $_POST['client'];
  $rate = $_POST['rate'];
  $year = $_POST['year'];
  $months = $_POST['months'];
  $budget = $_POST['budget'];
} else {
  $client = '';
  $rate = '';
  $year = '';
  $months = '';
  $budget = '';
}

include('timetracker/_inc/inc.head.php'); ?>

<body>
<?php include('_inc/inc.nav.php'); ?>

  <section class="head home d-print-none">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-12 mx-auto">
          <h1><?php echo $title; ?></h1>
          <form id="reporttracker" class="form" role="form" method="post" action="">
            <div class="form-group">
              <input class="form-control-lg" type="text" name="client" id="client" placeholder="Client">
              <input class="form-control-lg" type="text" name="year" id="year" placeholder="Year">
            </div>
            <div class="form-group">
              <input class="form-control-lg" type="text" name="budget" id="budget" placeholder="Budget">
              <input class="form-control-lg" type="text" name="rate" id="rate" placeholder="Rate">
              
            </div>
            <div class="form-group">
              <input class="form-control-lg" type="text" name="months" id="months" placeholder="months">
              <input class="btn btn-lg btn-success mt-2 .btn-submit" type="submit" value="Run">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="products">
  	<div class="container">
      <h2>TimeTracker: Reports</h2>

      <div class="row">
        <div class="col-sm-1">
          <p><strong>Client</strong></p>
        </div>
        <div class="col-sm-2"> 
          <p><strong>Task</strong></p>
        </div>
        <div class="col-sm-2"> 
          <p><strong>Start</strong></p>
        </div>
        <div class="col-sm-2"> 
          <p><strong>Finish</strong></p>
        </div>
        <div class="col-sm-1"> 
          <p><strong>Total</strong></p>
        </div>
        <div class="col-sm-4"> 
          <p><strong>Notes</strong></p>
        </div>
      </div>

 <?php
  if ($result = $link->query("SELECT * FROM TimeTable WHERE `client` = '$client' AND YEAR(start) = $year ORDER BY id ASC")) {
    while($row = mysqli_fetch_assoc($result)) { 
?>
      <div class="row">
        <div class="col-sm-1">
          <p><?php echo stripslashes($row['client']); ?></p>
        </div>
        <div class="col-sm-2"> 
          <p><?php echo stripslashes($row['task']); ?></p>
        </div>
        <div class="col-sm-2"> 
          <p><?php echo stripslashes($row['start']); ?></p>
        </div>
        <div class="col-sm-2"> 
          <p><?php echo stripslashes($row['finish']); ?></p>
        </div>
        <div class="col-sm-1"> 
          <p><?php echo stripslashes($row['total']); ?></p>
        </div>
        <div class="col-sm-4"> 
          <p><?php echo stripslashes($row['Notes']); ?></p>
        </div>
      </div>
<?php 
    }
  }
?>
    
<?php /* 
  SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `total` ) ) ) AS timeSum FROM TimeTable WHERE `client` = '$client' AND YEAR(start) = $year AND MONTH(start) = $month ORDER BY start ASC" 
  $hms = explode(":", $timeSum);
  $decimalHours = $hms[0] + ($hms[1]/60) + ($hms[2]/3600);
*/?>
<?php if ($totalTime = $link->query("SELECT SUM(`total`) AS timeSum FROM TimeTable WHERE `client` = '$client' AND YEAR(start) = $year ORDER BY start ASC")) { 
  $timeTotal = mysqli_fetch_assoc($totalTime);
  $timeSum = $timeTotal['timeSum'];
  $timeRound = ROUND($timeSum, 2);
  $totalBudget = $budget * $months;
  $billing = $timeSum * $rate;
  if ($billing > $totalBudget) {
    $color = 'red';
  } else {
    $color = 'green';
  }
  setlocale(LC_MONETARY, 'en_US');
?>
    <div class="row">
    	<div class="col-sm-4">
        <h3>Total Hours</h3>
      </div>
      <div class="col-sm-2">
    		<h2><?php echo $timeRound; ?></h2>
    	</div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <h3>Total Budget</h3>
      </div>
      <div class="col-sm-2">
        <h2><?php $fmt2 = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY ); echo $fmt2->formatCurrency($totalBudget, 'USD'); ?></h2>
        <?php /* <h2><?php echo money_format('%.2n', $totalBudget) . "\n"; ?> </h2> */ ?>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4">
        <h3>Total Cost</h3>
      </div>
      <div class="col-sm-2">
        <h2 style="color:<?php echo $color; ?>"><?php $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY ); echo $fmt->formatCurrency($billing, 'USD'); ?></h2>
        <?php /* <h2 style="color:<?php echo $color; ?>"><?php echo money_format('%.2n', $billing) . "\n"; ?> </h2> */ ?>
      </div>
    </div>
<?php } ?>
  </div>

  </section>
<?php /*
* Simply Select Client *
SELECT * FROM TimeTable WHERE `client` = 'gumgum'

* Select Client and Work by Month *
SELECT * FROM TimeTable WHERE `client` = 'gumgum' AND YEAR(start) = 2018 AND MONTH(start) = 4

* Calculate Monthly Time spent by Client *
SELECT SEC_TO_TIME( SUM( TIME_TO_SEC( `total` ) ) ) AS timeSum FROM TimeTable WHERE `client` = 'gumgum' AND YEAR(start) = 2018 AND MONTH(start) = 4

Variable Definitions:

client = 'gumgum'
timeSum = 40:00
budget = 40:00

* if client timeSum > budget ALERT *

*/ ?>

<?php include('_inc/inc.footer.php'); ?>

<!-- IntersectionObserver polyfill -->
<script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver"></script>
<!-- Lozad.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/lozad"></script>

<?php include('_inc/inc.scripts.php'); ?>

<script type="text/javascript">
  $('#client').change(function() { sessionStorage.setItem('client', $(this).val()); })
  if(sessionStorage.getItem('client')) { $('#client').val(sessionStorage.getItem('client')); }
  $('#task').change(function() { sessionStorage.setItem('task', $(this).val()); })
  if(sessionStorage.getItem('task')) { $('#task').val(sessionStorage.getItem('task')); }
  $('#rate').change(function() { sessionStorage.setItem('rate', $(this).val()); })
  if(sessionStorage.getItem('rate')) { $('#rate').val(sessionStorage.getItem('rate')); }
  $('#months').change(function() { sessionStorage.setItem('months', $(this).val()); })
  if(sessionStorage.getItem('months')) { $('#months').val(sessionStorage.getItem('months')); }
  $('#year').change(function() { sessionStorage.setItem('year', $(this).val()); })
  if(sessionStorage.getItem('year')) { $('#year').val(sessionStorage.getItem('year')); }
  $('#budget').change(function() { sessionStorage.setItem('budget', $(this).val()); })
  if(sessionStorage.getItem('budget')) { $('#budget').val(sessionStorage.getItem('budget')); }
</script>

  </body>
</html>
