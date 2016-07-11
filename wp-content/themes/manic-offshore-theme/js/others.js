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

  $(".mkdf-mobile-menu-opener a").on("click", function(e){
      e.preventDefault();
      if($(".mkdf-mobile-nav").css("display") == "none") {
        $("body").css("height", "100%");
        $(".mkdf-wrapper").css("height", "100%");
        $(".mkdf-wrapper-inner").css("height", "100%");        
      }else {
        $("body").css("height", "auto");
        $(".mkdf-wrapper").css("height", "auto");
        $(".mkdf-wrapper-inner").css("height", "auto");
      }
  });

  /// cheat

  $(".profile-fields a").attr("href","#");  

  if($("#copy-banner").length > 0) {
    
    var bannerHtml = $("#copy-banner").clone();
    console.log($(bannerHtml).attr("id", "copied-banner"));

    $(".mkdf-content").find(".mkdf-content-inner").prepend(bannerHtml);

  }

  // url cheat
  var currentUrl = document.location.href;
  var oldUrl = document.location.href;

  if(currentUrl.substr(-1) == '/') {
    currentUrl = currentUrl.substring(0, currentUrl.length - 1);  
  }

  var urlArr = currentUrl.split('/');

  // console.log(urlArr)
  // console.log(urlArr.length) // url length 6 is profile landing page
  if(currentUrl.indexOf('client-dashboard') > -1) {
    if(urlArr.length == 6 || currentUrl.indexOf('profile') > -1 || currentUrl.indexOf('settings') > -1) {

        if(urlArr[2]=="clients.manic.com.sg" || urlArr[2]=="localhost:8888") {
          urlArr.splice(5, 1);
          urlArr = urlArr.slice(0, 5);
        }else {
          urlArr.splice(4, 1);
          urlArr = urlArr.slice(0, 4);
        }

        var newUrl = urlArr.join("/") + "/profile"; 

        // console.log(newUrl);

        history.pushState({page: 'new'}, "new url", newUrl);
    }
    else {
        
        if(urlArr[2]=="clients.manic.com.sg" || urlArr[2]=="localhost:8888") {
          urlArr.splice(5, 1);
        }else {
          urlArr.splice(4, 1);
        }      

        var newUrl = urlArr.join("/");      

        history.pushState({page: 'new'}, "new url", newUrl);
    }

    window.alert = function() { return true; }
  }  

  $(window).on('load', function(){
      // history.back();
  });


  // window.onbeforeunload = function(event)
  // {
  //     event.preventDefault()
  //     document.location.href = oldUrl;
  //     return true;
  // };

  // $(window).on('beforeunload', function(e){
  //     // your logic here
  //     e.preventDefault();
  //     // history.pushState({}, null, oldUrl);
  //     location.assign(oldUrl);
  //     return 'Reload the page';
  // });

  // var a, b = false,
  //   c = oldUrl;


  // // if url has been changed
  // if(history.state.page == 'new') {
  //   window.onbeforeunload = function (e) {
  //     console.log(window.event);
  //     if (b) return;
  //     a = setTimeout(function () {
  //         b = true;

  //         // window.location.href = c;
  //         c = oldUrl;          
  //     }, 500);
  //     return "";
  //   }  
  // }
  
  // window.onunload = function () {
  //     clearTimeout(a);
  // }


  // hide star message
  if($('body.inbox').find(".message-action-unstar").length > 0) {
    // $('body.inbox').find(".message-action-unstar").parent().parent().remove();
  }

  // $('.stepwizard-row').slick({
  //   slidesToShow: 2,
  //   slidesToScroll: 1,
  //   arrows: false,
  //   fade: true
  // });

});
