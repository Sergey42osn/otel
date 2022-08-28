$(document).ready(function() {
  $('#phone').intlTelInput({
    dropdownContainer: 'body'
  });
  $('#phone3').intlTelInput({
    dropdownContainer: 'body'
  });
  $('#phone2').intlTelInput({
  });
  $('#phone4').intlTelInput({
  });
  
  $('.input-container').on('scroll', function() {
    $(window).scroll();
  });
});