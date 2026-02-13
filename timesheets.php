<?php
include ('../_inc/inc.config.php');
include('../_admin/session.php');
// include ('login.php');
$nav = 0;
$title = "Timetracker: Timesheets";
$description = "";
$canon = $root;
$name = $login_name = $row['fname'];

if (isset($_POST['name'], $_POST['rate'], $_POST['startmonth'], $_POST['endmonth'])) {
  $name = $_POST['name'];
  $rate = $_POST['rate'];
  $startmonth = $_POST['startmonth'];
  $startday = $_POST['startday'];
  $startyear = $_POST['startyear'];
  $endmonth = $_POST['endmonth'];
  $endday = $_POST['endday'];
  $endyear = $_POST['endyear'];
} else {
  $name = '';
  $rate = '';
  $startmonth = '';
  $startday = '';
  $startyear = '';
  $endmonth = '';
  $endday = '';
  $endyear = '';
}

include('timetracker/_inc/inc.head.php'); ?>

<body>
<?php include('timetracker/_inc/inc.nav.php'); ?>

  <section class="head home d-print-none">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-12 mx-auto">
          <h1><?php echo $title; ?></h1>
          <form id="reporttracker" class="form" role="form" method="post" action="">
            <div class="form-group">
              <input class="form-control-lg" type="text" name="name" id="name" placeholder="name">
            </div>
            <div class="form-group">
              <input class="form-control-lg" type="text" name="startmonth" id="startmonth" placeholder="Start Month">
              <input class="form-control-lg" type="text" name="startday" id="startday" placeholder="Start Day">
              <input class="form-control-lg" type="text" name="startyear" id="startyear" placeholder="Start Year">
            </div>
            <div class="form-group">
              <input class="form-control-lg" type="text" name="endmonth" id="endmonth" placeholder="End Month">
              <input class="form-control-lg" type="text" name="endday" id="endday" placeholder="End Day">
              <input class="form-control-lg" type="text" name="endyear" id="endyear" placeholder="End Year">
            </div>
            <div class="form-group">
              <input class="form-control-lg" type="text" name="rate" id="rate" placeholder="Rate">
              <input class="btn btn-lg btn-success mt-2 .btn-submit" type="submit" value="Run">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="products">
  	<div class="container">
      <h2>TimeTracker: Timesheets</h2> 
      <a href="timetracker-timesheet.csv?v=<?php echo uniqid(); ?>" class="btn btn-lg btn-success mb-2 d-print-none" download>Download CSV</a>

      <div class="row">
        <div class="col">
          <p><strong>Name</strong></p>
        </div>
        <div class="col">
          <p><strong>Client</strong></p>
        </div>
        <div class="col"> 
          <p><strong>Task</strong></p>
        </div>
        <div class="col"> 
          <p><strong>Start</strong></p>
        </div>
        <div class="col"> 
          <p><strong>Finish</strong></p>
        </div>
        <div class="col"> 
          <p><strong>Total</strong></p>
        </div>
        <div class="col"> 
          <p><strong>Notes</strong></p>
        </div>
      </div>

 <?php
  $start = $startyear . '-' . $startmonth . '-' . $startday;
  $finish = $endyear . '-' . $endmonth . '-' . $endday;
  $start = date("Y-m-d", strtotime($start));
  $finish = date("Y-m-d", strtotime($finish));
  // SELECT * FROM TimeTable WHERE 'name' = "Kevin" BETWEEN '2020-09-07' AND '2020-09-11'
  // if ($result = $link->query("SELECT * FROM TimeTable WHERE `name` = '$name' AND start = $start AND finish = $finish ORDER BY id ASC")) {
    // SELECT * FROM `TimeTable` WHERE `finish` IS NOT NULL AND `finish` BETWEEN '2020-09-29' AND '2020-10-01'
  if ($result = $link->query("SELECT * FROM `TimeTable` WHERE `name` = '$name' AND `finishdate` IS NOT NULL AND `finishdate` BETWEEN '$start' AND '$finish'")) {
    $fp = fopen('timetracker-timesheet.csv', 'w');
    $first = true;
    while($row = mysqli_fetch_assoc($result)) { 
      if ($first) {
        fputcsv($fp, array_keys($row));
        $first = false;
      }
      fputcsv($fp, $row);
?>

      <div class="row">
        <div class="col">
          <p><?php echo stripslashes($row['name']); ?></p>
        </div>
        <div class="col">
          <p><?php echo stripslashes($row['client']); ?></p>
        </div>
        <div class="col"> 
          <p><?php echo stripslashes($row['task']); ?></p>
        </div>
        <div class="col"> 
          <p><?php echo stripslashes($row['start']); ?></p>
        </div>
        <div class="col"> 
          <p><?php echo stripslashes($row['finish']); ?></p>
        </div>
        <div class="col"> 
          <p><?php echo stripslashes($row['total']); ?></p>
        </div>
        <div class="col"> 
          <p><?php echo stripslashes($row['Notes']); ?></p>
        </div>
      </div>
<?php 
    }
  }
?>

<?php if ($totalTime = $link->query("SELECT SUM(`total`) AS timeSum FROM TimeTable WHERE `name` = '$name' AND `finishdate` IS NOT NULL AND `finishdate` BETWEEN '$start' AND '$finish' ORDER BY start ASC")) { 
  $timeTotal = mysqli_fetch_assoc($totalTime);
  $timeSum = $timeTotal['timeSum'];
  $timeRound = ROUND($timeSum, 2);
  $billing = $timeSum * $rate;
  $color = 'green';
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
        <h3>Total Payment</h3>
      </div>
      <div class="col-sm-2">
        <h2 style="color:<?php echo $color; ?>"><?php $fmt = new NumberFormatter( 'en_US', NumberFormatter::CURRENCY ); echo $fmt->formatCurrency($billing, 'USD'); ?></h2>
        <?php /* echo money_format('%.2n', $billing) . "\n"; */ ?> 
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

<?php /*
<!-- IntersectionObserver polyfill -->
<script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver"></script>
<!-- Lozad.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/lozad"></script>
*/ ?>
<?php include('_inc/inc.scripts.php'); ?>
<style>
@media print {
  div.print-content article.node .node-blog .clearfix div.item-body p a {
    display: none;
  }
  p {
    font-size: 8pt !important;
  }
  body, .container {
    max-width: 8.0in !important;
    min-width: 8.0in !important;
    padding: 0 !important;
    margin: 0 !important;
  }
  .col {
    width: auto !important;
  }
  @page { 
    size: 8.0in 11in !important;
    margin: 0.25in !important;
  }
}

</style>
<script type="text/javascript">
  $('#name').change(function() { sessionStorage.setItem('name', $(this).val()); })
  if(sessionStorage.getItem('name')) { $('#name').val(sessionStorage.getItem('name')); }
  
  $('#rate').change(function() { sessionStorage.setItem('rate', $(this).val()); })
  if(sessionStorage.getItem('rate')) { $('#rate').val(sessionStorage.getItem('rate')); }
  $('#startmonth').change(function() { sessionStorage.setItem('startmonth', $(this).val()); })
  if(sessionStorage.getItem('startmonth')) { $('#startmonth').val(sessionStorage.getItem('startmonth')); }
  $('#startday').change(function() { sessionStorage.setItem('startday', $(this).val()); })
  if(sessionStorage.getItem('startday')) { $('#startday').val(sessionStorage.getItem('startday')); }
  $('#startyear').change(function() { sessionStorage.setItem('startyear', $(this).val()); })
  if(sessionStorage.getItem('startyear')) { $('#startyear').val(sessionStorage.getItem('startyear')); }

  $('#endmonth').change(function() { sessionStorage.setItem('endmonth', $(this).val()); })
  if(sessionStorage.getItem('endmonth')) { $('#endmonth').val(sessionStorage.getItem('endmonth')); }

  $('#endday').change(function() { sessionStorage.setItem('endday', $(this).val()); })
  if(sessionStorage.getItem('endday')) { $('#endday').val(sessionStorage.getItem('endday')); }
  $('#endyear').change(function() { sessionStorage.setItem('endyear', $(this).val()); })
  if(sessionStorage.getItem('endyear')) { $('#endyear').val(sessionStorage.getItem('endyear')); }
</script>

  </body>
</html>
