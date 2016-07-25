jQuery(document).ready(function($) {

    // Perform AJAX login on form submit
    var $loginForm = $('form#login');
    $loginForm.on('submit', function(e){
        e.preventDefault();
        e.stopPropagation();

        if($loginForm.valid()) {
            $('form#login p.status').show().text(ajax_login_object.loadingmessage);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_login_object.ajaxurl,
                data: { 
                    'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                    'username': $('form#login #username').val(), 
                    'password': $('form#login #password').val(), 
                    'security': $('form#login #security').val() },
                success: function(data){
                    if(data.message=='Wrong username or password.') {
                        $('form#login #username').addClass("ajax-error");
                        $('form#login #password').addClass("ajax-error");   
                    }else {
                        $('form#login #username').removeClass("ajax-error");
                        $('form#login #password').removeClass("ajax-error");    
                    }
                    $('form#login p.status').text(data.message);                    
                    if (data.loggedin == true){
                        window.canExit = true;
                        document.location.href = ajax_login_object.redirecturl;
                    }
                }
            });    
        }
    });

    $loginForm.validate({
        focusInvalid: false,
        rules : {
            "username": "required",
            "password": "required"
        },
        messages: {
            "username" : "Please provide username",
            "password" : "Please provide password"
        },
        errorPlacement: function(error, element) {                            
            element.attr("placeholder", error.text());
        }
    });

    // Perform AJAX login on form submit
    var $mobileloginForm = $('form#mobilelogin');
    // console.log($mobileloginForm);

    $mobileloginForm.on('submit', function(e){
        e.preventDefault();

        if($mobileloginForm.valid()) {
            $('form#mobilelogin p.status').show().text(ajax_login_object.loadingmessage);
            $.ajax({
                type: 'POST',
                dataType: 'json',
                url: ajax_login_object.ajaxurl,
                data: { 
                    'action': 'ajaxlogin', //calls wp_ajax_nopriv_ajaxlogin
                    'username': $('form#mobilelogin .username').val(), 
                    'password': $('form#mobilelogin .password').val(), 
                    'security': $('form#mobilelogin #security').val() },
                success: function(data){
                    if(data.message=='Wrong username or password.') {
                        $('form#mobilelogin .username').addClass("ajax-error");
                        $('form#mobilelogin .password').addClass("ajax-error");   
                    }else {
                        $('form#mobilelogin .username').removeClass("ajax-error");
                        $('form#mobilelogin .password').removeClass("ajax-error");    
                    }
                    $('form#mobilelogin p.status').text(data.message);                    
                    if (data.loggedin == true){
                        window.canExit = true;
                        document.location.href = ajax_login_object.redirecturl;
                    }
                }
            });    
        }
    });

    $mobileloginForm.validate({
        focusInvalid: false,
        rules : {
            "username": "required",
            "password": "required"
        },
        messages: {
            "username" : "Please provide username",
            "password" : "Please provide password"
        },
        errorPlacement: function(error, element) {                            
            element.attr("placeholder", error.text());
        }
    });

});