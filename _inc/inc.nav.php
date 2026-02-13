<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?php echo $root; ?>">Timetracker</a> Welcome <?php echo $login_name; ?>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ttnav" aria-controls="ttnav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="ttnav">
	    <ul class="navbar-nav mr-auto">
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo $root; ?>timetracker/">Track Time <span class="sr-only"></span></a>
	      </li>
        <li class="nav-item">
          <a class="nav-link" href="#" onclick="ttpopper();" rel="noopener">POP Window <span class="sr-only"></span></a>
        </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo $root; ?>timetracker/reports.php">Monthly Reports <span class="sr-only"></span></a>
	      </li>
	      <li class="nav-item">
	        <a class="nav-link" href="<?php echo $root; ?>timetracker/reports-annual.php">Annual Reports <span class="sr-only"></span></a>
	      </li>
	    </ul>
	  </div>
  </div>
</nav>
<script>
  function ttpopper() {
   window.open("<?php echo $root; ?>timetracker/pop", "_blank", "toolbar=no,scrollbars=no,resizable=no,top=50,left=50,width=400,height=472"); 
  }
 </script>