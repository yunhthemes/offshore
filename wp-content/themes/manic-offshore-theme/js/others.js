jQuery(document).ready(function($) {
  $('select').change(function() {
   if ($(this).val() == '') {
     $(this).addClass('placeholder');
   } else {
    $(this).removeClass('placeholder');
   }
  });

  var arr = $('select');
  var item = null;
  for (var i = 0, l=arr.length; i < l; i++) {
    item = $(arr[i]);
    if (item.val() == 0) {
      item.addClass('placeholder');
    }
  }

  $('.mkdf-title-holder h1').clone().appendTo('#custom-page-title');
  $('.mkdf-breadcrumbs-holder').clone().appendTo('#custom-breadcrumb');

  $('.mkdf-breadcrumbs-inner > a').html('Home');

  $('#user_login').attr( 'placeholder', 'Username' );
  $('#user_pass').attr( 'placeholder', 'Password' );

});
