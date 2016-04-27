<?php
/********************************************************************************************************/
/* CONSTANTS */
/********************************************************************************************************/

define("THEMEROOT", get_stylesheet_directory_uri());
define("IMAGES", THEMEROOT."/img");
define("JS", THEMEROOT."/js");
define("APP", THEMEROOT."/app");
define("SITEURL", get_site_url());

/*** Child Theme Function  ***/

function mkdf_child_theme_enqueue_scripts() {
	wp_register_style( 'childstyle', get_stylesheet_directory_uri() . '/style.css'  );

  wp_enqueue_style( 'childstyle' );
  wp_enqueue_style( 'jquery-ui', '//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css' );
  wp_enqueue_style( 'switcherycss', get_stylesheet_directory_uri() . '/js/plugins/switchery/switchery.min.css' );
  wp_enqueue_style( 'intltelcss', get_stylesheet_directory_uri() . '/css/lib/intlTelInput.css' );
  // wp_enqueue_style( 'uploadifivecss', get_stylesheet_directory_uri() . '/css/lib/uploadifive.css' );
  wp_enqueue_style( 'fileuploadcss', get_stylesheet_directory_uri() . '/css/lib/jquery.fileupload.css' );
	wp_enqueue_style( 'jplist', get_stylesheet_directory_uri() . '/css/lib/jplist.core.min.css' );

}
add_action('wp_enqueue_scripts', 'mkdf_child_theme_enqueue_scripts', 11);

if(!function_exists('deploy_mikado_scripts_customized')) {
  /**
   * Function that includes all necessary scripts
   */
  function deploy_mikado_scripts_customized() {
    wp_dequeue_script('deploy_mikado_modules');
    wp_enqueue_script('deploy_mikado_modules', get_stylesheet_directory_uri().'/js/modules.js', array('jquery'), false, true);
    
    global $wp;
    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
    if (strpos($wp->request, 'compose') === false) 
      wp_enqueue_script('jquery-ui', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'), false, true);

    wp_enqueue_script('manic_others', get_stylesheet_directory_uri().'/js/others.js', array('jquery'), false, true);
    wp_enqueue_script('validation', get_stylesheet_directory_uri().'/js/plugins/jquery.validate.min.js', array('jquery'), false, true);
    wp_enqueue_script('handlebars', get_stylesheet_directory_uri().'/js/plugins/handlebars-v4.0.5.js', array('jquery'), false, true);
    wp_enqueue_script('switchery', get_stylesheet_directory_uri().'/js/plugins/switchery/switchery.min.js', array('jquery'), false, true);
    wp_enqueue_script('intltel', get_stylesheet_directory_uri().'/js/plugins/intlTelInput.js', array('jquery'), false, true);
    wp_enqueue_script('ui-widget', get_stylesheet_directory_uri().'/js/plugins/vendor/jquery.ui.widget.js', array('jquery'), false, true);
    wp_enqueue_script('iframe-transport', get_stylesheet_directory_uri().'/js/plugins/jquery.iframe-transport.js', array('jquery'), false, true);    
    wp_enqueue_script('fileupload', get_stylesheet_directory_uri().'/js/plugins/jquery.fileupload.js', array('jquery'), false, true);
    wp_enqueue_script('serializejson', get_stylesheet_directory_uri().'/js/plugins/jquery.serializejson.min.js', array('jquery'), false, true);


    wp_enqueue_script('jplist', get_stylesheet_directory_uri().'/js/plugins/jplist.core.min.js', array('jquery'), false, true);
    wp_enqueue_script('jplistcounter', get_stylesheet_directory_uri().'/js/plugins/jplist.counter-control.min.js', array('jquery'), false, true);
    wp_enqueue_script('jplistsort', get_stylesheet_directory_uri().'/js/plugins/jplist.sort-buttons.min.js', array('jquery'), false, true);    
  }
  add_action('wp_enqueue_scripts', 'deploy_mikado_scripts_customized');
}

// http://stackoverflow.com/questions/14177844/how-to-change-form-action-url-for-contact-form-7

/* ------- Line Break Shortcode --------*/
function line_break_shortcode() {
return '<br />';
}
add_shortcode( 'br', 'line_break_shortcode' );

add_action('after_setup_theme', 'remove_admin_bar');

function remove_admin_bar() {
  if (!current_user_can('administrator') && !is_admin()) {
    show_admin_bar(false);
  }
}
     
require 'signup.php';
require 'registration.php';
require 'custom-login-form.php';

// add_filter('bp_head','bp_guest_redirect',1);
// function bp_guest_redirect() {
//   global $bp;
//   if(!is_user_logged_in()) { // not logged in user
//     wp_redirect( get_option('siteurl') . '/sign-up' );
//   }
// }

function nonreg_visitor_redirect() {
  global $bp;
  if ( bp_is_activity_component() || bp_is_groups_component() || bp_is_group_forum() || bp_is_page( BP_MEMBERS_SLUG ) ) {
    if(!is_user_logged_in()) { //just a visitor and not logged in
      wp_redirect( get_option('siteurl') );
    }
  }
}
add_filter('get_header','nonreg_visitor_redirect',1);

add_action( 'xprofile_updated_profile', 'SaveEditsRedirect', 12 );
function SaveEditsRedirect() {
    global $bp;
    wp_redirect( $bp->loggedin_user->domain );
    exit;
}

function wpse125952_redirect_to_request( $redirect_to, $request, $user ) {
    // instead of using $redirect_to we're redirecting back to $request
    // echo $request; exit();

    $req_arr = explode('/', $request);

    $index = count($req_arr) - 2;

    if($req_arr[$index]=="offshore") {
      return get_site_url();    
    }else {
      return $redirect_to;
    }    
}
add_filter('login_redirect', 'wpse125952_redirect_to_request', 10, 3);

function wpse_44020_logout_redirect($logouturl, $redir) {
    // return $logouturl . '&amp;redirect_to='.get_permalink();
    return $logouturl . '&amp;redirect_to=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}
add_filter('logout_url', 'wpse_44020_logout_redirect', 10, 2);