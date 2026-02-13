function getStarted() {
  setTimeout(function() {
    $('#getStarted').animate({
      opacity: 1.0,
      bottom: "+=20"
    }, 200, function() { });
  }, 10000);
}
$(document).ready(function($){
  $('.admin-flip').on('click', function(e) {
    e.preventDefault;
    $('.flip-container').toggleClass('flip');
  });
  $(".btn").click(function() {
    if($(this).data('message')) {
      var msg = $(this).data('message');
      sessionStorage.setItem('message', msg);
    }
  });
});