$(document).ready( function() {    
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
  $('#message').change(function() {
    sessionStorage.setItem('message', $(this).val());
  })
  if(sessionStorage.getItem('message')) {
    $('#message').val(sessionStorage.getItem('message'));
  }
});
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
    $("#orderForm").validate({
      submitHandler: function(form) {
        $('.btn-submit').button('loading');
        $("#sending").modal('toggle');
        $.ajax({
          type: "POST",
          url: "order-form.php",
          data: $('#orderForm').serialize(),
          dataType: "json",
          success: function(data) {
            if (data.response === "success") {
              $(".btn-submit").button("reset");
              $("input[type=text], input[type=tel], input[type=email], textarea").val("");
              $("input[type=radio]").prop('checked', false);
              sessionStorage.clear();
              $('.prod-group').html('');
              $('label.active').removeClass('active');
              $('.form-group').removeClass('has-success');
              $("#sending .loader").fadeOut('fast');
              $("#sendingTitle").text("Message Sent Successfully.");
              setTimeout(function() {
                $('#sending').modal('hide');
              }, 2000);
            }
          },
          error: function(data) {
              $("#success").addClass("hidden");
              $(".btn-submit").button("reset");
              $("#sending .loader").fadeOut('fast');
              $("#sendingTitle").text("There was an error. Please try again.");
              setTimeout(function() {
                $('#sending').modal('hide');
              }, 2000);
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
Contact.initialize();