<div id="copy-banner" class="mkdf-title mkdf-standard-type mkdf-has-background mkdf-content-left-alignment mkdf-animation-no mkdf-title-image-not-responsive" style="color:#000000;height:330px;;background-image:url(http://clients.manic.com.sg/offshore/wp-content/uploads/2016/01/image-01.jpg)" data-height="330" data-background-width="&quot;1920&quot;">
    <div class="mkdf-title-image"><img src="http://clients.manic.com.sg/offshore/wp-content/uploads/2016/01/image-01.jpg" alt="&nbsp;"> </div>
    <!-- <div class="mkdf-title-holder" style="height:330px;">
        <div class="mkdf-container clearfix">
            <div class="mkdf-container-inner">
                <div class="mkdf-title-subtitle-holder" style="">
                    <div class="mkdf-title-subtitle-holder-inner">
                        <h1 style="color:#000000"><span>Client services dashboard</span></h1>

                        <div class="mkdf-breadcrumbs-holder"> <div class="mkdf-breadcrumbs"><div class="mkdf-breadcrumbs-inner"><a href="http://clients.manic.com.sg/offshore/">Home</a><span class="mkdf-delimiter"><span class="mkdf-icon-font-elegant arrow_right mkdf-delimiter-icon"></span></span><span class="mkdf-current">Members</span></div></div></div>
                    </div>
				</div>
			</div>
		</div>
	</div> -->
</div>
<div id="buddypress" class="dashboard">
	<div data-mkdf-parallax-speed="1" class="vc_row wpb_row vc_row-fluid mkdf-section vc_custom_1454399108366 mkdf-content-aligment-left mkdf-grid-section" style="">
	    <div class="clearfix mkdf-full-section-inner">
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
	                                <div id="custom-breadcrumb">
	                                    <div class="mkdf-breadcrumbs-holder">
	                                        <div class="mkdf-breadcrumbs">
	                                            <div class="mkdf-breadcrumbs-inner">
	                                            <a href="<?php echo home_url(); ?>">Home</a>
	                                            <span class="mkdf-delimiter">
	                                            	<span class="mkdf-icon-font-elegant arrow_right mkdf-delimiter-icon"></span>
	                                            </span>
	                                            <?php if(bp_is_user_profile()): ?>
	                                            	<span class="mkdf-current">Client dashboard</span>
	                                        	<?php elseif(bp_is_user_messages()): ?>
	                                        		<span class="mkdf-current">Client dashboard</span>
	                                        	<?php else: ?>
	                                        		<span class="mkdf-current">Client dashboard</span>
	                                        	<?php endif; ?>
	                                            </div>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                        <div class="wpb_raw_code wpb_content_element wpb_raw_html">
	                            <div class="wpb_wrapper">
	                                <div id="custom-page-title">
	                                    <h1 style="color:#363636"><span>Client services dashboard</span></h1>
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
	    <div class="clearfix mkdf-full-section-inner">
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
	                            			<li><a href="<?php echo home_url( '/client-dashboard/' ); ?>">My Dashboard</a></li>
	                            			<li><a href="<?php echo home_url( '/client-dashboard/' . bp_core_get_username( get_current_user_id() ) . '/messages/' ); ?>" <?php if(bp_is_user_messages()): ?>class="active"<?php endif; ?>>My Messages</a></li>
	                            			<li><a href="<?php echo home_url( '/client-dashboard/' . bp_core_get_username( get_current_user_id() ) ); ?>" <?php if(bp_is_user_profile()): ?>class="active"<?php endif; ?>>My Profile</a></li>	                            			
	                            		</ul>
	                            		<div id="tabs-content-seperator" class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                            		<?php
										/**
										 * Fires before the display of member home content.
										 *
										 * @since 1.2.0
										 */
										do_action( 'bp_before_member_home_content' ); ?>

										<!-- <div id="item-header" role="complementary"> -->

											<?php
											/**
											 * If the cover image feature is enabled, use a specific header
											 */
											// if ( bp_displayed_user_use_cover_image_header() ) :
											// 	bp_get_template_part( 'members/single/cover-image-header' );
											// else :
											// 	bp_get_template_part( 'members/single/member-header' );
											// endif;
											?>

										<!-- </div> --><!-- #item-header -->

										<div id="item-nav">
											<div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
												<ul>

													<?php //bp_get_displayed_user_nav(); ?>

													<?php

													/**
													 * Fires after the display of member options navigation.
													 *
													 * @since 1.2.4
													 */
													do_action( 'bp_member_options_nav' ); ?>

												</ul>
											</div>
										</div><!-- #item-nav -->

										<div id="item-body">

											<?php

											/**
											 * Fires before the display of member body content.
											 *
											 * @since 1.2.0
											 */
											do_action( 'bp_before_member_body' );

											if ( bp_is_user_activity() || !bp_current_component() ) :
												bp_get_template_part( 'members/single/activity' );

											elseif ( bp_is_user_blogs() ) :
												bp_get_template_part( 'members/single/blogs'    );

											elseif ( bp_is_user_friends() ) :
												bp_get_template_part( 'members/single/friends'  );

											elseif ( bp_is_user_groups() ) :
												bp_get_template_part( 'members/single/groups'   );

											elseif ( bp_is_user_messages() ) :
												bp_get_template_part( 'members/single/messages' );

											elseif ( bp_is_user_profile() ) :
												bp_get_template_part( 'members/single/profile'  );

											elseif ( bp_is_user_forums() ) :
												bp_get_template_part( 'members/single/forums'   );

											elseif ( bp_is_user_notifications() ) :
												bp_get_template_part( 'members/single/notifications' );

											elseif ( bp_is_user_settings() ) :
												bp_get_template_part( 'members/single/settings' );

											// If nothing sticks, load a generic template
											else :
												bp_get_template_part( 'members/single/plugins'  );

											endif;

											/**
											 * Fires after the display of member body content.
											 *
											 * @since 1.2.0
											 */
											do_action( 'bp_after_member_body' ); ?>

										</div><!-- #item-body -->

										<?php

										/**
										 * Fires after the display of member home content.
										 *
										 * @since 1.2.0
										 */
										do_action( 'bp_after_member_home_content' ); ?>
	                                </div>                          	                                
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>	            
	        </div>
	    </div>
	</div>
</div><!-- #buddypress -->
