$(document).ready(function(){
  var forgot = {
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
          $('.btn-submit').html('Sending <i class="fa fa-spinner fa-pulse"></i>');
          $("#sending").modal('toggle');
          $.ajax({
            type: "POST",
            url: "forgot-password.php",
            data: $('#forgot').serialize(),
            dataType: "json",
            success: function(data) {
              if (data.response === "success") {
                $('.btn-submit').html('Sign Up');
                $("input[type=text], input[type=tel], input[type=email], textarea").val("");
                $("input[type=radio]").prop('checked', false);
                $('label.active').removeClass('active');
                $('.form-group').removeClass('has-success');
                $("#sending .loader").fadeOut('fast');
                $("#sendingTitle").html("Request Sent Successfully. Please Check Your Email.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 4000);
              } else {
                $('.btn-submit').html('Reset Password');
                $("#sending .loader").fadeOut('fast');
                $("#sendingTitle").text("There was an error with your request.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 2000);
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
  forgot.initialize();
});