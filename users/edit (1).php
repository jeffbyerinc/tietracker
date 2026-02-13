<?php
include ('../_inc/inc.config.php');
include('../session.php');
if(!isset($_SESSION['login_user'])){
//  header("location: /");
  header('Location: '.$esroot.'certifications');
}
$title = "Agricultural Packaging Products - JenJil Packaging Inc.";
$description = "Our agricultural packaging products are high quality, durable, and meet all industry and production standards.";
$canon = $esroot . 'profile';
$nav = '1';
$datePub = "2017-10-17";
$dateMod = "2017-10-18";
include('../_inc/inc.head.php'); ?>

<body>
<?php include('../_inc/inc.nav.php'); ?>
  
<?php include('../_inc/inc.admin.header.php') ?>


  <div class="container">
    <h2>Users</h2>
    <div id="jb"></div>
     <button type="button" data-form="save.php" data-id="" data-name="" data-company="" data-phone="" data-email="" data-status="1" data-assigned="0" class="btn btn-alt" data-toggle="modal" data-target="#new">Add New User <i class="fa fa-plus-circle fa-lg"></i></button>
     <hr />
      <div class="row nap-headers hidden-xs"> 
        <div class="col-sm-4">
          <p><strong>Contact Info</strong></p>
        </div>
        <div class="col-sm-2"> 
          <p><strong>Status</strong></p>
        </div>
        <div class="col-sm-3"> 
          <p><strong>Assigned to</strong></p>
        </div>
        <div class="col-sm-3"> 
          <p><strong>Tools</strong></p>
        </div>
      </div>
<?php
  if ($result = $link->query("SELECT * FROM login ORDER BY id ASC")) {
    while($row = mysqli_fetch_assoc($result)) {
      if($row['status'] == 0) { $status = "Active";$txtclass = "text-success"; } 
        else if($row['status'] == 1) { $status = "Pending";$txtclass = "text-danger"; } 
        else { $status = "Unknown"; }
      if($row['companyAssigned'] == 0) { $assigned = "Unassigned";$txtclass2 = "text-danger"; }
        else if(isset($row['companyAssigned'])) { 
          $asid = $row['companyAssigned'];
          $co = $link->query("SELECT name FROM company WHERE id='$asid'");
          while($corow = mysqli_fetch_assoc($co)) {
            $assigned = $corow['name'];
            $txtclass2 = "text-success";
          }
          
        } 
        else { $assigned = "Unknown"; }
?>
      <div class="row nap-orders"> 
        <div class="col-sm-4">
          <p>     <?php echo stripslashes($row['name']); ?> - <?php echo stripslashes($row['company']); ?>
            <br /><?php echo stripslashes($row['email']); ?>
            <br /><?php echo stripslashes($row['phone']); ?>
          </p>
        </div>
        <div class="col-sm-2"> 
          <p class="<?php echo $txtclass; ?>"><?php echo $status; ?></p>
        </div>
        <div class="col-sm-3"> 
          <p class="<?php echo $txtclass2; ?>"><?php echo $assigned; ?></p>
        </div>
        <div class="col-sm-3"> 
          
          <button type="button" data-form="update.php" data-id="<?php echo $row['id']; ?>" data-username="<?php echo stripslashes($row['username']); ?>" data-password="<?php echo stripslashes($row['password']); ?>" data-name="<?php echo stripslashes($row['name']); ?>" data-company="<?php echo stripslashes($row['company']); ?>" data-phone="<?php echo stripslashes($row['phone']); ?>" data-email="<?php echo stripslashes($row['email']); ?>" data-assigned="<?php echo stripslashes($row['companyAssigned']); ?>" class="btn btn-alt" data-toggle="modal" data-target="#new">Edit User</button>
          <button type="button" data-id="<?php echo $row['id']; ?>" data-name="<?php echo stripslashes($row['name']); ?>" class="btn btn-danger" data-toggle="modal" data-target="#remove">Delete</button>
        </div>
      </div>
<?php
    }
    $result->close();
  }
?>
      <p class="bottom60"></p>
      
    </div>
  </body>
  <div id="new" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
      <form id="user" class="form" role="form" action type="post">
        <div class="modal-header">
          <h4 class="modal-title">Add New User</h4>
        </div>
        <div class="modal-body">
          <div class="row top20">
            <div class="col-sm-12">
              <input type="hidden" class="form-control" name="id">
              <div class="form-group has-feedback">
                <label for="name" class="control-label">Name<span>*</span></label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                <i class="fa form-control-feedback"></i>
              </div>

              <div class="form-group has-feedback">
                <label for="email" class="control-label">Email<span>*</span></label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                <i class="fa form-control-feedback"></i><div id="msg"></div>
              </div>

              <div class="form-group has-feedback">
                <label for="phone" class="control-label">Phone</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
                <i class="fa form-control-feedback"></i>
              </div>

              <div class="form-group has-feedback">
                <label for="company" class="control-label">Company</label>
                <input type="text" class="form-control" id="company" name="company" placeholder="Company">
                <i class="fa form-control-feedback"></i>
              </div>

              <div class="form-group">
                <label for="assign">Assign to Company</label>
                <select class="form-control" id="assign" name="assign">
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
              </div>

            </div>
          </div>       
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-alt btn-submit">Save User <i class="fa fa-angle-right"></i></button>
          <button type="button" class="btn btn-default" data-dismiss="modal">close</button>
        </div>
        </form>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
  
  <div id="remove" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
      <form name="rm" id="rm" action="remove.php" method="POST">
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
 
<?php include('../_inc/inc.scripts.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>

<script>
  var esroot = "<?php echo $esroot; ?>";
  $('#new').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var f = button.data('form')
    var u = button.data('username') 
    var pw = button.data('password') 
    var n = button.data('name')
    var c = button.data('company')
    var p = button.data('phone')
    var e = button.data('email')
    var id = button.data('id')
    var ca = button.data('assigned')
    var modal = $(this)
    modal.find('form').attr('action', f)
    modal.find('input[name=id]').val(id)
    modal.find('input[name=username]').val(u)
    modal.find('input[name=password]').val(pw)
    modal.find('input[name=name]').val(n)
    modal.find('input[name=company]').val(c)
    modal.find('input[name=email]').val(e)
    modal.find('input[name=phone]').val(p)
    modal.find('select[name=assign]').val(ca)
  })
  $('#remove').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget)
    var id = button.data('id') 
    var n = button.data('name')
    var modal = $(this)
    modal.find('.modal-title').text('Delete User: ' + n)
    modal.find('.modal-body input').val(id)
  })
  $(document).ready(function(){
    var User = {
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
        $("#user").validate({
          submitHandler: function(form) {
            $('.btn-submit').html('Sending <i class="fa fa-spinner fa-pulse"></i>');
            $.ajax({
              type: "POST",
              url: esroot+"users/save.php",
              data: $('#user').serialize(),
              dataType: "json",
              success: function(data) {
                if (data.response === "success") {
                  $('.btn-submit').html('Save User <i class="fa fa-angle-right"></i>');
                  $("input[type=text], input[type=tel], input[type=email], textarea").val("");
                  $("input[type=radio]").prop('checked', false);
                  $('label.active').removeClass('active');
                  $('.form-group').removeClass('has-success');
                  $("#user .modal-title").text("User Created Successfully.");
                  setTimeout(function() {
                    $('#user').modal('hide');
                    location.reload();
                  }, 2000);
                } else {
                  $('#msg').html('<div class="alert alert-danger">'+data.message+'</div>');
                  $('.btn-submit').html('Save User <i class="fa fa-angle-right"></i>');
                  $('#email').change(function() {
                    $('#msg').html('');
                  })
                }
              },
              error: function(data) {
                
              }
            });
          },
          rules: {
            name: {required: true},
            email: {required: true,email: true}
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
    User.initialize();
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

/*

    $("#user").submit(function(e) {
      var postData = $(this).serializeArray();
      var formURL = $(this).attr("action");
      $.ajax(
      {
        url : formURL,
        type: "POST",
        data : postData,
        success:function(data, textStatus, jqXHR) 
        {
          $('.modal-body').html( "Add New User: " + textStatus )
          setTimeout (function() {
            $('#new').modal('hide')
            location.reload(true);
          }, 1500)
        },
        error: function(jqXHR, textStatus, errorThrown) 
        {
                  
        }
      });
      e.preventDefault(); 
      rules: {
        name: {required: true},
        email: {required: true,email: true}
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

    $('#remove').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var id = button.data('id') 
      var modal = $(this)
      modal.find('.modal-title').text('Remove User ID ' + id)
      modal.find('.modal-body input').val(id)
    })
    $('#new').on('show.bs.modal', function (event) {
      var button = $(event.relatedTarget)
      var f = button.data('form')
      var u = button.data('username') 
      var pw = button.data('password') 
      var n = button.data('name')
      var c = button.data('company')
      var p = button.data('phone')
      var e = button.data('email')
      var id = button.data('id')
      var modal = $(this)
      modal.find('form').attr('action', f)
      modal.find('input[name=id]').val(id)
      modal.find('input[name=username]').val(u)
      modal.find('input[name=password]').val(pw)
      modal.find('input[name=name]').val(n)
      modal.find('input[name=company]').val(c)
      modal.find('input[name=email]').val(e)
      modal.find('input[name=phone]').val(p)
    })
    $("#edit").submit(function(e) {
        tinymce.triggerSave()
        var postData = $(this).serializeArray();
        var formURL = $(this).attr("action");
        $.ajax(
        {
            url : formURL,
            type: "POST",
            data : postData,
            success:function(data, textStatus, jqXHR) 
            {
                $('.modal-body').html( "Article update: " + textStatus );
                setTimeout (function() {
                  $('#update').modal('hide');
                  location.reload(true);
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                //if fails      
            }
        });
        e.preventDefault(); //STOP default action
    });
    $("#rm").submit(function(e)
    {
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
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) 
            {
                //if fails      
            }
        });
        e.preventDefault(); //STOP default action
    });
 

  */
  </script>
</html>