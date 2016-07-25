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
  
  window.onbeforeunload = function(event) {        
    if (!window.canExit) {

      console.log('loggouting out');

      $.ajax({
          type: 'POST',
          url: siteurl+'/wp-admin/admin-ajax.php',
          data: {
              'action': 'ajaxlogout', //calls wp_ajax_nopriv_ajaxlogout
              'logoutsecurity': $('form#logout #logoutsecurity').val() 
          },
          success: function(data) {
              console.log('successfully logged out');
          }
      });      

    }else { console.log('navigating'); }
     
    return undefined;

  }

  // Attach the event click for all links in the page
  $("body").on("click", "a", function(e) {
    window.canExit = true;
  });

    // Attach the event submit for all forms in the page
  $("form").on("submit", function() {
    window.canExit = true;
  });

   // Attach the event click for all inputs in the page
  $("input[type=submit]").on("click", function() {
    window.canExit = true;
  });

  var isMobile = false; //initiate as false
  // device detection
  if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) isMobile = true;

  function isPortrait() {
      return window.innerHeight > window.innerWidth;
  }

  if(isMobile) {
    if(isPortrait) {
      $("#homepage-content-row").detach().insertAfter('#homepage-icons-row');
    }
  }

});
