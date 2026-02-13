<?php
include ('_inc/inc.config.php');
include('session.php');
if(!isset($_SESSION['login_user']) || $login_level < 5){
//	header("location: /");
  header('Location: '.$esroot.'certifications');
}
$title = "Agricultural Packaging Products - JenJil Packaging Inc.";
$description = "Our agricultural packaging products are high quality, durable, and meet all industry and production standards.";
$canon = $esroot . 'profile';
$nav = '1';
$datePub = "2017-10-17";
$dateMod = "2017-10-18";
include('_inc/inc.head.php'); ?>

<body>
<?php include('_inc/inc.nav.php'); ?>
	
<?php include('_inc/inc.admin.header.php') ?>

<?php if(($user == $admin)){ ?>

	<div class="container mt-5">
    <h2>Unassigned Users</h2>

      <div class="row nap-headers hidden-xs"> 
        <div class="col-sm-4">
          <p><strong>User Info</strong></p>
        </div>
        <div class="col-sm-1"> 
          <p><strong>Status</strong></p>
        </div>
        <div class="col-sm-5"> 
          <p><strong>Assign to</strong></p>
        </div>
        <div class="col-sm-2"> 
          <p><strong>Actions</strong></p>
        </div>
      </div>
<?php
  if ($result = $link->query("SELECT * FROM login ORDER BY id ASC")) {
    while($row = mysqli_fetch_assoc($result)) {
      if($row['status'] == 0) { $status = "Active";$txtclass = "text-success"; } 
        else if($row['status'] == 1) { $status = "Pending";$txtclass = "text-danger"; } 
        else { $status = "Unknown"; }
      if($row['companyAssigned'] == 0) { 
        $assigned = "Unassigned"; 
        
?>
      <div class="row nap-orders"> 
        <div class="col-sm-4">
          <p>     <?php echo stripslashes($row['name']); ?> - <?php echo stripslashes($row['company']); ?>
            <br /><?php echo stripslashes($row['email']); ?>
            <br />
          </p>
        </div>
        <div class="col-sm-1"> 
          <p class="<?php echo $txtclass; ?>"><?php echo $status; ?></p>
        </div>

        <div class="col-sm-5"> 
          <form id="<?php echo $row['id']; ?>" method="POST" action="">
            <select class="form-control mb-2" id="assign" name="assign">
              <option value="0">--None--</option>
              <?php 
                if ($companies = $link->query("SELECT * FROM company ORDER BY name ASC")) {
                  while($company = mysqli_fetch_assoc($companies)) { 
              ?>
                  <option value="<?php echo $company['id']; ?>"><?php echo stripslashes($company['name']); ?></option>
              <?php 
                  }
                }
              ?>
            </select>
            <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']; ?>">
            <button type="submit" class="btn btn-alt btn-assign" >Assign Company</button>
          </form>
          <div id="msg"></div>
        </div>
        <div class="col-sm-2"> 
          <button type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo stripslashes($row['name']); ?>" class="btn btn-danger" data-toggle="modal" data-target="#remove">delete</button>
        </div>
      </div>
      <hr />
<?php
      }
    }
    $result->close();
  }
}
?>
    <h2>Packaging Products Data</h2>
    <div class="row">
    <?php 
      $file = file_get_contents('jenjil-prod-data.json');
      $data = json_decode($file, true);
      $data =  $data['products'];
      foreach($data as $key => $value)
      { ?>
<div class="col-2 py-2 text-right">ID</div><div class="col-10 py-2"><?php echo $value['id']; ?></div>
<div class="col-2 py-2 text-right">Title</div><div class="col-10 py-2"><?php echo $value['title']; ?></div>
<div class="col-2 py-2 text-right">Link</div><div class="col-10 py-2"><a href="<?php echo $esroot; ?>products/<?php echo $value['link']; ?>"><?php echo $esroot; ?>products/<?php echo $value['link']; ?></a></div>
<div class="col-2 py-2 text-right">Image</div><div class="col-4 py-2"><img class="img-fluid" src="<?php echo $esroot; ?>img/<?php echo $value['image']; ?>" /></div><div class="w-100"></div>
<div class="col-2 py-2 text-right">Summary</div><div class="col-10 py-2"><?php echo $value['summary']; ?></div>
<div class="col-2 py-2 text-right">Description</div><div class="col-10 py-2"><?php echo $value['description']; ?></div>
<div class="w-100"><hr /></div>
      <?php } ?>
    </div>
    
	</div>

  <div id="remove" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
      <form name="rm" id="rm" action="users/remove.php" method="POST">
        <div class="modal-header">
          <h4 class="modal-title">Delete User</h4>
        </div>
        <div class="modal-body">
            <p>Are you sure you want to remove this user?</p>
            <input type="hidden" name="id" value="">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <button type="submit" id="remove-item" class="btn btn-danger">Yes</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->

<?php include('_inc/inc.scripts.php'); ?>



<script type="text/javascript">
  $(document).ready(function() {

    $('#remove').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id') 
      var n = button.data('name')
      var modal = $(this)
      modal.find('.modal-title').text('Delete User: ' + n)
      modal.find('.modal-body input').val(id)
    })

    $('form').on('submit', function(e) {
      e.preventDefault(); 
      var formData = new FormData(this);
      $.ajax({
          url: "_inc/inc.assignco.php",
          type: "POST",
          data: $(this).serialize(),
          dataType: "json",
          success: function(data) {
            if (data.response === "success") {
              location.reload();
            } else {
              $('#msg').html('<div class="alert alert-danger">'+data.message+'</div>');
            }
          }
      });
    });
    $("#rm").submit(function(e) {
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            success:function(data, textStatus, jqXHR) 
            {
                $('.modal-body').html( "Data Removed: " + textStatus );
                setTimeout (function() {
                  $('#add').modal('hide');
                  location.reload(true);
                }, 2000);
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                     
            }
        });
        e.preventDefault(); 
    });
  });

</script>

	</body>
</html>