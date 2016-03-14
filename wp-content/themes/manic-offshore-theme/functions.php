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

}
add_action('wp_enqueue_scripts', 'mkdf_child_theme_enqueue_scripts', 11);





if(!function_exists('deploy_mikado_scripts_customized')) {
  /**
   * Function that includes all necessary scripts
   */
  function deploy_mikado_scripts_customized() {
    wp_dequeue_script('deploy_mikado_modules');
    wp_enqueue_script('deploy_mikado_modules', get_stylesheet_directory_uri().'/js/modules.js', array('jquery'), false, true);

    wp_enqueue_script('manic_others', get_stylesheet_directory_uri().'/js/others.js', array('jquery'), false, true);
    wp_enqueue_script('validation', get_stylesheet_directory_uri().'/js/plugins/jquery.validate.min.js', array('jquery'), false, true);
    wp_enqueue_script('handlebars', get_stylesheet_directory_uri().'/js/plugins/handlebars-v4.0.5.js', array('jquery'), false, true);
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

// $api_url = 'https://api.instagram.com/v1/users/' . esc_html( $user_id ) . '/media/recent/';
// $response = wp_remote_get( add_query_arg( array(
//     'client_id' =&gt; esc_html( $client_id ),
//     'count'     =&gt; absint( $count )
// ), $api_url ) );

// // Is the API up?
// if ( ! 200 == wp_remote_retrieve_response_code( $response ) ) {
//     return false;
// }

