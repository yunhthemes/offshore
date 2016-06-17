<?php
function contact_us_btn_func($atts) {
    extract( shortcode_atts( array(
        'parent' => 46,
        'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $output = '<a href="'.get_permalink( get_page_by_title( 'Contact us' ) ).'" target="_self" class="mkdf-btn mkdf-btn-large mkdf-btn-solid custon-deploy-button full-width">
        <span class="mkdf-btn-text">Contact us</span>
		</a>';
        
    echo $output;
}

// Register a new shortcode: [contact_us_btn]
add_shortcode( 'contact_us_btn', 'contact_us_btn_shortcode' );
 
// The callback function that will replace [book]
function contact_us_btn_shortcode($atts) {
    ob_start();
    contact_us_btn_func($atts);
    return ob_get_clean();
}