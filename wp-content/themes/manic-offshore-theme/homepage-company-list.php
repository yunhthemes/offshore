<?php 

function homepage_company_list() {
    $page = get_page_by_title( 'Offshore companies' );
    extract( shortcode_atts( array(
        'parent' => $page->ID,
        'type' => 'page',
        'perpage' => 3
    ), $atts ) );
    $output = '<ul style="color: #ffffff;">';
    $args = array(
        'post_parent' => $parent,
        'post_type' => $type,
        'posts_per_page' => $perpage,
        'sort_column'   => 'menu_order',
        'orderby'=> 'title', 
        'order' => 'ASC'
    );
    $solution_query = new  WP_Query( $args );
    while ( $solution_query->have_posts() ) : $solution_query->the_post();
        $output .= '<li><a style="color: #ffffff; text-decoration: underline;" href="'.get_permalink().'">'.get_the_title().'</a></li>';
    endwhile;
    wp_reset_query();
    $output .= '</ul>';
    echo $output;    
}

function homepage_company_list_function() { 
    homepage_company_list();
}

// Register a new shortcode: [homepage_company_list]
add_shortcode( 'homepage_company_list', 'homepage_company_list_shortcode' );
 
// The callback function that will replace [book]
function homepage_company_list_shortcode() {
    ob_start();
    homepage_company_list_function();
    return ob_get_clean();
}