<?php
function offshore_company_choices_func($atts) {
extract( shortcode_atts( array(
'parent' => 46,
'type' => 'page',
'perpage' => -1
), $atts ) );
$output = '<div id="homepage-core-services-01" class="vc_row wpb_row vc_inner vc_row-fluid mkdf-section mkdf-blog-carousel-boxes vc_custom_1455251930766 mkdf-content-aligment-left" style=""><div class="mkdf-full-section-inner"><div class="wpb_column vc_column_container vc_col-sm-3"><div class="vc_column-inner "><div class="wpb_wrapper">
    <div class="wpb_text_column wpb_content_element ">
        <div class="wpb_wrapper">
            <div class="mkdf-blog-box-whole-content">
                <div class="mkdf-blog-boxes-item-holder-outer">
                    <div class="mkdf-blog-boxes-image-holder"><a href="'.get_permalink( get_page_by_title( 'Offshore companies' ) ).'"><img class="attachment-deploy-portfolio-landscape size-deploy-portfolio-landscape wp-post-image" src="http://clients.manic.com.sg/offshore/wp-content/uploads/2016/01/blog-masonry-image-3-800x514.jpg" alt="blog-masonry-image-3" width="800" height="514"></a></div>
                    <div class="mkdf-blog-boxes-content-holder">
                        <div class="mkdf-boxes-content-holder">
                            <h4 class="mkdf-boxes-item-title"><a href="'.get_permalink( get_page_by_title( 'Offshore companies' ) ).'">Mauritius Class 1 company</a></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-3"><div class="vc_column-inner "><div class="wpb_wrapper">
<div class="wpb_text_column wpb_content_element ">
    <div class="wpb_wrapper">
        <div class="mkdf-blog-box-whole-content">
            <div class="mkdf-blog-boxes-item-holder-outer">
                <div class="mkdf-blog-boxes-image-holder"><a href="'.get_permalink( get_page_by_title( 'Core services: Asset protection' ) ).'"><img class="attachment-deploy-portfolio-landscape size-deploy-portfolio-landscape wp-post-image" src="http://clients.manic.com.sg/offshore/wp-content/uploads/2016/01/blog-masonry-image-5-800x514.jpg" alt="blog-masonry-image-3" width="800" height="514"></a></div>
                <div class="mkdf-blog-boxes-content-holder">
                    <div class="mkdf-boxes-content-holder">
                        <h4 class="mkdf-boxes-item-title"><a href="'.get_permalink( get_page_by_title( 'Core services: Asset protection' ) ).'">Cyprus branch of a UK company</a></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-3"><div class="vc_column-inner "><div class="wpb_wrapper">
<div class="wpb_text_column wpb_content_element ">
<div class="wpb_wrapper">
    <div class="mkdf-blog-box-whole-content">
        <div class="mkdf-blog-boxes-item-holder-outer">
            <div class="mkdf-blog-boxes-image-holder"><a href="'.get_permalink( get_page_by_title( 'Core services: Offshore trusts' ) ).'"><img class="attachment-deploy-portfolio-landscape size-deploy-portfolio-landscape wp-post-image" src="http://clients.manic.com.sg/offshore/wp-content/uploads/2016/01/blog-masonry-image-6-800x514.jpg" alt="blog-masonry-image-3" width="800" height="514"></a></div>
            <div class="mkdf-blog-boxes-content-holder">
                <div class="mkdf-boxes-content-holder">
                    <h4 class="mkdf-boxes-item-title"><a href="'.get_permalink( get_page_by_title( 'Core services: Offshore trusts' ) ).'">Mauritius Class 1 company</a></h4>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div></div></div><div class="wpb_column vc_column_container vc_col-sm-3"><div class="vc_column-inner "><div class="wpb_wrapper">
<div class="wpb_text_column wpb_content_element ">
<div class="wpb_wrapper">
<div class="mkdf-blog-box-whole-content">
    <div class="mkdf-blog-boxes-item-holder-outer">
        <div class="mkdf-blog-boxes-image-holder"><a href="'.get_permalink( get_page_by_title( 'Core services: Merchant accounts' ) ).'"><img class="attachment-deploy-portfolio-landscape size-deploy-portfolio-landscape wp-post-image" src="http://clients.manic.com.sg/offshore/wp-content/uploads/2016/01/blog-masonry-image-7-800x514.jpg" alt="blog-masonry-image-3" width="800" height="514"></a></div>
        <div class="mkdf-blog-boxes-content-holder">
            <div class="mkdf-boxes-content-holder">
                <h4 class="mkdf-boxes-item-title"><a href="'.get_permalink( get_page_by_title( 'Core services: Merchant accounts' ) ).'">Mauritius Class 2 company</a></h4>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div></div></div></div></div>';

echo $output;
}
// Register a new shortcode: [offshore_company_choices]
add_shortcode( 'offshore_company_choices', 'offshore_company_choices_shortcode' );

// The callback function that will replace [book]
function offshore_company_choices_shortcode($atts) {
ob_start();
offshore_company_choices_func($atts);
return ob_get_clean();
}