$('#name').change(function() {
  sessionStorage.setItem('name', $(this).val());
})
if(sessionStorage.getItem('name')) {
  $('#name').val(sessionStorage.getItem('name'));
}
$('#company').change(function() {
  sessionStorage.setItem('company', $(this).val());
})
if(sessionStorage.getItem('company')) {
  $('#company').val(sessionStorage.getItem('company'));
}
$('#phone').change(function() {
  sessionStorage.setItem('phone', $(this).val());
})
if(sessionStorage.getItem('phone')) {
  $('#phone').val(sessionStorage.getItem('phone'));
}
$('#email').change(function() {
  sessionStorage.setItem('email', $(this).val());
})
if(sessionStorage.getItem('email')) {
  $('#email').val(sessionStorage.getItem('email'));
}

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
          $("#sending").modal('toggle');
          $.ajax({
            type: "POST",
            url: "users/save.php",
            data: $('#user').serialize(),
            dataType: "json",
            success: function(data) {
              if (data.response === "success") {
                $('.btn-submit').html('Sign Up');
                $("input[type=text], input[type=tel], input[type=email], textarea").val("");
                $("input[type=radio]").prop('checked', false);
                $('label.active').removeClass('active');
                $('.form-group').removeClass('has-success');
                $("#sending .loader").fadeOut('fast');
                sessionStorage.clear();
                $("#sendingTitle").text("Sign Up Sent Successfully. Please Check Your Email.");
                setTimeout(function() {
                  $('#sending').modal('hide');
                }, 4000);
              } else {
                $('#msg').html('<div class="alert alert-danger">'+data.message+'</div>');
                $('.btn-submit').html('Sign Up');
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
          name: {required: true},
          phone: {required: true},
          company: {required: true},
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
});