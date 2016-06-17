<?php 

function company_list() {
    $page = get_page_by_title( 'Offshore companies' );
    extract( shortcode_atts( array(
        'parent' => $page->ID,
        'type' => 'page',
        'perpage' => -1
    ), $atts ) );
    $output = '<div id="companylist"><div class="field-container"><div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div><ul class="solution-list">';
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
        $output .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
    endwhile;
    wp_reset_query();
    $output .= '</ul></div></div>';
    echo $output;
    /*echo '<script>
    (function($) {
        $(document).ready(function(){
        	//////////
            /// AJAX REQUEST
            //////////

            function makeRequest(Data, URL, Method) {

                var request = $.ajax({
                    url: URL,
                    type: Method,
                    data: Data,
                    success: function(response) {
                        // if success remove current item
                        // console.log(response);
                    },
                    error: function( error ){
                        // Log any error.
                        console.log("ERROR:", error);
                    }
                });

                return request;
            }

            function makeJsonpRequest(Data, URL, Method) {
                
                var request = $.ajax({
                    url: URL,
                    crossDomain: true,
                    type: Method,
                    data: Data,
                    dataType: "jsonp",
                    jsonpCallback: "jsonpCallback",
                    contentType: "application/json; charset=utf-8;",                    
                    success: function (data) {
                        // console.log(data);
                    },
                    error: function(xhr, status, error) {
                        // console.log(status + "; " + error);
                    }
                });

                return request;

            }

            function failedRequest(response){
                response.fail(function(jqXHR, textStatus, errorThrown){
                    console.log(errorThrown);
                });
            }

            function appendToHtml(data, selector) {
                $(selector).html(data);
            }

            function createTemplate(selector) {
                var source = $(selector).html(),
                    template = Handlebars.compile(source);

                console.log(source)

                return template;
            }

            function createTemplateAndAppendHtml(template_selector, newdata, append_to_selector) {
                var template = createTemplate(template_selector);
                var data = template(newdata);

                console.log(data);
                
                appendToHtml(data, append_to_selector);
            }

        	function getAllCompanyTypes(savedData) {

        		var newdata = [];

                if (typeof(savedData)==="undefined") savedData = null;

                // with cross domain
                var response = makeJsonpRequest("", "'.SITEURL.'/b/admin/jurisdiction", "GET");

                // without cross domain
                // var response = makeRequest("", "'.SITEURL.'/b/admin/jurisdiction", "GET");

                response.done(function(data, textStatus, jqXHR){                    
                    if(jqXHR.status==200) {

                    	newdata["companylists"] = data;
                        // createTemplateAndAppendHtml("#companylist-template", newdata, "#companylist")

                    }
                });

                failedRequest(response);
            }

        	function init() {
        		getAllCompanyTypes();
        	}

        	init();
        });
        
    }(jQuery));
    </script>
    <script id="companylist-template" type="text/x-handlebars-template">
        
            <div class="field-container">          
                <div class="vc_empty_space" style="height: 10px"><span class="vc_empty_space_inner"></span></div>
                <ul class="company-list">
	                {{#companylists}}                    	
    	          	<!-- <li>{{name}} <a href="#">[view more]</a></li>	        	         -->
	                {{/companylists}}
					
	                <li><a href="'.get_permalink(get_page_by_title('Cyprus company formation')).'">Cyprus company formation</a></li>
	                <li><a href="'.get_permalink(get_page_by_title('Irish company formation')).'">Irish company formation</a></li>
	                <li><a href="'.get_permalink(get_page_by_title('Malta company formation')).'">Malta company formation</a></li>
	                <li><a href="'.get_permalink(get_page_by_title('Nevis offshore company registration')).'">Nevis offshore company registration</a></li>
	                <li><a href="'.get_permalink(get_page_by_title('RAK offshore company formation')).'">RAK offshore company formation</a></li>
	                <li><a href="'.get_permalink(get_page_by_title('Seychelles company formation')).'">Seychelles company formation</a></li>
                </ul>          
            </div>            
        
    </script>
    <div id="companylist">
    	<!-- JS CONTENT GOES HERE -->


    </div>';*/
}

function compay_list_function() { 
    company_list();
}

// Register a new shortcode: [compay_list]
add_shortcode( 'compay_list', 'compay_list_shortcode' );
 
// The callback function that will replace [book]
function compay_list_shortcode() {
    ob_start();
    compay_list_function();
    return ob_get_clean();
}