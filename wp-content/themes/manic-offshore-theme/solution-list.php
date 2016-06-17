<?php
function solution_list_func($atts) {
    extract( shortcode_atts( array(
        'parent' => 46,
        'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $output = '<ul class="solution-list">';
    $args = array(
        'post_parent' => $parent,
        'post_type' => $type,
        'posts_per_page' => $perpage,
        'sort_column'   => 'menu_order'
    );
    $solution_query = new  WP_Query( $args );
    while ( $solution_query->have_posts() ) : $solution_query->the_post();
        $output .= '<li><a class="solution-link" href="'.get_permalink().'">'.get_the_title().'</a></li><!--  ends here -->';
    endwhile;
    wp_reset_query();
    $output .= '</ul>';
    echo $output;
}

// Register a new shortcode: [solution_list]
add_shortcode( 'solution_list', 'solution_list_shortcode' );
 
// The callback function that will replace [book]
function solution_list_shortcode($atts) {
    ob_start();
    solution_list_func($atts);
    return ob_get_clean();
}