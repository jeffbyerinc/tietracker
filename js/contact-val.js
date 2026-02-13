$(document).ready( function() {    
  $("#expand").on("click", function() {
    $('.head.contact').toggleClass('on');
  });
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
    $("#contactForm").validate({
      submitHandler: function(form) {
        $('.btn-submit').button('loading');
        $('#sending').modal('show');
        $.ajax({
          type: "POST",
          url: "contact-form.php",
          data: $('#contactForm').serialize(),
          dataType: "json",
          success: function (data) {
            if (data.response === "success") {
              $(".btn-submit").button("reset");
              $("input[type=text], input[type=tel], input[type=email], textarea").val("");
              $('.form-group').removeClass('has-success');
              $("#sending .loader").fadeOut('fast');
              $("#sendingTitle").text("Message Sent Successfully.");
              sessionStorage.clear();
              ga('send', 'event', { eventCategory: 'Contact', eventAction: 'Contact Request', eventLabel: 'Contact Form'});
              setTimeout(function() {
                $('#sending').modal('hide');
              }, 2000);
            } else {
              $("#success").addClass("hidden");
              $(".btn-submit").button("reset");
            }
          }
        });
      },
      rules: {
        name: {required: true},
        company: {required: true},
        email: {required: true,email: true},
        phone: {required: true,minlength: 10}
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

var map;
function initialize() {

if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      var zm = 16;
    } else {
      var zm = 16;
    }
var mapOptions = {
    zoom: 14,
    center: new google.maps.LatLng(37.4958352,-120.8761927),
    disableDefaultUI: false,
    navigationControl: true,
    mapTypeControl: false,
    scrollwheel: false,
    scaleControl: false,
    styles:
    [
      {"featureType":"water","elementType":"geometry","stylers":[
        {"color":"#212121"}]},
      {"featureType":"landscape","elementType":"geometry","stylers":[
        {"color":"#000000"}]},
      {"featureType":"road","elementType":"geometry","stylers":
        [{"color":"#313131"}]},
      {"featureType":"poi","elementType":"geometry","stylers":[
        {"color":"#000000"}]},
      {"featureType":"transit","elementType":"geometry","stylers":[
        {"color":"#000000"}]},
      {"elementType":"labels.text.stroke","stylers":[
        {"visibility":"off"},
        {"color":"#000000"},
        {"weight":2},
        {"gamma":0.84}]},
      {"elementType":"labels.text.fill","stylers":[
        {"color":"#989898"}]},
      {"featureType":"administrative","elementType":"geometry","stylers":[
        {"weight":0.6},
        {"color":"#000000"}]},
      {"elementType":"labels.icon","stylers":[
        {"visibility":"off"}]},
      {"featureType":"poi.park","elementType":"geometry","stylers":[
        {"color":"#000000"}]}]
  };
  map = new google.maps.Map(document.getElementById('map'), mapOptions);
  var addresses = [
    new google.maps.LatLng(37.4958352,-120.8761927)
  ];
  var markerImage = new google.maps.MarkerImage('img/map-icon-light.png',
                    new google.maps.Size(42, 42),
                    new google.maps.Point(0, 0),
                    new google.maps.Point(30, 38));
  var markers = [];
  for (var x = 0; x < addresses.length; x++) {   
     addMarker(addresses[x], x);
  }
  function addMarker(position, x) {
    setTimeout(function() {
      markers.push(new google.maps.Marker({
        position: position,
        map: map,
        icon: markerImage,
        animation: google.maps.Animation.DROP
      }));
    }, 160*x);
  }
  var contentString = '<strong>JenJil Packaging Co.</strong><br />Headquarters<br />2262 Maryann Drive<br />Turlock, CA 95380<br /><br /><a class="btn btn-green" href="https://www.google.com/maps/dir/current+location/2262+Maryann+Dr,+Turlock,+CA+95380/@37.4958352,-120.8761927,17z/data=!4m13!1m4!3m3!1s0x809107986169fe6f:0x4c3db1645dd5b1d4!2s2262+Maryann+Dr,+Turlock,+CA+95380!3b1!4m7!1m0!1m5!1m1!1s0x809107986169fe6f:0x4c3db1645dd5b1d4!2m2!1d-120.874004!2d37.495831" target="_blank">Get Directions</a>';
  var infowindow = new google.maps.InfoWindow({
      content: contentString,
      position: new google.maps.LatLng(37.4958352,-120.8761927)
  });
//  infowindow.open(map);
}
function loadScript() {
  var script = document.createElement('script');
  script.type = 'text/javascript';
  script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyCXI3fQ-_Fs2mlvDXtiJySJWgLZf6dNBSE&v=3.exp&' + 'callback=initialize';
  document.body.appendChild(script);
}
window.onload = loadScript;