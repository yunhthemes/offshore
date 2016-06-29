jQuery(document).ready(function($) {

    // Perform AJAX login on form submit
    var $loginForm = $('form#login');
    $loginForm.on('submit', function(e){
        e.preventDefault();

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

});