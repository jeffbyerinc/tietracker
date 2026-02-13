<?php
include ('_inc/inc.config.php');
include ('login.php');
// include ('session.php');
$nav = 9;
$title = "Product Certifications - JenJil Packaging Inc.";
$description = "Please reach out to us with any questions or comments regarding agricultural packaging and how our innovation and technology leads the packaging industry.";
$canon = $esroot . 'certifications';
$amp = $esroot . "amp-template.html";
$datePub = "2017-10-17";
$dateMod = "2018-04-04";
include('_inc/inc.head.php'); ?>

<body>
<?php include('_inc/inc.nav.php'); ?>
  
  <section class="head">
    <div class="container">
      <h1>Product Certifications</h1>
    </div>
  </section>
  <div class="container">

<?php 
  if(!isset($_SESSION['login_user'])){
?>
    <section>
      <div class="row">
        <div class="col-md-5 mr-auto">      
          <h2>Sign Up</h2>
          <p><small>* All fields required. Already have an account? <a href="<?php echo $esroot; ?>certifications">Login here</a></small></p>
          <form id="user" class="form hidelabels" role="form" action type="post">

            <div class="row top20">
              <div class="col-sm-12">
                <input type="hidden" class="form-control" name="id">
                <div class="form-group has-feedback">
                  <label for="name" class="control-label hidden">Name<span>*</span></label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Name">
                  <i class="fa form-control-feedback"></i>
                </div>

                <div class="form-group has-feedback">
                  <label for="email" class="control-label hidden">Email<span>*</span></label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                  <i class="fa form-control-feedback"></i><div id="msg"></div>
                </div>

                <div class="form-group has-feedback">
                  <label for="phone" class="control-label hidden">Phone</label>
                  <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone">
                  <i class="fa form-control-feedback"></i>
                </div>

                <div class="form-group has-feedback">
                  <label for="company" class="control-label hidden">Company</label>
                  <input type="text" class="form-control" id="company" name="company" placeholder="Company">
                  <i class="fa form-control-feedback"></i>
                </div>
              </div>
            </div>       
            <button type="submit" class="btn btn-alt btn-lg btn-block btn-submit">Sign Up</button>
          </form>
        </div>
        <div class="col-md-6">
          <p>Food and product safety is paramount to our customers. Our team and network of vendors share these same concerns.  As a result, we operate under the highest, most qualified food-safety practices and continue to invest in innovative packaging processes to evolve along with our customer’s requirements. Our certifications, to name a few, include the ISO 9000, BRC Global Standards, GMA-SAFE and FDA Certification. Our HAACP Alliance certification is in progress. </p>
        </div>
      </div>
    </section>

<?php 
  }
  if(isset($_SESSION['login_user'])){
    $user = $_SESSION['login_user'];
    $sql="SELECT * FROM login WHERE email='$user'";
    $result=$link->query($sql);
    $count=mysqli_num_rows($result);
    if($count==1) {
      $row = $result->fetch_assoc();
      $login_name = $row['name'];
    }
?>

    <section>
      <div class="row">
        <div class="col-md-6">
          <h2>Welcome <?php echo $login_name; ?></h2>
        </div>
        <div class="col-md-6 text-right">
          Not <?php echo $login_name; ?>? <a class="btn btn-alt ml-2" href="<?php echo $esroot; ?>logout.php">Log Out</a>
        </div>
      </div>
      <hr />
      <div class="row">
        <div class="col-md-5 mr-auto">
          <a href="<?php echo $esroot; ?>certifications" class="btn btn-lg btn-block">View My Certificates</a>
        </div>
      </div>
    </section>
      
<?php
  } 
?>

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
<script type="text/javascript" src="<?php echo $esroot; ?>js/signup-val.min.js"></script>
  </body>
</html>
