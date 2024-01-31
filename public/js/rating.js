$(document).ready(function(){
  $('#rating').on('input', function() {
      $('#rating_indicator').text($('#rating').val() + '★');
  });
});
