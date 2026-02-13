<div class="container">
  <div class="row">
    <div class="col-6 mt-5">
      <h3>Welcome <?php echo $login_name; ?></h3>
    </div>
    <div class="col-6 mt-5 text-right">
      <div class="admin-nav">
      <a class="btn" href="<?php echo $esroot; ?>profile">Dashboard</a>
      <?php 
        $user = $_SESSION['login_user'];
        $admin = $login_level > 5; 
        $admin2 = "alicox";
        $admin3 = "napcadmin";
        if($login_level > 5) { 
      ?>
      <a class="btn" href="<?php echo $esroot; ?>certification-upload.php">Certifications</a>
      <a class="btn" href="<?php echo $esroot; ?>users/edit.php">Edit Users</a>
      <?php 
        }
      ?>
      <a class="btn btn-alt" href="<?php echo $esroot; ?>logout.php">Log Out</a>
    </div>
  </div>		
</div>
<hr />