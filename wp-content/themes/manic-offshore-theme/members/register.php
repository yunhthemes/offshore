<?php
/**
 * BuddyPress - Members Register
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */
global $wp_query;
$page = get_page_by_title( 'Sign up' );
?>
<div id="signup-page-wrapper">
	<div data-mkdf-parallax-speed="1" class="vc_row wpb_row vc_row-fluid mkdf-section vc_custom_1454399108366 mkdf-content-aligment-left mkdf-grid-section" style="">
	    <div class="clearfix mkdf-section-inner">
	        <div class="mkdf-section-inner-margin clearfix">
	            <div class="wpb_column vc_column_container vc_col-sm-3">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-6">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper">
	                    	<?php if ( 'completed-confirmation' !== bp_get_current_signup_step() ) : ?>
	                        <div class="wpb_raw_code wpb_content_element wpb_raw_html">
	                            <div class="wpb_wrapper">
	                                <div id="custom-breadcrumb"></div>
	                            </div>
	                        </div>
	                        <?php endif; ?>
	                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                        <div class="wpb_raw_code wpb_content_element wpb_raw_html">
	                            <div class="wpb_wrapper">
	                                <div id="custom-page-title"></div>
	                            </div>
	                        </div>
	                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                        <?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

								<?php

								/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
								do_action( 'template_notices' ); ?>
								<?php

								/**
								 * Fires before the display of the registration confirmed messages.
								 *
								 * @since 1.5.0
								 */
								do_action( 'bp_before_registration_confirmed' ); ?>

								<?php if ( bp_registration_needs_activation() ) : ?>
									<p><?php _e( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'buddypress' ); ?></p>									
								<?php else : ?>
									<p><?php _e( 'You have successfully created your account! Please log in using the username and password you have just created.', 'buddypress' ); ?></p>
								<?php endif; ?>

								<div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
								<div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
								<div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>

								<?php

								/**
								 * Fires after the display of the registration confirmed messages.
								 *
								 * @since 1.5.0
								 */
								do_action( 'bp_after_registration_confirmed' ); ?>

							<?php else: ?>
							
	                        <div class="wpb_text_column wpb_content_element ">
	                            <div class="wpb_wrapper">
	                                <!-- <p>Please complete the details below in order to register with Offshore Company Solutions. All information provided will be kept in strict confidence and will not be released to any third party.</p> -->
	                                <p><?php echo $page->post_content; ?></p>
	                            </div>
	                        </div>
	                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                        <div class="mkdf-custom-font-holder" style="font-family: Georgia;font-size: 16px;line-height: 20px;font-style: italic;font-weight: 400;letter-spacing: 0px;text-transform: Capitalize;text-align: left;color: #979797" data-font-size="16" data-line-height="20">
	                            * Required</div>
	                        <?php endif; // completed-confirmation signup step ?>
	                    </div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-3">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php if ( 'completed-confirmation' !== bp_get_current_signup_step() ) : ?>
	<?php
	/**
	 * Fires at the top of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_before_register_page' ); ?>
	<div id="signuppage-signup-form-row" data-mkdf-parallax-speed="1" class="vc_row wpb_row vc_row-fluid mkdf-section vc_custom_1454399114965 mkdf-content-aligment-left mkdf-grid-section" style="">
	    <div class="clearfix mkdf-section-inner">
	        <div class="mkdf-section-inner-margin clearfix">
	            <div class="wpb_column vc_column_container vc_col-sm-3">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-6">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper">
	                        <div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
	                        <script>
	                        (function($) {
	                            $(document).ready(function() {
	                                var $form = $("#signup_form");
	                                console.log($form);

	                                $form.validate({
	                                    rules: {
	                                        field_2: "required",
	                                        field_1: "required",
	                                        field_6: "required",
	                                        signup_email: {
	                                            required: true,
	                                            email: true
	                                        },
	                                        field_7: "required",	                                        
	                                        signup_username: "required",
	                                        signup_password: "required",
	                                        signup_password_confirm: {
	                                            equalTo: "#signup_password"
	                                        },
	                                        "field_51[]": "required",
	                                    },
						                messages: {
						                    "field_2": "Title required",
						                    "field_1": "First name required",
						                    "field_6": "Surname required",
						                    "signup_email": {
						                        "required" : "Email required",
						                        "email" : "Invalid email"
						                    },
						                    "field_7": "Mobile telephone required",
						                    "signup_username": "Username required",
						                    "signup_password": "Password required"
						                },
						                errorPlacement: function(error, element) {        
						                	$('.tnc_error').remove();
						                	if($(element).attr("id")=="field_54_0") {						
						                		$(element).parent().parent().append("<span class='tnc_error error'>"+error.text()+"</span>");
						                	}else element.attr("placeholder", error.text());
						                }
	                                });

	                                // var mobile_telephone;

	                                // $("#mobile_country_code").on("change", function(e) {
	                                //     mobile_telephone = $(this).val() + " " + $("#mobile_number").val();
	                                //     $("#mobile-telephone").val(mobile_telephone);
	                                //     console.log($("#mobile-telephone").val())
	                                // });
	                                // $("#mobile_number").on("change keyup", function(e) {
	                                //     mobile_telephone = $("#mobile_country_code").val() + " " + $(this).val();
	                                //     $("#mobile-telephone").val(mobile_telephone);
	                                //     console.log($("#mobile-telephone").val())
	                                // });

	                                // if ($("#mobile-telephone").val() != "") {
	                                //     var result = $("#mobile-telephone").val().split(" ");
	                                //     console.log(result);
	                                //     if (result[0]) {
	                                //         $("#mobile_country_code").val(result[0]);
	                                //     }
	                                //     if (result[1]) {
	                                //         $("#mobile_number").val(result[1])
	                                //     }
	                                // }

	                                var country;

						            $.getJSON("http://ipinfo.io", function(data){
						                country = data.country;
						            

		                                $("#field_7").intlTelInput({
		                                	utilsScript: "<?php echo JS; ?>/plugins/utils.js",
		                                	nationalMode: false,
	                    					preferredCountries: [],
	                    					autoPlaceholder: false
		                                });

		                                $("#field_7").intlTelInput("setCountry", country);

	                                }); 


	                                $(".field_terms-and-conditions").find("span").html("I have read and agree with the <a href=\"<?php echo get_permalink (get_page_by_title('Terms and Conditions')); ?>\" target=\"_blank\">terms and conditions</a>")

	                                // $("#field_10").intlTelInput({
	                                // 	utilsScript: "<?php echo JS; ?>/plugins/utils.js"
	                                // });
	                                // $("#field_10").intlTelInput("setCountry", country);

	                            });

	                        }(jQuery));
	                        </script>
	                        <form action="" name="signup_form" id="signup_form" class="standard-form" method="post" enctype="multipart/form-data">
	                        	<?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>
									<?php
									/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
									do_action( 'template_notices' ); ?>
									<?php

									/**
									 * Fires before the display of the registration disabled message.
									 *
									 * @since 1.5.0
									 */
									do_action( 'bp_before_registration_disabled' ); ?>

										<p><?php _e( 'User registration is currently not allowed.', 'buddypress' ); ?></p>

									<?php

									/**
									 * Fires after the display of the registration disabled message.
									 *
									 * @since 1.5.0
									 */
									do_action( 'bp_after_registration_disabled' ); ?>
								<?php endif; // registration-disabled signup step ?>

								<?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

								<?php
								/** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
								do_action( 'template_notices' ); ?>

								<?php /***** Extra Profile Details ******/ ?>

								<?php if ( bp_is_active( 'xprofile' ) ) : ?>

									<?php
									/**
									 * Fires before the display of member registration xprofile fields.
									 *
									 * @since 1.2.4
									 */
									do_action( 'bp_before_signup_profile_fields' ); ?>

									<?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
									<?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

										<?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
											
											<?php if( bp_get_the_profile_field_name() == "Terms and conditions" ): ?>
												<div class="field-container">
					                            	<?php
													/**
													 * Fires and displays any member registration email errors.
													 *
													 * @since 1.1.0
													 */
													do_action( 'bp_signup_email_errors' ); ?>
					                                <label for="email">Email*</label>
					                                <input type="email" name="signup_email" id="signup_email" class="custom-input-class" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes( 'email' ); ?>/>                                
					                            </div>
					                            <div class="field-container">
					                            	<?php
													/**
													 * Fires and displays any member registration username errors.
													 *
													 * @since 1.1.0
													 */
													do_action( 'bp_signup_username_errors' ); ?>
					                                <label for="signup_username">Username*</label>
													<input type="text" name="signup_username" id="signup_username" class="custom-input-class" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes( 'username' ); ?>/>
					                            </div>
					                            <div class="field-container">
					                            	<?php
													/**
													 * Fires and displays any member registration password errors.
													 *
													 * @since 1.1.0
													 */
													do_action( 'bp_signup_password_errors' ); ?>								
					                                <label for="password">Password*</label>
					                                <input type="password" name="signup_password" id="signup_password" value="" class="custom-input-class password-entry" <?php bp_form_field_attributes( 'password' ); ?>/>
					                                <div id="pass-strength-result"></div>
					                            </div>
					                            <div class="field-container">
					                            	<?php
													/**
													 * Fires and displays any member registration password confirmation errors.
													 *
													 * @since 1.1.0
													 */
													do_action( 'bp_signup_password_confirm_errors' ); ?>
					                                <label for="retype_password">Retype password*</label>
					                                <input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" class="custom-input-class password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/>
					                            </div>
											<?php endif; ?>
											<div<?php bp_field_css_class( 'editfield field-container' ); ?>>

												<?php
												$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );											
												$field_type->edit_field_html();

												/**
												 * Fires before the display of the visibility options for xprofile fields.
												 *
												 * @since 1.7.0
												 */
												do_action( 'bp_custom_profile_edit_fields_pre_visibility' );

												if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
													<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
														<?php
														printf(
															__( 'This field can be seen by: %s', 'buddypress' ),
															'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
														);
														?>
														<a href="#" class="visibility-toggle-link"><?php _ex( 'Change', 'Change profile field visibility level', 'buddypress' ); ?></a>
													</p>

													<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
														<fieldset>
															<legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

															<?php bp_profile_visibility_radio_buttons() ?>

														</fieldset>
														<a class="field-visibility-settings-close" href="#"><?php _e( 'Close', 'buddypress' ) ?></a>

													</div>
												<?php else : ?>
													<!--<p class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
														<?php
														printf(
															__( 'This field can be seen by: %s', 'buddypress' ),
															'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
														);
														?>
													</p>-->
												<?php endif ?>

												<?php

												/**
												 * Fires after the display of the visibility options for xprofile fields.
												 *
												 * @since 1.1.0
												 */
												do_action( 'bp_custom_profile_edit_fields' ); ?>

												<p class="description"><?php bp_the_profile_field_description(); ?></p>

											</div>

										<?php endwhile; ?>

										<input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />										

									<?php endwhile; endif; endif; ?>

									<?php

									/**
									 * Fires and displays any extra member registration xprofile fields.
									 *
									 * @since 1.9.0
									 */
									do_action( 'bp_signup_profile_fields' ); ?>

		                            <?php
									/**
									 * Fires after the display of member registration xprofile fields.
									 *
									 * @since 1.1.0
									 */
									do_action( 'bp_after_signup_profile_fields' ); ?>

	                            <?php endif; ?>	                            

	                            <?php
								/**
								 * Fires before the display of the registration submit buttons.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_before_registration_submit_buttons' ); ?>

								<div class="submit">
									<input type="submit" name="signup_submit" id="signup_submit" class="custom-submit-class" value="<?php esc_attr_e( 'Register', 'buddypress' ); ?>" />
								</div>

								<?php
								/**
								 * Fires after the display of the registration submit buttons.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_after_registration_submit_buttons' ); ?>

								<?php wp_nonce_field( 'bp_new_signup' ); ?>

	                            <?php endif; // request-details signup step ?>	                            

								<?php
								/**
								 * Fires and displays any custom signup steps.
								 *
								 * @since 1.1.0
								 */
								do_action( 'bp_custom_signup_steps' ); ?>

	                        </form>
	                        <div class="wpb_raw_code wpb_content_element wpb_raw_html">
	                            <div class="wpb_wrapper">
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="wpb_column vc_column_container vc_col-sm-3">
	                <div class="vc_column-inner ">
	                    <div class="wpb_wrapper"></div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php

	/**
	 * Fires at the bottom of the BuddyPress member registration page template.
	 *
	 * @since 1.1.0
	 */
	do_action( 'bp_after_register_page' ); ?>
	<?php endif; // completed-confirmation signup step ?>
</div>
<script>
(function($){
	$(".field_title").find("label").text("Title*");
	$(".field_first-name").find("label").text("First name*");
	$(".field_surname").find("label").text("Surname*");
	$(".field_mobile-telephone").find("label").text("Mobile telephone*");
	$(".field_preferred-currency").find("label").text("Preferred currency*");

	$('.field_title').find("select").wrap("<div class='custom-input-class-select-container'></div>");
	$('.field_preferred-currency').find("select").wrap("<div class='custom-input-class-select-container'></div>");

	// if($(".field_title").find("select").length > 0) $(".field_title").find("select").find("option")[0].remove();
  	// if($(".field_preferred-currency").find("select").length > 0) $(".field_preferred-currency").find("select").find("option")[0].remove();
})(jQuery);
</script>