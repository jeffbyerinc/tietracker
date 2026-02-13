<?php
include ('../_inc/inc.config.php');
include('../_admin/session.php');
// include ('login.php');
$nav = 0;
$title = "Timetracker";
$description = "";
$canon = $root;
$name = $login_name = $row['fname'];
include('timetracker/_inc/inc.head.php'); ?>

<body>
<?php include('_inc/inc.nav.php'); ?>

  <section class="head home">
    <div class="container">
      <div class="row justify-content-between">
        <div class="col-12 mx-auto">
          <div id="localString"></div>
          <form id="timetracker" class="form" role="form" method="post" action="_inc/addTimeDB.php">
            <div class="form-group">
              <input class="form-control-lg" type="text" name="client" id="client" placeholder="Client">
              <input class="form-control-lg" type="text" name="project" id="project" placeholder="Project">
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input class="form-control" type="text" id="start" name="start" value="">
                <div class="input-group-append">
                  <button id="startbut" class="btn btn-danger" onclick="getElementById('start').value = inputDate()" type="button">Start</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="input-group input-group-lg">
                <input class="form-control" type="text" id="finish" name="finish" value="">
                <div class="input-group-append">
                  <button id="finishbut" class="btn btn-success" onclick="getElementById('finish').value = inputDate()" type="button">Finish</button>
                </div>
              </div>
            </div>
            <div class="form-group">
              <textarea class="form-control" rows="4" name="notes" id="notes"></textarea>
              <input type="hidden" name="name" value="<?php echo $name; ?>">
              <input class="btn btn-lg btn-success mt-2 .btn-submit" type="submit" value="Save">
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="products">
  	<div class="container-fluid">
      <h2>Tracked Time</h2>

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
  if ($result = $link->query("SELECT * FROM TimeTable ORDER BY id DESC")) {
    while($row = mysqli_fetch_assoc($result)) {        
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
    </div>
  </section>

<?php include('_inc/inc.footer.php'); ?>

<!-- IntersectionObserver polyfill -->
<script src="https://polyfill.io/v2/polyfill.min.js?features=IntersectionObserver"></script>
<!-- Lozad.js from CDN -->
<script src="https://cdn.jsdelivr.net/npm/lozad"></script>

<?php include('_inc/inc.scripts.php'); ?>

<script type="text/javascript" src="<?php echo $root; ?>timetracker/js/jquery.validate.min.js"></script>
<script type="text/javascript">
  function inputDate() {
    var date = new Date().toLocaleString('en-US',{hour12:false}).split(" ");
    var time = date[1];
    var mdy = date[0];
    mdy = mdy.split('/');
    var month = parseInt(mdy[0]);
    var day = parseInt(mdy[1]);
    var year = parseInt(mdy[2]);
    var formattedDate = year + '-' + month + '-' + day + ' ' + time;
    document.getElementById("localString").innerHTML = formattedDate;
    return formattedDate;
  }
  setInterval(inputDate, 1000);
  inputDate();
  var storedate = inputDate();
  $('#client').change(function() { localStorage.setItem('client', $(this).val()); })
  if(localStorage.getItem('client')) { $('#client').val(localStorage.getItem('client')); }
  $('#project').change(function() { localStorage.setItem('project', $(this).val()); })
  if(localStorage.getItem('project')) { $('#project').val(localStorage.getItem('project')); }
  $('#start').change(function() { localStorage.setItem('start', $(this).val()); })
  $('#startbut').click(function() { localStorage.setItem('start', storedate); })
  if(localStorage.getItem('start')) { $('#start').val(localStorage.getItem('start')); }
  $('#finish').change(function() { localStorage.setItem('finish', $(this).val()); })
  $('#finishbut').click(function() { localStorage.setItem('finish', storedate); })
  if(localStorage.getItem('finish')) { $('#finish').val(localStorage.getItem('finish')); }
  $('#notes').change(function() { localStorage.setItem('notes', $(this).val()); })
  if(localStorage.getItem('notes')) { $('#notes').val(localStorage.getItem('notes')); }
  
  lozad('.lozad', {
      load: function(el) {
          el.src = el.dataset.src;
          el.onload = function() {
              el.classList.add('imgfade')
          }
      }
  }).observe()
  var TimeTrack = {
  initialized: false,
  initialize: function() {
    if (this.initialized) return;
    this.initialized = true;
    this.build();
    this.events();
  },
  build: function() {
    this.validations();
  },
  events: function() {
  },
  validations: function() {
    $("#timetracker").validate({
      submitHandler: function(form) {
        $('.btn-submit').button('loading');
        $('#sending').modal('show');
        $.ajax({
          type: "POST",
          url: "_inc/addTimeDB.php",
          data: $('#timetracker').serialize(),
          dataType: "json",
          success: function (data) {
            if (data.response === "success") {
              $("input[type=text], input[type=tel], input[type=email], textarea").val("");
              localStorage.clear();
              location.reload();
            } else {
              $("#success").addClass("hidden");
              $(".btn-submit").button("reset");
            }
          }
        });
      },
      rules: {
        client: {required: true},
        start: {required: true},
        finish: {required: true}
      },
      highlight: function (element) {
        $(element)
          .closest(".form-group")
          .removeClass("has-success")
          .addClass("has-error");
        $(element)
          .siblings(".fa")
          .removeClass("fa-check")
          .addClass("fa-close");
      },
      unhighlight: function (element) {
        $(element)
          .siblings(".fa")
          .removeClass("fa-close");
      },
      success: function (element) {
        $(element)
          .siblings(".fa")
          .removeClass("fa-close")
          .addClass("fa-check");
        $(element)
          .closest(".form-group")
          .removeClass("has-error")
          .addClass("has-success");
        },
        errorPlacement: function(error, element) {
          error.appendTo(element);
        },
        focusCleanup: true
    });
  }
};
TimeTrack.initialize();
</script>

  </body>
</html>
