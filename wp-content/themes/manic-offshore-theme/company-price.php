<?php 

function company_price($attrs) {    

    global $post;
    global $wpdb;

    $current_post_title = $post->post_title;
        
    $current_user = wp_get_current_user();
    $user_id = get_current_user_id();

    $field_id = $wpdb->get_var( "SELECT parent_id FROM wp_bp_xprofile_fields WHERE name = 'US dollars (US$)'");
    $currency = $wpdb->get_var( "SELECT value FROM wp_bp_xprofile_data WHERE user_id = $user_id AND field_id = $field_id" );


    echo '<script>
    (function($) {
        $(document).ready(function(){

            var currency = "'.$currency.'";

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

            function handleBarExt() {
                // add operator support for handlebar
                Handlebars.registerHelper("ifCond", function (v1, operator, v2, options) {

                    switch (operator) {
                        case "==":
                            return (v1 == v2) ? options.fn(this) : options.inverse(this);
                        case "===":
                            return (v1 === v2) ? options.fn(this) : options.inverse(this);
                        case "<":
                            return (v1 < v2) ? options.fn(this) : options.inverse(this);
                        case "<=":
                            return (v1 <= v2) ? options.fn(this) : options.inverse(this);
                        case ">":
                            return (v1 > v2) ? options.fn(this) : options.inverse(this);
                        case ">=":
                            return (v1 >= v2) ? options.fn(this) : options.inverse(this);
                        case "&&":
                            return (v1 && v2) ? options.fn(this) : options.inverse(this);
                        case "||":
                            return (v1 || v2) ? options.fn(this) : options.inverse(this);
                        default:
                            return options.inverse(this);
                    }
                });

                Handlebars.registerHelper("counter", function (index){
                    return index + 1;
                });

                Handlebars.registerHelper("formatCurrency", function(value) {
                    return value.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
                });
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

                return template;
            }

            function createTemplateAndAppendHtml(template_selector, newdata, append_to_selector) {
                var template = createTemplate(template_selector);
                var data = template(newdata);
                
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

                        var current_company_name = "'.$current_post_title.'";

                        $.each(data, function(key, value){
                            value_arr = $.trim(value.name).split(" ");
                            current_company_name_arr = $.trim(current_company_name).split(" ");

                            if(current_company_name_arr[0]==value_arr[0]) {
                                data.current_company_name = value.name;       
                            }
                        });

                        

                        if(currency=="") currency = "US dollars (US$)";
                        data.currency = currency;   
                        data.page_title = "'.$current_post_title.'";
                        newdata["companylists"] = data;                        
                        createTemplateAndAppendHtml("#companylist-template", newdata, "#companylist");                                      
                    }
                });

                failedRequest(response);
            }

            function init() {
                handleBarExt();
                getAllCompanyTypes();
            }

            init();
        });
        
    }(jQuery));
    </script>
    <script id="companylist-template" type="text/x-handlebars-template">
        {{#companylists}}  
            {{#ifCond name "==" ../companylists.current_company_name }}
                {{#ifCond ../companylists.currency "==" "Euro (€)" }}                      
                    <span class="price">{{price_label}}: €{{formatCurrency price_eu}}</span>
                {{else}}
                    <span class="price">{{price_label}}: US${{formatCurrency price}}</span>                
                {{/ifCond}}
            {{/ifCond}}    
        {{/companylists}}
    </script>
    <div class="wpb_text_column wpb_content_element ">
        <div class="wpb_wrapper">
            <h2>Incorporation cost</h2>
        </div>
    </div>
    <div id="companylist">
        <!-- JS CONTENT GOES HERE -->


    </div>';
}

function company_price_function($attrs) { 
    company_price($attrs);
}

// Register a new shortcode: [company_price]
add_shortcode( 'company_price', 'company_price_shortcode' );
 
// The callback function that will replace [book]
function company_price_shortcode($attrs) {
    ob_start();
    company_price_function($attrs);
    return ob_get_clean();
}