<?php
require 'php-mailer/class.phpmailer.php';
include ('_inc/inc.config.php');
include ('login.php');
// include ('session.php');
if(isset($_GET['activationkey'])) {
  $activationkey = $_GET["activationkey"];
}
$nav = 4;
$title = "Product Certifications - JenJil Packaging Inc.";
$description = "Please reach out to us with any questions or comments regarding agricultural packaging and how our innovation and technology leads the packaging industry.";
$canon = $esroot . 'certifications';
$amp = $esroot . "amp-template.html";
$datePub = "2017-10-17";
$dateMod = "2018-04-04";
include('_inc/inc.head.php'); ?>
 
<body>
<?php include('_inc/inc.nav.php'); ?>
  
<section class="certifications">
  <div class="container">
    <h1>Product Certifications</h1>
  </div>
</section>

<section>
  <div class="container">
    <div class="row">
      <div class="col-md-5 mr-auto">
<?php 
if(!isset($activationkey)) { 
?>
        <h2>Account Verification</h2>
        <p><small>Invalid account verification link.</small></p>

<?php 
} else {
  if ($result = $link->query("SELECT * FROM login WHERE activationkey = '$activationkey'")) {
    if(mysqli_num_rows($result) == 1 ) { 
      while($row = mysqli_fetch_assoc($result)) {
        $userid = $row['id'];
        $username = $row['name'];
        $company = $row['company'];
        $email = $row['email'];
        $subject = "New JenJil Account";
        $query="UPDATE login SET status='0', activationkey = '' WHERE id='$userid' ";
        $link->query($query);
        $message = "<h1>New JenJil User Verified</h1><br>\n";
        $message .="Name: " . $username . "<br>\n";
        $message .="Email: " . $email . "<br>\n";
        $message .="Company: " . $company . "<br><br>\n";
        $mail = new PHPMailer;
        $mail->IsSMTP();
      /*
        //Enable SMTP debugging
        // 0 = off (for production use)
        // 1 = client messages
        // 2 = client and server messages
        $mail->SMTPDebug = 0;
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = 'globaldogg@gmail.com';
        $mail->Password = 'cobalt';
      */
        $mail->From = 'info@jenjilpackaging.com';
        $mail->FromName = 'JenJil Certifications';
        $mail->AddAddress('jeff@jbyer.com');
        $mail->AddAddress('lori@jenjilpackaging.com');
        $mail->AddAddress('brad@jenjilpackaging.com');
        $mail->AddReplyTo('info@jenjilpackaging.com', 'JenJil Certifications');
        $mail->IsHTML(true);      
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->Send();
?>
        <h2><i class="fa fa-check has-success"></i> Account Verified</h2>
        <h3>Next: Set Your Password</h3>
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
          <input name="submit" type="submit" class="btn btn-lg btn-block" value="Set Password">
          
          <p class="text-center">Have an account? <a href="<?php echo $esroot; ?>certifications">Sign In</a></p>
        </form>

<?php 
      }
    } else { ?>
      <h2>Account Verification failed.</h2>
      <p>Please try to <a href="<?php echo $esroot; ?>sign-up">Sign Up</a> again, or Reset Your Password.</p>
<?php    
    }
  }
}
?>
      </div>
      <div class="col-md-6">
        <p>Food and product safety is paramount to our customers. Our team and network of vendors share these same concerns.  As a result, we operate under the highest, most qualified food-safety practices and continue to invest in innovative packaging processes to evolve along with our customer’s requirements. Our certifications, to name a few, include the ISO 9000, BRC Global Standards, GMA-SAFE and FDA Certification. Our HAACP Alliance certification is in progress. </p>
      </div>
    </div>

  </div>
</section>

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
            url: "<?php echo $esroot; ?>forgot-password.php",
            data: $('#forgot').serialize(),
            dataType: "json",
            success: function (data) {
              if (data.response === "success") {
                $(".btn-submit").button("reset");
                $("input[type=text]").val("");
                $('.form-group').removeClass('has-success');
                $("#sendingTitle").text("Password reset instructions sent by email.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 2000);
                setTimeout(function() {
                  window.location = "<?php echo $esroot; ?>admin"
                }, 2500);
              } else {
                $("#success").addClass("hidden");
                $(".btn-submit").button("reset");
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
            url: "<?php echo $esroot; ?>set-password.php",
            data: $('#set-new').serialize(),
            dataType: "json",
            success: function (data) {
              if (data.response === "success") {
                $(".btn-submit").button("reset");
                $("input[type=password]").val("");
                $('.form-group').removeClass('has-success');
                $("#sendingTitle").text("Your password has been reset.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 2000);
                setTimeout(function() {
                  window.location = "<?php echo $esroot; ?>certifications"
                }, 2500);
              } else {
                $("#success").addClass("hidden");
                $(".btn-submit").button("reset");
                $("#sendingTitle").text("Your passwords do not match.");
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