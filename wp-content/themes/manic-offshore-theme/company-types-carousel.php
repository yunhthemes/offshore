<?php
function company_types_carousel_func($atts) {
    $page = get_page_by_title( 'Offshore companies' );
    extract( shortcode_atts( array(
        'parent' => $page->ID,
        'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $output = '<div class="mkdf-blog-list-holder mkdf-boxes mkdf-one-column" role="toolbar"><ul class="mkdf-blog-list">';
    $args = array(
        'post_parent' => $parent,
        'post_type' => $type,
        'posts_per_page' => $perpage,
        // 'sort_column'   => 'menu_order',
        'orderby'=> 'title', 
        'order' => 'ASC'
    );

    $text_length = '100';

    $solution_query = new  WP_Query( $args );
    while ( $solution_query->have_posts() ) : $solution_query->the_post();
        if ($text_length != '0')
            $excerpt = ($text_length > 0) ? substr(get_the_excerpt(), 0, intval($text_length)) : get_the_excerpt();
        else $excerpt = "";
        $output .= '<li class="mkdf-blog-list-item clearfix">
            <div class="mkdf-blog-list-item-inner">
                <div class="mkdf-item-image">
                    <a href="'.get_post_meta(get_the_ID(), 'link_to_page', true).'">'.get_the_post_thumbnail(get_the_ID(), "deploy-portfolio-square").'</a>
                </div>
                <div class="mkdf-item-text-holder mkdf-item-text-holder-2">
                    <h4 class="mkdf-item-title">
                        <a href="'.get_post_meta(get_the_ID(), 'link_to_page', true).'" >
                            '.esc_attr(get_the_title()).'
                        </a>
                    </h4>
                    <p class="mkdf-excerpt">'.esc_html($excerpt).'</p>
                </div>
            </div>  
        </li>';
    endwhile;
    wp_reset_query();
    $output .= '</ul></div>';
    echo $output;
}

// Register a new shortcode: [company_types_carousel]
add_shortcode( 'company_types_carousel', 'company_types_carousel_shortcode' );
 
// The callback function that will replace [book]
function company_types_carousel_shortcode($atts) {
    ob_start();
    company_types_carousel_func($atts);
    return ob_get_clean();
}