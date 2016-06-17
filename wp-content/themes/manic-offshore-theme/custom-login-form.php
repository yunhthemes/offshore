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
			    	    <a href="'.wp_logout_url(home_url()).'"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign Out</span></span><span class="plus"></span></span></a>
			    	</li>
			    </ul>
			</nav>
		</div>';
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
			    	    <a href="#" id="custom-right-header-signin">
			    	        <span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign In</span></span><span class="plus"></span></span>
			    	    </a>
			    	    <div id="custom-right-header-signin-box">
			                 <!-- '.wp_login_form( $args ).' -->
			                 <form name="login" id="login" method="post">
								<p class="login-username">
									<label for="user_login"></label>
									<input type="text" name="username" id="username" class="input" value="" size="20" placeholder="Username">
								</p>
								<p class="login-password">
									<label for="user_pass"></label>
									<input type="password" name="password" id="password" class="input" value="" size="20" placeholder="Password">
								</p>
								<!-- <a class="lost" href="'.wp_lostpassword_url().'">Lost your password?</a> -->
								<p class="login-submit">
									<input type="submit" id="wp-submit" class="button-primary" value="Sign in">
									'.wp_nonce_field( 'ajax-login-nonce', 'security' ).'
								</p>
								<p class="status"></p>								
							</form>
			    	    </div>
			    	</li>
			    	<li class="menu-item menu-item-type-post_type menu-item-object-page narrow">
			    	    <a href="'.esc_url( get_permalink( get_page_by_title( 'Sign Up' ) ) ).'"><span class="item_outer"><span class="item_inner"><span class="menu_icon_wrapper"><i class="menu_icon null fa"></i></span><span class="item_text">Sign Up</span></span><span class="plus"></span></span></a>
			    	</li>
			    </ul>
		    </nav>
		</div>
		<script src="http://cdnjs.cloudflare.com/ajax/libs/gsap/1.18.0/TweenMax.min.js"></script>
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
		    $("#custom-right-header-signin-box").mouseleave(function(event) {
		        TweenMax.to($("#custom-right-header-signin-box"), 0.5, {
		            autoAlpha: 0
		        });
		    });

		});
		</script>';
	endif;

    // return wp_login_form( $args );
}
// shortcode [custom_menu_item]
add_shortcode( 'custom_menu_item', 'custom_menu_item_shortcode' );
?>