<div class="dashboard">
	<div data-mkdf-parallax-speed="1" class="vc_row wpb_row vc_row-fluid mkdf-section vc_custom_1454399108366 mkdf-content-aligment-left mkdf-grid-section" style="">
	    <div class="clearfix mkdf-section-inner">
	        <div class="mkdf-section-inner-margin clearfix">
	            <div class="wpb_column vc_column_container vc_col-sm-2">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-8">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper">
	                        <div class="wpb_raw_code wpb_content_element wpb_raw_html">
	                            <div class="wpb_wrapper">
	                                <div id="custom-breadcrumb">
	                                    <div class="mkdf-breadcrumbs-holder">
	                                        <div class="mkdf-breadcrumbs">
	                                            <!-- <div class="mkdf-breadcrumbs-inner"><a href="http://localhost:8888/offshore/">Home</a><span class="mkdf-delimiter"><span class="mkdf-icon-font-elegant arrow_right mkdf-delimiter-icon"></span></span><span class="mkdf-current">Registration</span></div> -->
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                        <div class="wpb_raw_code wpb_content_element wpb_raw_html">
	                            <div class="wpb_wrapper">
	                                <div id="custom-page-title">
	                                    <!-- <h1 style="color:#363636"><span>Registration</span></h1> -->
	                                </div> 
	                            </div>
	                        </div>
	                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                    </div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-2">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<div data-mkdf-parallax-speed="1" class="vc_row wpb_row vc_row-fluid mkdf-section vc_custom_1454057007283 mkdf-content-aligment-left mkdf-grid-section" style="">
	    <div class="clearfix mkdf-section-inner">
	        <div class="mkdf-section-inner-margin clearfix">
	        	<div class="wpb_column vc_column_container vc_col-sm-2">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-8">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper">
	                        <div class="wpb_text_column wpb_content_element ">
	                            <div class="wpb_wrapper">
	                            	<div class="wpb_column vc_column_container vc_col-sm-3">
	                            		<ul class="vertical-links">
	                            			<li><a href="<?php echo home_url( '/member-dashboard/' ); ?>" class="active">Dashboard</a></li>
	                            			<li><a href="<?php echo home_url( '/member-dashboard/' . bp_core_get_username( get_current_user_id() ) ); ?>">Profile</a></li>
	                            			<li><a href="<?php echo home_url( '/member-dashboard/' . bp_core_get_username( get_current_user_id() ) . '/messages/' ); ?>">Messages</a></li>
	                            		</ul>
	                            	</div>
	                            	<div class="wpb_column vc_column_container vc_col-sm-9">
	                            		<p>List of company associated with this account.</p>
	                            		<div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
		                                <div id="user-companies-container">
			                                <div id="user-companies">
			                                	<!-- JS CONTENT GOES HERE -->
			                                </div>
		                                </div>
		                                <div id="user-company-details-container">
		                                	<a href="#" class="back-to-dashboard"><i class="fa fa-chevron-left"></i> Back to dashboard</a>
			                                <div id="user-company-details">
			                                	<!-- JS CONTENT GOES HERE -->		                                	
			                                </div>
		                                </div>
	                                </div>                          	                                
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-2">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
</div>
<script id="user-companies-template" type="text/x-handlebars-template">
    <div class="company-lists">
    {{#if companies}}
    	{{#companies}}
	    	{{#if name}}
		    	<div class="each-company">
		    		<h2>{{name}}</h2>			    		
		    		<p>Service renewal date: N/A</p>
		    		<a href="#" data-company-id="{{id}}" class="company-details"><button class="custom-submit-class">Company details</button></a>
		    	</div>
		    	<div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	    	{{/if}}
    	{{/companies}}    	
	{{else}}
		<p>There is no compaines under this account.</p>
	{{/if}}
    </div>      
</script>
<script id="user-company-details-template" type="text/x-handlebars-template">
	{{#companydetails}}
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company name</h5>
			</div>
			<div class="value-container">
				<p class="value">{{name}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Jurisdiction</h5>
			</div>
			<div class="value-container">
				<p class="value">{{companytypes.name}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Next domiciliation renewal</h5>
			</div>
			<div class="value-container">
				<p class="value">N/A</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company type</h5>
			</div>
			<div class="value-container">
				<p class="value">{{companytypes.name}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Incorporation date</h5>
			</div>
			<div class="value-container">
				<p class="value">{{incorporation_date}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company registration number</h5>
			</div>
			<div class="value-container">
				<p class="value">N/A</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company tax number</h5>
			</div>
			<div class="value-container">
				<p class="value">N/A</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">VAT registration number</h5>
			</div>
			<div class="value-container">
				<p class="value">N/A</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Registered office</h5>
			</div>
			<div class="value-container">
	    		<p class="value">N/A</p>
	    		<p class="value">N/A</p>
	    		<p class="value">N/A</p>
	    		<p class="value">N/A</p>
	    	</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Directors</h5>
			</div>
			<div class="value-container">
				{{#if companydirectors.length}}
					{{#companydirectors}}
			    		<p class="value">{{name}}</p>
		    		{{/companydirectors}}
		    	{{else}}                              		
		    		<p>Provided by offshore</p>
		    	{{/if}}
			</div>
		</div>
		<div class="each-detail">
	    	<div class="lbl-container">
	    		<h5 class="label">Company secretary</h5>
	    	</div>
			<div class="value-container">
				{{#if companysecretaries.length}}
					{{#companysecretaries}}
			    		<p class="value">{{name}}</p>
		    		{{/companysecretaries}}		  
		    	{{else}}                              		
		    		<p>Provided by offshore</p>
		    	{{/if}}
			</div>
		</div>
		<div class="each-detail">
	    	<div class="lbl-container">
	    		<h5 class="label">Shareholders</h5>
	    	</div>
			<div class="value-container">
				{{#if companyshareholders.length}}
					{{#companyshareholders}}
					<div class="each-value">
		    			<p class="value">{{name}}</p><p class="amount">{{share_amount}}</p>
		    		</div>
		    		{{/companyshareholders}}
		    	{{else}}
					<p>N/A</p>
		    	{{/if}}
			</div>
		</div>
		<div class="each-detail">
	    	<div class="lbl-container">
	    		<h5 class="label">Date of last accounts</h5>
	    	</div>
	    	<div class="value-container">
	    		<p class="value">N/A</p>
	    	</div>
		</div>
		<div class="each-detail">
	    	<div class="lbl-container">
	    		<h5 class="label">Date of last AGM</h5>
	    	</div>
	    	<div class="value-container">
	    		<p class="value">N/A</p>
	    	</div>
		</div>
	{{/companydetails}} 
</script>
<script>
(function($) {
    $(document).ready(function() {

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
                    console.log(response);
                },
                error: function( error ){
                    // Log any error.
                    console.log("ERROR:", error);
                }
            });

            return request;
        };

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

        ///////////
        /// DOM MANIPULATION
        ///////////

        function createTemplate(selector) {
            var source = $(selector).html(),
                template = Handlebars.compile(source);

            return template;
        }

        function appendToHtml(data, selector) {
            $(selector).html(data);
        }

        function createTemplateAndAppendHtml(template_selector, newdata, append_to_selector) {
            var template = createTemplate(template_selector);
            var data = template(newdata);
            
            appendToHtml(data, append_to_selector);
        }

        function init() {
        	var newdata = [];
        	var response = makeJsonpRequest("", "<?php echo SITEURL; ?>/b/api/usercompanies/"+<?php echo get_current_user_id(); ?>, "GET");	

        	response.done(function(data, textStatus, jqXHR){                    
                if(jqXHR.status==200) {
                    
                    newdata["companies"] = data.companies;                        
                    createTemplateAndAppendHtml("#user-companies-template", newdata, "#user-companies");                    

                }
            });

            failedRequest(response); 


            $("#user-companies").on("click", ".company-details", function(e){
            	e.preventDefault();
            	var company_id = $(this).data('company-id');

            	$("#user-companies-container").hide();
            	$("#user-company-details-container").show();

            	var response = makeJsonpRequest("", "<?php echo SITEURL; ?>/b/api/usercompanydetails/"+company_id, "GET");	

	        	response.done(function(data, textStatus, jqXHR){                    
	                if(jqXHR.status==200) {
	                    
	                    newdata["companydetails"] = data.companydetails;                        
                		createTemplateAndAppendHtml("#user-company-details-template", newdata, "#user-company-details");                    

	                }
	            });

	            failedRequest(response); 

            	

            });

            $(".back-to-dashboard").on("click", function(e){
            	e.preventDefault();

            	$("#user-companies-container").show();
            	$("#user-company-details-container").hide();
            });
        }

        init();

    });

}(jQuery));
</script>
