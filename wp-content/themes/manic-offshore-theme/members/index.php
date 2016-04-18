<div class="dashboard">
	<div data-mkdf-parallax-speed="1" class="vc_row wpb_row vc_row-fluid mkdf-section vc_custom_1454399108366 mkdf-content-aligment-left mkdf-grid-section" style="">
	    <div class="clearfix mkdf-section-inner">
	        <div class="mkdf-section-inner-margin clearfix">
	            <!-- <div class="wpb_column vc_column_container vc_col-sm-1">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div> -->
	            <div class="wpb_column vc_column_container vc_col-sm-12">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper">
	                        <div class="wpb_raw_code wpb_content_element wpb_raw_html">
	                            <div class="wpb_wrapper">
	                                <div id="">
	                                    <div class="mkdf-breadcrumbs-holder">
	                                        <div class="mkdf-breadcrumbs">
	                                            <div class="mkdf-breadcrumbs-inner"><a href="<?php echo home_url( '/' ); ?>">Home</a><span class="mkdf-delimiter"><span class="mkdf-icon-font-elegant arrow_right mkdf-delimiter-icon"></span></span><span class="mkdf-current">Client dashboard</span></div>
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
	        </div>
	    </div>
	</div>
	<div data-mkdf-parallax-speed="1" class="vc_row wpb_row vc_row-fluid mkdf-section vc_custom_1454057007283 mkdf-content-aligment-left mkdf-grid-section" style="">
	    <div class="clearfix mkdf-section-inner">
	        <div class="mkdf-section-inner-margin clearfix">
	        	<!-- <div class="wpb_column vc_column_container vc_col-sm-1">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div> -->
	            <div class="wpb_column vc_column_container vc_col-sm-12">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper">
	                        <div class="wpb_text_column wpb_content_element ">
	                            <div class="wpb_wrapper">
	                            	<div class="wpb_column vc_column_container vc_col-sm-12">
	                            		<ul class="tabs">
	                            			<li><a class="active" href="<?php echo home_url( '/client-dashboard/' ); ?>" class="active">My Dashboard</a></li>
	                            			<li><a href="<?php echo home_url( '/client-dashboard/' . bp_core_get_username( get_current_user_id() ) . '/messages/' ); ?>">My Messages</a></li>
	                            			<li><a href="<?php echo home_url( '/client-dashboard/' . bp_core_get_username( get_current_user_id() ) ); ?>">My Profile</a></li>
	                            		</ul>
	                            		<div id="tabs-content-seperator" class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
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
	        </div>
	    </div>
	</div>
</div>
<script id="user-companies-template" type="text/x-handlebars-template">	
    <div id="company-lists" class="box jplist">
    	<div class="box text-shadow">
    		<div class="demo-tbl">
		    {{#if companies}}
		    	<div class="header jplist-panel">
		    		<div class="header-row" data-control-type="sort-buttons-group"
                        data-control-name="header-sort-buttons"
                        data-control-action="sort"
                        data-mode="single"
                        data-datetime-format="{month}/{day}/{year}">
			            <div class="each-header">
			                <h6>
			                	<span class="header sortable-header">Company</span>
			                	<span class="sort-btns">
	                                <i class="fa fa-caret-up" data-path=".company" data-type="text" data-order="asc" title="Sort by Company Asc"></i>
	                                <i class="fa fa-caret-down" data-path=".company" data-type="text" data-order="desc" title="Sort by Company Desc"></i>
	                            </span>
			                </h6>
			            </div>
			            <div class="each-header">
			                <h6>
			                	<span class="header sortable-header">Jurisdiction</span>
			                	<span class="sort-btns">
	                                <i class="fa fa-caret-up" data-path=".jurisdiction" data-type="text" data-order="asc" title="Sort by Jurisdiction Asc"></i>
	                                <i class="fa fa-caret-down" data-path=".jurisdiction" data-type="text" data-order="desc" title="Sort by Jurisdiction Desc"></i>
	                            </span>
			                </h6>
			            </div>
			            <div class="each-header">
			                <h6>
			                	<span class="header sortable-header">Renewal date</span>
			                	<span class="sort-btns">
	                                <i class="fa fa-caret-up" data-path=".datetime" data-type="datetime" data-order="asc" title="Sort by Date Asc"></i>
	                                <i class="fa fa-caret-down" data-path=".datetime" data-type="datetime" data-order="desc" title="Sort by Date Desc"></i>
	                            </span>
			                </h6>
			            </div>          
			            <div class="each-header"></div>
			        </div>
		        </div>   

		        {{#companies}}                                       
	            <div class="content">
	            	<div class="content-row tbl-item">
		                <div class="each-content">
		                    <p class="company">{{ name }}</p>
		                </div>
		                <div class="each-content">
		                    <p class="jurisdiction">{{ companytypes.name }}</p>
		                </div>
		                <div class="each-content">
		                    <p class="datetime">{{ wpusers.0.pivot.renewal_date }}</p>    
		                </div>		                         
		                <div class="each-content">
		                	{{#ifCond status "==" "0"}}
								<a href="<?php echo get_permalink( get_page_by_path( 'Company formation order' ) ); ?>?savedcompany={{id}}" data-company-id="{{id}}"><button class="custom-submit-class">Continue registration</button></a>
							{{else}}
								{{#ifCond owner "==" "1"}}
								<a href="#" data-company-id="{{id}}" class="company-details"><button class="custom-submit-class">Company details</button></a>
								{{else}}
								<p>Not available</p>
								{{/ifCond}}
		                    {{/ifCond}}		                    
		                </div>                   
	                </div>     
	            </div>                               
		        {{/companies}}    	
			{{else}}
				<p>There is no compaines under this account.</p>
			{{/if}}
			</div>
		</div>
    </div>      
</script>
<script id="user-company-details-template" type="text/x-handlebars-template">
	{{#companydetails}}
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company name</h5>
			</div>
			<div class="value-container">
				<p class="value">{{companies.0.name}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Jurisdiction</h5>
			</div>
			<div class="value-container">
				<p class="value">{{companies.0.companytypes.name}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Next domiciliation renewal</h5>
			</div>
			<div class="value-container">
				<p class="value">{{renewal_date}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company type</h5>
			</div>
			<div class="value-container">
				<p class="value">{{companies.0.companytypes.name}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Incorporation date</h5>
			</div>
			<div class="value-container">
				<p class="value">{{companies.0.incorporation_date}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company registration number</h5>
			</div>
			<div class="value-container">
				<p class="value">{{reg_no}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Company tax number</h5>
			</div>
			<div class="value-container">
				<p class="value">{{tax_no}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">VAT registration number</h5>
			</div>
			<div class="value-container">
				<p class="value">{{vat_reg_no}}</p>
			</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Registered office</h5>
			</div>
			<div class="value-container">
	    		<p class="value">{{reg_office}}</p>
	    		<p class="value">{{reg_office}}</p>
	    		<p class="value">{{reg_office}}</p>
	    		<p class="value">{{reg_office}}</p>
	    	</div>
		</div>
		<div class="each-detail">
			<div class="lbl-container">
				<h5 class="label">Directors</h5>
			</div>
			<div class="value-container">
				{{#if companywpuser_directors.length}}
					{{#companywpuser_directors}}
			    		<p class="value">{{name}}</p>
		    		{{/companywpuser_directors}}
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
				{{#if companywpuser_secretaries.length}}
					{{#companywpuser_secretaries}}
			    		<p class="value">{{name}}</p>
		    		{{/companywpuser_secretaries}}		  
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
				{{#if companywpuser_shareholders.length}}
					{{#companywpuser_shareholders}}
					<div class="each-value">
		    			<p class="value">{{name}}</p><p class="amount">{{share_amount}}</p>
		    		</div>
		    		{{/companywpuser_shareholders}}
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

        	response.done(function(data, textStatus, jqXHR){                    
                if(jqXHR.status==200) {
                    
                    newdata["companies"] = data.companies;                        
                    createTemplateAndAppendHtml("#user-companies-template", newdata, "#user-companies");

                    // jplist plugin call
				    $('#company-lists').jplist({
				        itemsBox: '.demo-tbl',
						itemPath: '.tbl-item',
						panelPath: '.jplist-panel',
						// storage: 'localstorage',
						// storageName: 'jplist-table-sortable-cols'
				    });

			        //alternate up / down buttons on header click
				    $('.demo-tbl .header').on('click', function () {
				        $(this).next('.sort-btns').find('[data-path]:not(.jplist-selected):first').trigger('click');
				    });                    

                }
            });

            failedRequest(response); 


            $("#user-companies").on("click", ".company-details", function(e){
            	e.preventDefault();
            	var company_id = $(this).data('company-id');

            	$("#user-companies-container").hide();
            	$("#user-company-details-container").show();

            	var response = makeJsonpRequest("", "<?php echo SITEURL; ?>/b/api/usercompanydetails/"+company_id+"/<?php echo get_current_user_id(); ?>", "GET");	

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
