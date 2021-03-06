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
    // wp_enqueue_script('deploy_mikado_modules', get_stylesheet_directory_uri().'/js/modules.js', array('jquery'), false, true);
    
    global $wp;
    $current_url = add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
    // if (strpos($wp->request, 'compose') === false) 
    //   wp_enqueue_script('jquery-ui', '//code.jquery.com/ui/1.11.4/jquery-ui.js', array('jquery'), false, true);

    wp_enqueue_script('manic_thirdparty', get_stylesheet_directory_uri().'/js/manic-third-party.js', array('jquery'), false, true);          
    wp_enqueue_script('manic_others', get_stylesheet_directory_uri().'/js/others.js', array('jquery'), false, true);

  }
  add_action('wp_enqueue_scripts', 'deploy_mikado_scripts_customized');
}

// Make JavaScript Asynchronous in Wordpress
// add_filter( 'script_loader_tag', function ( $tag, $handle ) {    
//     if( is_admin() ) {
//         return $tag;
//     }
//     return str_replace( ' src', ' async src', $tag );
// }, 10, 2 );

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
     
require 'registration.php';
require 'custom-login-form.php';
require 'company-list.php';
require 'solution-list.php';
require 'homepage-company-list.php';
require 'homepage-company-list-dropdown.php';
require 'incorporate-now-btn.php';
require 'jurisdiction-price.php';
require 'company-price.php';
require 'contact-us-btn.php';
require 'solution-list-carousel.php';
require 'offshore-company-choices.php';
require 'company-types-carousel.php';

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

    $last_index = count($req_arr) - 2;
    $second_last_index = count($req_arr) - 3;

    // print_r($req_arr[$last_index]);
    // print_r($req_arr[$second_last_index]);

    // print_r( get_page_by_path( $req_arr[$last_index] ) );

    $url = home_url( $req_arr[$second_last_index].'/'.$req_arr[$last_index] );

    if($req_arr[$last_index]=="offshore") {
      return get_site_url();    
    }else {
      return $url;
    }    
}
add_filter('login_redirect', 'wpse125952_redirect_to_request', 10, 3);

function wpse_44020_logout_redirect($logouturl, $redir) {
    // return $logouturl . '&amp;redirect_to='.get_permalink();
    // return $logouturl . '&amp;redirect_to=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    return $logouturl . '&amp;redirect_to=' . home_url();
}
add_filter('logout_url', 'wpse_44020_logout_redirect', 10, 2);


///// inmail function to send when user bought shelf

function bp_send_message(){
  
  global $bp;

  //check_admin_referer(message_check”); // adjust if needed

  $sender_id = 1; // moderator id ?
  $recip_ids = $_POST['receipient_ids']; // denied image user id ?

  if ( $thread_id = messages_new_message( array('sender_id' => $sender_id, 'subject' => 'Saved Company Status', 'content' => 'Sorry your saved company was bought by another user.', 'recipients' => $recip_ids ) ) ) {
  
    echo 'Saved company status message was sent.';

    // bp_core_add_message( __( 'Saved company status message was sent.', 'buddypress' ) );
    //bp_core_redirect( $bp->displayed_user->domain ); // adjust as needed

  } else {    
    echo 'There was an error sending that private message.';
    // bp_core_add_message( __( 'There was an error sending that private message.', 'buddypress' ), 'error' );
  }  
  
  die();

}
add_action('wp_ajax_bp_send_message', 'bp_send_message');
add_action('wp_ajax_nopriv_bp_send_message', 'bp_send_message'); // not really needed

remove_filter( 'the_content', 'wpautop' );
remove_filter( 'the_excerpt', 'wpautop' );

function mark_notification_as_read($user_id, $key, $user) {
  global $bp;

  $notice = BP_Messages_Notice::get_active();
  $notices[] = $notice->id;
  bp_update_user_meta( $user_id, 'closed_notices', $notices );
}

add_action('bp_core_activated_user', 'mark_notification_as_read', 10, 3);

function redirect_to_dashboard() {
  return home_url( '/client-dashboard/' );
}

add_filter('login_redirect', 'redirect_to_dashboard');

/*==================*/

function ajax_login(){

    // First check the nonce, if it fails the function will break
    check_ajax_referer( 'ajax-login-nonce', 'security' );

    // Nonce is checked, get the POST data and sign user on
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
    $info['remember'] = false;

    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        $error_string = $user_signon->get_error_message();
        if (strpos($error_string, 'locked') !== false) {
          $error_msg = "Your account is banned.";
        }else {
          $error_msg = "Wrong username or password.";
        }
        echo json_encode(array('loggedin'=>false, 'message'=>__($error_msg)));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...')));
    }

    die();
}

function ajax_login_init(){

    wp_register_script('ajax-login-script', get_stylesheet_directory_uri() . '/js/ajax-login-script.js', array('jquery') );
    wp_enqueue_script('ajax-login-script', false, array(), false, true);
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => get_permalink( get_page_by_title( 'Client services dashboard' ) ),
        'loadingmessage' => __('Logging in, please wait...')
    ));

    // Enable the user with no privileges to run ajax_login() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}

function ajax_logout(){
    check_ajax_referer( 'ajax-logout-nonce', 'logoutsecurity' );
    // kill session
    wp_clear_auth_cookie();
    wp_logout();

    echo json_encode(array('loggedout'=>false, 'message'=>__('Logged out.')));
    die();
}

function ajax_logout_init(){
    add_action( 'wp_ajax_ajaxlogout', 'ajax_logout' );
}

function lost_password(){
  check_ajax_referer( 'ajax-lostpassword-nonce', 'security' );
  if(filter_var($_POST["username_email"], FILTER_VALIDATE_EMAIL)) {
      $input_email = $_POST["username_email"];
      $user_info = get_user_by( "email", $input_email );      
  }
  else {
      $input_username = $_POST["username_email"];
      $user_info = get_user_by( "login", $input_username );
  }

  if($user_info) {
    $email = $user_info->user_email;  
    $admin_email = get_option("admin_email");

    $headers = array(
      "Content-Type: text/html; charset=UTF-8",
      "From: OCS Reception <no-reply@offshorecompanysolutions.com>"
    );
    
    wp_mail($admin_email, "Forgotten password notification", "<p>User ".$user_info->display_name." [".$user_info->user_nicename."] has submitted a forgotten password notification.</p>", $headers);

    echo json_encode(array('messagesent'=>true, 'message'=>__('Message has been sent.')));

  }else {
    echo json_encode(array('messagesent'=>false, 'message'=>__('Wrong username or email.')));
  }
  die();

}

function lost_password_init(){
  add_action('wp_ajax_nopriv_lostpassword', 'lost_password');
}

// Execute the action only if the user isn't logged in
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
    add_action('init', 'lost_password_init');
}
if (is_user_logged_in()) {
    add_action('init', 'ajax_logout_init');
}