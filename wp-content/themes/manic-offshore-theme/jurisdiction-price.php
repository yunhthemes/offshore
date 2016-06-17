<?php
function jurisdiction_price_func($atts) {
    extract( shortcode_atts( array(
        'parent' => 46,
        'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $output = '<a href="'.get_permalink( get_page_by_title( 'Company formation order' ) ).'" target="_self" class="mkdf-btn mkdf-btn-large mkdf-btn-solid custon-deploy-button full-width">
        <span class="mkdf-btn-text">Incorporate now!</span>
        </a>';
        
    echo $output;
}

// Register a new shortcode: [jurisdiction_price]
add_shortcode( 'jurisdiction_price', 'jurisdiction_price_shortcode' );
 
// The callback function that will replace [book]
function jurisdiction_price_shortcode($atts) {
    ob_start();
    jurisdiction_price_func($atts);
    return ob_get_clean();
}