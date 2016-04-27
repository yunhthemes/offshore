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

  $('.mkdf-title').find('.mkdf-title-holder h1').clone().appendTo('#custom-page-title');
  $('.mkdf-title').find('.mkdf-breadcrumbs-holder').clone().appendTo('#custom-breadcrumb');

  $('#user_login').attr( 'placeholder', 'Username' );
  $('#user_pass').attr( 'placeholder', 'Password' );

  function formatDate(currentcountry, date){
    dateString=date;
    // dateString=dateString.toString().split(' ').slice(0, 5).join(' ')
    var dateArr = (dateString.toString().split(' ').slice(0, 5))    
    var timeArr = dateArr[4].split(':');

    dateString = "Present time in "+currentcountry+": "+dateArr[0]+", "+dateArr[2]+" "+dateArr[1]+" "+dateArr[3]+" "+timeArr[0]+":"+timeArr[1]+" hrs";

    return dateString;
  }

  function getTime(currentcountry, offset)
  {
      var d = new Date();
      localTime = d.getTime();
      localOffset = d.getTimezoneOffset() * 60000;

      // obtain UTC time in msec
      utc = localTime + localOffset;
      // create new Date object for different city
      // using supplied offset
      var nd = new Date(utc + (3600000*offset));    

      if(nd=="Invalid Date"){
        return "";
      }
      return formatDate(currentcountry, nd);
      
  }

  // var utctime = $('#current_date_time').attr('data-utctime');

  // $('#current_date_time').html(getTime(currentcountry, utctime));

  // console.log(moment().tz("America/Los_Angeles").format('MMMM Do YYYY, h:mm:ss'));

  var currentcity = $('#current_date_time').attr('data-city');
  var currentcountry = $('#current_date_time').attr('data-country');
  
  if(currentcity=="") currentcity="none";  

  function makeRequest(Data, URL, Method) {

      var request = $.ajax({
          url: URL,
          type: Method,
          data: Data,
          success: function(response) {
              // if success remove current item
              // console.log(response);
          },
          error: function( error ){
              // Log any error.
              console.log("ERROR:", error);
          }
      });

      return request;
  };

  if(currentcountry) {
    var response = makeRequest("", siteurl+"/b/api/gettimezonelist/"+currentcountry+"/"+currentcity, "GET");

    response.done(function(data, textStatus, jqXHR){                    
      if(jqXHR.status==200) {

        $('#current_date_time').html(data);

      }
    });
  }  

});
