<?php
include ('_inc/inc.config.php');
include ('login.php');
// include ('session.php');
$nav = 4;
$title = "JenJil Packaging Inc.";
$description = "Please reach out to us with any questions or comments regarding agricultural packaging and how our innovation and technology leads the packaging industry.";
$canon = $root . 'admin';
$amp = $root . "amp-template.html";
$datePub = "2017-10-17";
$dateMod = "2017-10-18";

if(isset($_SESSION['login_user'])){
  header("location: profile.php");
}
include('_inc/inc.head.php');
?>

<body>
<?php include('_inc/inc.nav.php'); ?>


<section class="admin">
  <div class="container">
			<div class="flip-container">
				<div class="flipper">
					<div class="panel one front">
						<div class="panel-heading">
							<h2>Administration</h2>
						</div>
						<div class="panel-body">
							<h2>Sign In</h2>
              <p><small>Are you a Customer? <a href="<?php echo $root; ?>certifications">Log in here.</a></small></p>
							<form action="" method="post">
								<div class="form-group">
									<input id="email" name="email" class="form-control input-lg" placeholder="email" type="email">
								</div>
								<div class="form-group">
									<input id="password" name="password" class="form-control input-lg" placeholder="**********" type="password">
								</div>
								<input name="submit" type="submit" class="btn btn-alt btn-lg btn-block" value=" Login ">
								<p class="text-center"><?php echo $error; ?></p>
								<p class="text-center small"><a class="admin-flip" href="#">Forgot Password?</a></p>
							</form>
						</div>
					</div>
					<div class="panel two back">
						<div class="panel-heading">
							<h1>Lost Password</h1>
						</div>
						<div class="panel-body">
							<h2>Password Reset<br /><small>Enter your username or email address and we will send you password reset instructions</small></h2>
							<form id="forgot" action="" method="post">
								<div class="form-group">
									<input id="email" name="email" class="form-control input-lg" placeholder="email address" type="text">
								</div>
								<button name="submit" type="submit" value-"submit" class="btn btn-alt btn-lg btn-block btn-submit">Reset Password</button>
								<p class="text-center small">Have an account? <a class="admin-flip" href="#">Sign In</a></p>
							</form>
						</div>
					</div>
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

<script src="<?php echo $root; ?>js/login-forgot-val.min.js"></script>
</body>
</html>