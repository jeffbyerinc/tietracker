<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.17.0/dist/additional-methods.min.js"></script>

<script>
  var esroot = "<?php echo $esroot; ?>";
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
      $("#certUpload").validate({
        submitHandler: function(form) {
          $('.btn-submit').html('Uploading <i class="fa fa-spinner fa-pulse"></i>');
          $.ajax({
            type: "POST",
            url: esroot+"_inc/inc.upload.php",
            processData: false,  // Important!
            contentType: false,
            data: new FormData(form[0]),
            
            success: function(data) {
              if (data.response === "success") {
                $('.btn-submit').html('Upload Certificates');
                $("input[type=text], input[type=tel], input[type=email], input[type=file], textarea").val("");
                $("input[type=radio]").prop('checked', false);
                $('label.active').removeClass('active');
                $('.form-group').removeClass('has-success');
                $("#upld").append("<h3 class='has-success'>Upload Successfull.</h3>");
                setTimeout(function() {
                //  location.reload();
                }, 2000);
              } else {
                $('#upld').append('<div class="alert alert-danger">'+data.message+'</div>');
                $('.btn-submit').html('Upload Certificates');
              }
            },
            error: function(data) {
              
            }
          });
        },
        rules: {

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
});
</script>