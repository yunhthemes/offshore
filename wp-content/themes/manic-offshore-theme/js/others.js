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

  $('.mkdf-breadcrumbs-inner > a').first().html('Home');

  $('.mkdf-title-holder h1').clone().appendTo('#custom-page-title');
  $('.mkdf-breadcrumbs-holder').clone().appendTo('#custom-breadcrumb');

  $('#user_login').attr( 'placeholder', 'Username' );
  $('#user_pass').attr( 'placeholder', 'Password' );

  function formatDate(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var ampm = hours >= 12 ? 'pm' : 'am';
    hours = hours % 12;
    hours = hours ? hours : 12; // the hour '0' should be '12'
    minutes = minutes < 10 ? '0'+minutes : minutes;
    var strTime = hours + ':' + minutes + ' ' + ampm;
    return date.getMonth()+1 + "/" + date.getDate() + "/" + date.getFullYear() + "  " + strTime;
  }

  function formatDate2(date){
    dateString=date;
    dateString=dateString.toString().split(' ').slice(0, 5).join(' ')
    return dateString;
  }

  function getTime(offset)
  {
      var d = new Date();
      localTime = d.getTime();
      localOffset = d.getTimezoneOffset() * 60000;

      // obtain UTC time in msec
      utc = localTime + localOffset;
      // create new Date object for different city
      // using supplied offset
      var nd = new Date(utc + (3600000*offset));    
      console.log(nd);
      return formatDate2(nd);
      
  }

  var utctime = $('#current_date_time').attr('date-utctime');
  $('#current_date_time').html(getTime(utctime));

});
