<?php 
add_filter('widget_text', 'do_shortcode');

function custom_menu_item_shortcode() {
	if ( is_user_logged_in() ):
		$message_url = esc_url( bp_loggedin_user_domain() . 'messages' );
		$message_count = messages_get_unread_count();
		if($message_count>99) {
			$message_count = "99+";
		}
		echo '
		<div id="custom-right-header">
	    	<nav class="mkdf-main-menu mkdf-drop-down mkdf-default-nav">
				<ul>
					<li>
						<a href="'.$message_url.'" class="message"><i class="fa fa-envelope" aria-hidden="true"></i><span class="no">'.$message_count.'</span></a>
					</li>
					<li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
			    	    <a href="'.esc_url( get_permalink( get_page_by_title( 'Client services dashboard' ) ) ).'"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Client Dashboard</span></span><span class="plus"></span></span></a>
			    	</li>
					<li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
			    	    <a href="#" class="" id="custom-right-header-livechat"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">24/7 Support, Chat Now</span></span><span class="plus"></span></span></a>
			    	</li>
			    	<li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
			    	    <a href="'.wp_logout_url().'"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign Out</span></span><span class="plus"></span></span></a>
			    	</li>
			    </ul>
			</nav>
			<form id="logout" action="logout" method="post" style="display:none;">
            	<input class="submit_button" type="submit" value="Logout" name="submit">
            	'.wp_nonce_field( "ajax-logout-nonce", "logoutsecurity" ).'
            </form>
		</div>
		<script type="text/javascript">		
		jQuery(document).ready(function($) {			
		    $("#custom-right-header-livechat").click(function(event) {
		        event.preventDefault();		        
		        $zopim.livechat.say(" ");
		        $("body").addClass("custom-zopim-visible");
		    });

		    $("#custom-right-header-signin").mouseover(function(event) {
		        TweenMax.to($("#custom-right-header-signin-box"), 0.5, {
		            autoAlpha: 1
		        });
		    });
		    $(".custom-right-header-signin").click(function(event) {
		        TweenMax.to($("#custom-right-header-signin-box"), 0.5, {
		            autoAlpha: 1
		        });
		    });
		    $("#custom-right-header-signin-box").mouseleave(function(event) {
		        TweenMax.to($("#custom-right-header-signin-box"), 0.5, {
		            autoAlpha: 0
		        });
		    });		    
		});
		</script>';
	else:
		$args = array(
		    'echo' => false,         // To echo the form on the page
		    'redirect' => site_url( $_SERVER['REQUEST_URI'] ),   // The URL you redirect logged in users
		    'form_id' => 'loginform',                            // Id of the form
		    'label_username' => __( '' ),                // Label of username
		    'label_password' => __( '' ),                // Label of password
		    'label_remember' => __( 'Remember Me' ),             // Label for remember me
		    'label_log_in' => __( 'Sign in' ),                    // Label for log in
		    'id_username' => 'user_login',                       // Id on username textbox
		    'id_password' => 'user_pass',                        // Id on password textbox
		    'id_remember' => 'rememberme',                       // Id on rememberme textbox
		    'id_submit' => 'wp-submit',                          // Id on submit button
		    'remember' => false,                                  // Display remember me checkbox
		    'value_username' => NULL,                            // Default username value
		    'value_remember' => false
		);
		echo '
		<div id="custom-right-header">
	    	<nav class="mkdf-main-menu mkdf-drop-down mkdf-default-nav">
				<ul>
			    	<li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
			    	    <a href="#" class="" id="custom-right-header-livechat"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">24/7 Support, Chat Now</span></span><span class="plus"></span></span></a>
			    	</li>
			    	<li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
			    	    <a href="javscript:void(0);" id="custom-right-header-signin">
			    	        <span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign In</span></span><span class="plus"></span></span>
			    	    </a>
			    	    <div id="custom-right-header-signin-box">
			                 <!-- '.wp_login_form( $args ).' -->
			                 <form name="login" id="login" class="login" method="post">
								<p class="login-username">
									<label for="user_login"></label>
									<input type="text" name="username" id="username" class="input" value="" size="20" placeholder="Username">
								</p>
								<p class="login-password">
									<label for="user_pass"></label>
									<input type="password" name="password" id="password" class="input" value="" size="20" placeholder="Password">
								</p>								
								<p class="login-submit">
									<input type="submit" id="wp-submit" class="button-primary" value="Sign in">
									'.wp_nonce_field( 'ajax-login-nonce', 'security' ).'
								</p>								
								<a class="lost-password" href="#">Forgot password?</a>
							</form>
							<form name="lostpassword" id="lostpassword" class="lostpassword" method="post">
								<p class="login-username">
									<label for="user_login"></label>
									<input type="text" name="username_email" id="username_email" class="username_email input" value="" size="20" placeholder="Username or email">
									<p class="login-submit">
										<input type="submit" id="wp-submit" class="button-primary" value="Reset password">
										'.wp_nonce_field( 'ajax-lostpassword-nonce', 'lostpasswordsecurity' ).'
										<a href="#" class="back-to-login">Cancel</a>
									</p>
								</p>
							</form>
							<p class="status"></p>
			    	    </div>
			    	</li>
			    	<li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
			    	    <a href="'.esc_url( get_permalink( get_page_by_title( 'Sign Up' ) ) ).'"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign Up</span></span><span class="plus"></span></span></a>
			    	</li>
			    </ul>
		    </nav>
		</div>		
		<div id="forgot-password-popup" style="display:none; cursor: default;">
			<p>Your forgotten password request has been received.  Our staff will contact you shortly. <br>  Please click on OK to continue.</p>
			<a href="#" id="ok" class="custom-submit-class" style="min-height: auto!important;margin-top:10px;">OK</a>
		</div>
		<script type="text/javascript">
		jQuery(document).ready(function($) {
		    $("#custom-right-header-livechat").click(function(event) {
		        event.preventDefault();
		        $zopim.livechat.say(" ");
		        $("body").addClass("custom-zopim-visible");
		    });

		    $("#custom-right-header-signin").mouseover(function(event) {
		        TweenMax.to($("#custom-right-header-signin-box"), 0.5, {
		            autoAlpha: 1
		        });
		    });
		    $(".custom-right-header-signin").click(function(event) {
		        TweenMax.to($("#custom-right-header-signin-box"), 0.5, {
		            autoAlpha: 1
		        });
		    });
		    $("#custom-right-header-signin-box").mouseleave(function(event) {
		        TweenMax.to($("#custom-right-header-signin-box"), 0.5, {
		            autoAlpha: 0
		        });
		    });
		    $("#custom-right-header-signin-mobile").click(function(event) {
		    	if($("#custom-right-header-signin-box-mobile").hasClass("open") == false) {		    		
			        TweenMax.to($("#custom-right-header-signin-box-mobile"), 0.5, {
			            autoAlpha: 1, 
			            position: "relative",
			            top: 0,
			            left: 0
			        });

			        $(".sub_menu").slideUp(200);
			        $(".sub_menu").parent().removeClass("mkdf-opened");
		    	}
		    	else {
		    		TweenMax.to($("#custom-right-header-signin-box-mobile"), 0.5, {
			            autoAlpha: 0, 
			            position: "absolute",
			            top: -10,
			            left: 0
			        });
		    	}    	
		    	$("#custom-right-header-signin-box-mobile").toggleClass("open");
		    });

		    $(".lostpassword").hide();

		    $(".lost-password").on("click", function(e){
		    	e.preventDefault();

		    	$(".login").hide();
		    	$(".lostpassword").show();
		    	$("#custom-right-header-signin-box p.status").text("");
		    });

		    $(".back-to-login").on("click", function(e){
		    	e.preventDefault();

		    	$(".login").show();
		    	$(".lostpassword").hide();
		    	$("#custom-right-header-signin-box p.status").text("");
		    });

		    function validateAndSubmit($el) {
		    	$el.validate({
			    	rules: {
			    		"username_email": "required"	
			    	},
	        		messages: {		    	
	        			"username_email": "Please provide username or email"
	        		},
			        errorPlacement: function(error, element) {                            
			            element.attr("placeholder", error.text());
			        }
			    });

		    	$el.on("submit", function(e){
			    	e.preventDefault();

			    	if($el.valid()) {
				    	$el.parent().find("p.status").show().text("Sending...");
				    	$.ajax({
				          	type: "POST",
				          	url: siteurl+"/wp-admin/admin-ajax.php",
				          	data: {
				              	"action": "lostpassword", //calls wp_ajax_nopriv_ajaxlogout
				              	"username_email": $el.find(".username_email").val(),
				              	"security": $el.find("#lostpasswordsecurity").val() 
				          	},
				          	success: function(data) {		          		
				          		var result = JSON.parse(data);		          		
				              	$el.parent().find("p.status").text("");

				              	$.blockUI({ 
				            		message: $("#forgot-password-popup"),
				            		css: {
										padding: "30px",
										margin: 0,
										border: "0px",
										backgroundColor: "#fff",						
				            		},
				            		onOverlayClick: $.unblockUI
				            	});
				            	$("#forgot-password-popup").on("click", "#ok", function(e){
				            		e.preventDefault();
				            		e.stopPropagation();
							    	$.unblockUI();
							    	$(".login").show();
							    	$(".lostpassword").hide();
							    	$el.parent().find("p.status").text("");
							    });
				          	}
				      	});
				    }
			    });	
		    }

		    // var $lostpasswordForm = $("form.lostpassword");

		    validateAndSubmit($("form#lostpassword"));
		    validateAndSubmit($("form#mobilelostpassword"));

		    // $lostpasswordForm.on("submit", function(e){
		    // 	e.preventDefault();

		    // 	if($lostpasswordForm.valid()) {
			   //  	$("#custom-right-header-signin-box p.status").show().text("Sending...");
			   //  	$.ajax({
			   //        	type: "POST",
			   //        	url: siteurl+"/wp-admin/admin-ajax.php",
			   //        	data: {
			   //            	"action": "lostpassword", //calls wp_ajax_nopriv_ajaxlogout
			   //            	"username_email": $("form.lostpassword .username_email").val(),
			   //            	"security": $("form.lostpassword #lostpasswordsecurity").val() 
			   //        	},
			   //        	success: function(data) {		          		
			   //        		var result = JSON.parse(data);		          		
			   //            	$("#custom-right-header-signin-box p.status").text("");

			   //            	$.blockUI({ 
			   //          		message: $("#forgot-password-popup"),
			   //          		css: {
						// 			padding: "30px",
						// 			margin: 0,
						// 			border: "0px",
						// 			backgroundColor: "#fff",						
			   //          		},
			   //          		onOverlayClick: $.unblockUI
			   //          	});
			   //          	$("#forgot-password-popup").on("click", "#ok", function(){
						//     	$.unblockUI();
						//     	$("#login").show();
						//     	$("#lostpassword").hide();
						//     	$("#custom-right-header-signin-box p.status").text("");
						//     });
			   //        	}
			   //    	});
			   //  }
		    // });		    
		});
		</script>';
	endif;

    // return wp_login_form( $args );
}
// shortcode [custom_menu_item]
add_shortcode( 'custom_menu_item', 'custom_menu_item_shortcode' );
?>