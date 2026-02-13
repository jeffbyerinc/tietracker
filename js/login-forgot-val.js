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
      $("#sending").modal('toggle');
      $.ajax({
        type: "POST",
        url: "forgot-password.php",
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
            }, 2500);
          } else {
            $("#success").addClass("hidden");
            $(".btn-submit").button("reset");
            $("#sending .loader").fadeOut('fast');
            $("#sendingTitle").text("Your email or username does not exist in our system.");
            setTimeout(function() {
              $('#sending').modal('hide');
            }, 2500);
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