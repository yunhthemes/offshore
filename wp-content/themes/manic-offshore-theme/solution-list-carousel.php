<?php
function solution_list_carousel_func($atts) {
    extract( shortcode_atts( array(
        'type' => 'post',
        'perpage' => -1
    ), $atts ) );
    $output = '<div class="mkdf-blog-list-holder mkdf-boxes mkdf-one-column" role="toolbar"><ul class="mkdf-blog-list">';
    $args = array(
        'post_type' => $type,
        'posts_per_page' => $perpage,
        'orderby'   => 'menu_order',
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
                <div class="mkdf-item-text-holder">
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

// Register a new shortcode: [solution_list_carousel]
add_shortcode( 'solution_list_carousel', 'solution_list_carousel_shortcode' );
 
// The callback function that will replace [book]
function solution_list_carousel_shortcode($atts) {
    ob_start();
    solution_list_carousel_func($atts);
    return ob_get_clean();
}