<?php
include ('_inc/inc.config.php');
include ('login.php');
// include ('session.php');
$nav = 4;
$title = "Product Certifications - JenJil Packaging Inc.";
$description = "Please reach out to us with any questions or comments regarding agricultural packaging and how our innovation and technology leads the packaging industry.";
$canon = $esroot . 'certifications';
$amp = $esroot . "amp-template.html";
$datePub = "2017-10-17";
$dateMod = "2018-04-04";
include('_inc/inc.head.php');
if(isset($_SESSION['login_user'])){
//  header("location: profile.php");
}
if(isset($_GET['id'])) {
  $id = $_GET["id"];
}

?>

<body>
<?php include('_inc/inc.nav.php'); ?>
  
  <section class="certifications">
    <div class="container">
      <h1>Product Certifications</h1>
    </div>
  </section>
  <div class="container">

  <section>
    <div class="row">
      <div class="col-md-5 mr-auto">      
        
<?php 
if(!isset($id)) { ?>
  <h2>Password Reset<br /><small>Invalid password reset link.</small></h2>
<?php } else {
  if ($result = $link->query("SELECT * FROM login WHERE uniqueid = '$id'")) {
  if(mysqli_num_rows($result) == 1 ) { 
    while($row = mysqli_fetch_assoc($result)) {
    $userid = $row['id'];
?>

              <h2>Password Reset</h2>
              <p><small>Enter your new password below. Password must be at least 8 characters, contain one letter and one number.</small></p>
              <p class="text-center has-error" id="error"><?php echo $error; ?></p>
              <form id="set-new" action="" method="post">
                <div class="form-group has-feedback">
                  <input id="password" name="password" class="form-control input-lg" placeholder="New Password" type="password">
                  <i class="fa form-control-feedback"></i>
                </div>
                <div class="form-group has-feedback">
                  <input id="password2" name="password2" class="form-control input-lg" placeholder="Retype Password" type="password">
                  <i class="fa form-control-feedback"></i>
                </div>
                <input type="hidden" id="userid" value="<?php echo $userid; ?>" name="userid">
                <input name="submit" type="submit" class="btn btn-lg btn-block" value="Reset Password">
                
                <p class="text-center">Have an account? <a class="admin-flip" href="#">Sign In</a></p>
              </form>
<?php } } else { ?> 

              <h2>Password Reset</h2>
              <p><small>Your password reset link has expired. To reset your password enter your email below.</small></p>
              <form id="forgot" action="" method="post">
                <div class="form-group">
                  <input id="username" name="username" class="form-control input-lg" placeholder="username or email address" type="text">
                </div>
                <button name="submit" type="submit" value-"submit" class="btn btn-lg btn-block btn-submit">Reset Password</button>
                <p class="text-center">Have an account? <a class="admin-flip" href="<?php echo $esroot; ?>certifications">Sign In</a></p>
              </form>
<?php } } } ?>

      </div>
      <div class="col-md-6">
        <p>Food and product safety is paramount to our customers. Our team and network of vendors share these same concerns.  As a result, we operate under the highest, most qualified food-safety practices and continue to invest in innovative packaging processes to evolve along with our customer’s requirements. Our certifications, to name a few, include the ISO 9000, BRC Global Standards, GMA-SAFE and FDA Certification. Our HAACP Alliance certification is in progress. </p>
      </div>
    </div>
  </section>
</div>

<?php include('_inc/inc.footer.php'); ?>

<?php include('_inc/inc.scripts.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<div class="modal fade" id="sending" tabindex="-1" role="dialog" aria-labelledby="sendingTitle" aria-hidden="true">
  <div class="modal-dialog modal-send" role="document">
    <div class="modal-content text-center" id="msg">
      <div class="modal-header">
        <h5 class="modal-title" id="sendingTitle">Sending your request</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="loader">
          <div class="bar1"></div>
          <div class="bar2"></div>
          <div class="bar3"></div>
          <div class="bar4"></div>
          <div class="bar5"></div>
          <div class="bar6"></div>
        </div>
        <h2></h2>
      </div>
      <div class="modal-footer"></div>
    </div>
  </div>
</div>
<script>
jQuery.extend(jQuery.validator.messages, {
  equalTo: "Passwords do not match."
});
$.validator.addMethod('mypassword', function(value, element) {
  return this.optional(element) || (value.match(/[a-zA-Z]/) && value.match(/[0-9]/));
},
'Password must contain one letter and one number.');
    var Contact = {
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
      $("#forgot").validate({
        submitHandler: function(form) {
          $('.btn-submit').button('loading');
          $('#sending').modal('show');
          $.ajax({
            type: "POST",
            url: "<? echo $esroot; ?>forgot-password.php",
            data: $('#forgot').serialize(),
            dataType: "json",
            success: function (data) {
              if (data.response === "success") {
                $(".btn-submit").button("reset");
                $("input[type=text]").val("");
                $('.form-group').removeClass('has-success');
                $("#sending .loader").fadeOut('fast');
                $("#sendingTitle").text("Password reset instructions sent by email.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 2000);
                setTimeout(function() {
                  window.location = "<? echo $esroot; ?>admin"
                }, 2500);
              } else {
                $("#success").addClass("hidden");
                $(".btn-submit").button("reset");
                $("#sending .loader").fadeOut('fast');
                $("#sendingTitle").text("Your email or username does not exist in our system.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 2000);
              }
            } 
          });
        },
        rules: {
          username: {required: true}
        },
        highlight: function (element) {
          $(element)
            .closest(".form-group")
            .removeClass("has-success")
            .addClass("has-error");
          $(element)
            .siblings(".glyphicon")
            .removeClass("glyphicon-ok")
            .addClass("glyphicon-remove");
        },
        unhighlight: function (element) {
          $(element)
            .siblings(".glyphicon")
            .removeClass("glyphicon-remove");
        },
        success: function (element) {
          $(element)
            .siblings(".glyphicon")
            .removeClass("glyphicon-remove")
            .addClass("glyphicon-ok");
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
  Contact.initialize();
  var SetNew = {
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
      $("#set-new").validate({
        submitHandler: function(form) {
          $('.btn-submit').button('loading');
          $('#sending').modal('show');
          $.ajax({
            type: "POST",
            url: "<? echo $esroot; ?>set-password.php",
            data: $('#set-new').serialize(),
            dataType: "json",
            success: function (data) {
              if (data.response === "success") {
                $(".btn-submit").button("reset");
                $("input[type=password]").val("");
                $('.form-group').removeClass('has-success');
                $("#msg").text("Your password has been reset.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 2000);
                setTimeout(function() {
                  window.location = "<? echo $esroot; ?>admin"
                }, 2500);
              } else {
                $("#success").addClass("hidden");
                $(".btn-submit").button("reset");
                $("#msg").text("Your passwords do not match.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 2000);
              }
            }
          });
        },
        rules: {
          password: {required: true, minlength: 8, mypassword: true},
          password2: {equalTo: "#password"}
        },
        highlight: function (element) {
          $(element)
            .closest(".form-group")
            .removeClass("has-success")
            .addClass("has-error");
          $(element)
            .siblings(".glyphicon")
            .removeClass("glyphicon-ok")
            .addClass("glyphicon-remove");
        },
        unhighlight: function (element) {
          $(element)
            .siblings(".glyphicon")
            .removeClass("glyphicon-remove");
        },
        success: function (element) {
          $(element)
            .siblings(".glyphicon")
            .removeClass("glyphicon-remove")
            .addClass("glyphicon-ok");
          $(element)
            .closest(".form-group")
            .removeClass("has-error")
            .addClass("has-success");
          
          },
          
          focusCleanup: true
      });
    }
  };
  SetNew.initialize();
</script>

</body>
</html>