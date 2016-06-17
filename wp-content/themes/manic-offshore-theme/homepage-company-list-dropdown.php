<?php 

function homepage_company_list_dropdown() {
    $page = get_page_by_title( 'Offshore companies' );
    extract( shortcode_atts( array(
        'parent' => $page->ID,
        'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $output = '<select class="custom-select" id="homepage-company-select"><option selected="" value="Please select ">See more</option>';
    $args = array(
        'post_parent' => $parent,
        'post_type' => $type,
        'posts_per_page' => $perpage,
        // 'sort_column'   => 'menu_order',
        'orderby'=> 'title', 
        'order' => 'ASC'
    );
    $i = 0;
    $solution_query = new  WP_Query( $args );
    while ( $solution_query->have_posts() ) : $solution_query->the_post();
        if($i>2) {    
            $output .= '<option data-link="'.get_permalink().'" value="'.get_the_title().'">'.get_the_title().'</option>';    
        }        
        $i++;
    endwhile;
    wp_reset_query();
    $output .= '</select><script type="text/javascript">
    jQuery(document).ready(function($) {
      $("#homepage-company-select").change(function(event) {
        var link = $("option:selected", this).attr("data-link");
        window.location.href = link;
      });
    });

    </script>';
    echo $output;
}

function homepage_company_list_dropdown_function() { 
    homepage_company_list_dropdown();
}

// Register a new shortcode: [homepage_company_list_dropdown]
add_shortcode( 'homepage_company_list_dropdown', 'homepage_company_list_dropdown_shortcode' );
 
// The callback function that will replace [book]
function homepage_company_list_dropdown_shortcode() {
    ob_start();
    homepage_company_list_dropdown_function();
    return ob_get_clean();
}