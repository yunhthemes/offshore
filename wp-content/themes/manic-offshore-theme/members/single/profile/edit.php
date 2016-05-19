<?php
/**
 * BuddyPress - Members Single Profile Edit
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action( 'bp_before_profile_edit_content' );

if ( bp_has_profile( 'profile_group_id=' . bp_get_current_profile_group_id() ) ) :
	while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

<p>All fields must be completed.</p>
<form action="<?php bp_the_profile_group_edit_form_action(); ?>" method="post" id="profile-edit-form" class="standard-form <?php bp_the_profile_group_slug(); ?>">

	<?php

		/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
		do_action( 'bp_before_profile_field_content' ); ?>

		<!-- <h4><?php printf( __( "Editing '%s' Profile Group", 'buddypress' ), bp_get_the_profile_group_name() ); ?></h4> -->

		<?php if ( bp_profile_has_multiple_groups() ) : ?>
			<ul class="button-nav">

				<?php bp_profile_group_tabs(); ?>

			</ul>
		<?php endif ;?>

		<div class="clear"></div>

		<?php $index = 0; while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

			<?php if($index==2): ?>
				<div class="editfield field_1 field_first-name required-field visibility-public alt field_type_textbox">				
					<label for="email">Email</label>		
					<input id="email" type="text" value="<?php echo bp_get_displayed_user_email(); ?>" aria-required="true" disabled="">					
				</div>
			<?php endif; ?>

			<div<?php bp_field_css_class( 'editfield' ); ?>>

				<?php
				$field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
				$field_type->edit_field_html();

				/**
				 * Fires before the display of visibility options for the field.
				 *
				 * @since 1.7.0
				 */
				do_action( 'bp_custom_profile_edit_fields_pre_visibility' );
				?>

				<?php if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
					<p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
						<?php
						printf(
							__( 'This field can be seen by: %s', 'buddypress' ),
							'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
						);
						?>
						<a href="#" class="visibility-toggle-link"><?php _e( 'Change', 'buddypress' ); ?></a>
					</p>

					<div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
						<fieldset>
							<legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

							<?php bp_profile_visibility_radio_buttons() ?>

						</fieldset>
						<a class="field-visibility-settings-close" href="#"><?php _e( 'Close', 'buddypress' ) ?></a>
					</div>
				<?php else : ?>
					<div class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
						<?php
						printf(
							__( 'This field can be seen by: %s', 'buddypress' ),
							'<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
						);
						?>
					</div>
				<?php endif ?>

				<?php

				/**
				 * Fires after the visibility options for a field.
				 *
				 * @since 1.1.0
				 */
				do_action( 'bp_custom_profile_edit_fields' ); ?>

				<p class="description"><?php bp_the_profile_field_description(); ?></p>
			</div>

			<?php $index++; ?>

		<?php endwhile; ?>

	<?php

	/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
	do_action( 'bp_after_profile_field_content' ); ?>

	<div class="submit">
		<input type="submit" name="profile-group-edit-submit" id="profile-group-edit-submit" value="<?php esc_attr_e( 'Save changes', 'buddypress' ); ?> " />
	</div>

	<input type="hidden" name="field_ids" id="field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

	<?php wp_nonce_field( 'bp_xprofile_edit' ); ?>

</form>
<script>
	jQuery(document).ready(function($){

		$(".field_first-name").find("input").prop("disabled", true);
		$(".field_surname").find("input").prop("disabled", true);
		$(".field_date-of-birth").find("input").prop("disabled", true);

		$(".field_title").find("select").wrap("<div class='custom-input-class-select-container'></div>");
	
		$(".field_home-address").find("input").attr("placeholder", "Street");
		$(".field_home-address-2").find("input").attr("placeholder", "City");
		$(".field_home-address-3").find("input").attr("placeholder", "State");
		// $(".field_home-address-4").find("input").attr("placeholder", "City");
		// $(".field_home-address-5").find("input").attr("placeholder", "Postcode");
		$(".field_home-address-6").find("input").attr("placeholder", "Country");

		$(".field_postal-address").find("input").attr("placeholder", "Street");
		$(".field_postal-address-2").find("input").attr("placeholder", "City");
		$(".field_postal-address-3").find("input").attr("placeholder", "State");
		// $(".field_postal-address-4").find("input").attr("placeholder", "City");
		// $(".field_postal-address-5").find("input").attr("placeholder", "Postcode");
		$(".field_postal-address-6").find("input").attr("placeholder", "Country");

		var html = '<option value="">Country</option><option value="Afghanistan">Afghanistan</option> <option value="Albania">Albania</option> <option value="Algeria">Algeria</option> <option value="American Samoa">American Samoa</option> <option value="Andorra">Andorra</option> <option value="Angola">Angola</option> <option value="Anguilla">Anguilla</option> <option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option> <option value="Argentina">Argentina</option> <option value="Armenia">Armenia</option> <option value="Aruba">Aruba</option> <option value="Australia">Australia</option> <option value="Austria">Austria</option> <option value="Azerbaijan">Azerbaijan</option> <option value="Bahamas">Bahamas</option> <option value="Bahrain">Bahrain</option> <option value="Bangladesh">Bangladesh</option> <option value="Barbados">Barbados</option> <option value="Belarus">Belarus</option> <option value="Belgium">Belgium</option> <option value="Belize">Belize</option> <option value="Benin">Benin</option> <option value="Bermuda">Bermuda</option> <option value="Bhutan">Bhutan</option> <option value="Bolivia">Bolivia</option> <option value="Bonaire">Bonaire</option> <option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option> <option value="Botswana">Botswana</option> <option value="Brazil">Brazil</option> <option value="British Indian Ocean Ter">British Indian Ocean Ter</option> <option value="Brunei">Brunei</option> <option value="Bulgaria">Bulgaria</option> <option value="Burkina Faso">Burkina Faso</option> <option value="Burundi">Burundi</option> <option value="Cambodia">Cambodia</option> <option value="Cameroon">Cameroon</option> <option value="Canada">Canada</option> <option value="Canary Islands">Canary Islands</option> <option value="Cape Verde">Cape Verde</option> <option value="Cayman Islands">Cayman Islands</option> <option value="Central African Republic">Central African Republic</option> <option value="Chad">Chad</option> <option value="Channel Islands">Channel Islands</option> <option value="Chile">Chile</option> <option value="China">China</option> <option value="Christmas Island">Christmas Island</option> <option value="Cocos Island">Cocos Island</option> <option value="Colombia">Colombia</option> <option value="Comoros">Comoros</option> <option value="Congo">Congo</option> <option value="Cook Islands">Cook Islands</option> <option value="Costa Rica">Costa Rica</option> <option value="Cote D`Ivoire">Cote D`Ivoire</option> <option value="Croatia">Croatia</option> <option value="Cuba">Cuba</option> <option value="Curacao">Curacao</option> <option value="Cyprus">Cyprus</option> <option value="Czech Republic">Czech Republic</option> <option value="Denmark">Denmark</option> <option value="Djibouti">Djibouti</option> <option value="Dominica">Dominica</option> <option value="Dominican Republic">Dominican Republic</option> <option value="East Timor">East Timor</option> <option value="Ecuador">Ecuador</option> <option value="Egypt">Egypt</option> <option value="El Salvador">El Salvador</option> <option value="Equatorial Guinea">Equatorial Guinea</option> <option value="Eritrea">Eritrea</option> <option value="Estonia">Estonia</option> <option value="Ethiopia">Ethiopia</option> <option value="Falkland Islands">Falkland Islands</option> <option value="Faroe Islands">Faroe Islands</option> <option value="Fiji">Fiji</option> <option value="Finland">Finland</option> <option value="France">France</option> <option value="French Guiana">French Guiana</option> <option value="French Polynesia">French Polynesia</option> <option value="French Southern Ter">French Southern Ter</option> <option value="Gabon">Gabon</option> <option value="Gambia">Gambia</option> <option value="Georgia">Georgia</option> <option value="Germany">Germany</option> <option value="Ghana">Ghana</option> <option value="Gibraltar">Gibraltar</option> <option value="Great Britain">Great Britain</option> <option value="Greece">Greece</option> <option value="Greenland">Greenland</option> <option value="Grenada">Grenada</option> <option value="Guadeloupe">Guadeloupe</option> <option value="Guam">Guam</option> <option value="Guatemala">Guatemala</option> <option value="Guinea">Guinea</option> <option value="Guyana">Guyana</option> <option value="Haiti">Haiti</option> <option value="Hawaii">Hawaii</option> <option value="Honduras">Honduras</option> <option value="Hong Kong">Hong Kong</option> <option value="Hungary">Hungary</option> <option value="Iceland">Iceland</option> <option value="India">India</option> <option value="Indonesia">Indonesia</option> <option value="Iran">Iran</option> <option value="Iraq">Iraq</option> <option value="Ireland">Ireland</option> <option value="Isle of Man">Isle of Man</option> <option value="Israel">Israel</option> <option value="Italy">Italy</option> <option value="Jamaica">Jamaica</option> <option value="Japan">Japan</option> <option value="Jordan">Jordan</option> <option value="Kazakhstan">Kazakhstan</option> <option value="Kenya">Kenya</option> <option value="Kiribati">Kiribati</option> <option value="Korea North">Korea North</option> <option value="Korea South">Korea South</option> <option value="Kuwait">Kuwait</option> <option value="Kyrgyzstan">Kyrgyzstan</option> <option value="Laos">Laos</option> <option value="Latvia">Latvia</option> <option value="Lebanon">Lebanon</option> <option value="Lesotho">Lesotho</option> <option value="Liberia">Liberia</option> <option value="Libya">Libya</option> <option value="Liechtenstein">Liechtenstein</option> <option value="Lithuania">Lithuania</option> <option value="Luxembourg">Luxembourg</option> <option value="Macau">Macau</option> <option value="Macedonia">Macedonia</option> <option value="Madagascar">Madagascar</option> <option value="Malaysia">Malaysia</option> <option value="Malawi">Malawi</option> <option value="Maldives">Maldives</option> <option value="Mali">Mali</option> <option value="Malta">Malta</option> <option value="Marshall Islands">Marshall Islands</option> <option value="Martinique">Martinique</option> <option value="Mauritania">Mauritania</option> <option value="Mauritius">Mauritius</option> <option value="Mayotte">Mayotte</option> <option value="Mexico">Mexico</option> <option value="Midway Islands">Midway Islands</option> <option value="Moldova">Moldova</option> <option value="Monaco">Monaco</option> <option value="Mongolia">Mongolia</option> <option value="Montserrat">Montserrat</option> <option value="Morocco">Morocco</option> <option value="Mozambique">Mozambique</option> <option value="Myanmar">Myanmar</option> <option value="Nambia">Nambia</option> <option value="Nauru">Nauru</option> <option value="Nepal">Nepal</option> <option value="Netherland Antilles">Netherland Antilles</option> <option value="Netherlands">Netherlands (Holland, Europe)</option> <option value="Nevis">Nevis</option> <option value="New Caledonia">New Caledonia</option> <option value="New Zealand">New Zealand</option> <option value="Nicaragua">Nicaragua</option> <option value="Niger">Niger</option> <option value="Nigeria">Nigeria</option> <option value="Niue">Niue</option> <option value="Norfolk Island">Norfolk Island</option> <option value="Norway">Norway</option> <option value="Oman">Oman</option> <option value="Pakistan">Pakistan</option> <option value="Palau Island">Palau Island</option> <option value="Palestine">Palestine</option> <option value="Panama">Panama</option> <option value="Papua New Guinea">Papua New Guinea</option> <option value="Paraguay">Paraguay</option> <option value="Peru">Peru</option> <option value="Phillipines">Philippines</option> <option value="Pitcairn Island">Pitcairn Island</option> <option value="Poland">Poland</option> <option value="Portugal">Portugal</option> <option value="Puerto Rico">Puerto Rico</option> <option value="Qatar">Qatar</option> <option value="Republic of Montenegro">Republic of Montenegro</option> <option value="Republic of Serbia">Republic of Serbia</option> <option value="Reunion">Reunion</option> <option value="Romania">Romania</option> <option value="Russia">Russia</option> <option value="Rwanda">Rwanda</option> <option value="St Barthelemy">St Barthelemy</option> <option value="St Eustatius">St Eustatius</option> <option value="St Helena">St Helena</option> <option value="St Kitts-Nevis">St Kitts-Nevis</option> <option value="St Lucia">St Lucia</option> <option value="St Maarten">St Maarten</option> <option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option> <option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option> <option value="Saipan">Saipan</option> <option value="Samoa">Samoa</option> <option value="Samoa American">Samoa American</option> <option value="San Marino">San Marino</option> <option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option> <option value="Saudi Arabia">Saudi Arabia</option> <option value="Senegal">Senegal</option> <option value="Serbia">Serbia</option> <option value="Seychelles">Seychelles</option> <option value="Sierra Leone">Sierra Leone</option> <option value="Singapore">Singapore</option> <option value="Slovakia">Slovakia</option> <option value="Slovenia">Slovenia</option> <option value="Solomon Islands">Solomon Islands</option> <option value="Somalia">Somalia</option> <option value="South Africa">South Africa</option> <option value="Spain">Spain</option> <option value="Sri Lanka">Sri Lanka</option> <option value="Sudan">Sudan</option> <option value="Suriname">Suriname</option> <option value="Swaziland">Swaziland</option> <option value="Sweden">Sweden</option> <option value="Switzerland">Switzerland</option> <option value="Syria">Syria</option> <option value="Tahiti">Tahiti</option> <option value="Taiwan">Taiwan</option> <option value="Tajikistan">Tajikistan</option> <option value="Tanzania">Tanzania</option> <option value="Thailand">Thailand</option> <option value="Togo">Togo</option> <option value="Tokelau">Tokelau</option> <option value="Tonga">Tonga</option> <option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option> <option value="Tunisia">Tunisia</option> <option value="Turkey">Turkey</option> <option value="Turkmenistan">Turkmenistan</option> <option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option> <option value="Tuvalu">Tuvalu</option> <option value="Uganda">Uganda</option> <option value="Ukraine">Ukraine</option> <option value="United Arab Emirates">United Arab Emirates</option> <option value="United Kingdom">United Kingdom</option> <option value="United States of America">United States of America</option> <option value="Uruguay">Uruguay</option> <option value="Uzbekistan">Uzbekistan</option> <option value="Vanuatu">Vanuatu</option> <option value="Vatican City State">Vatican City State</option> <option value="Venezuela">Venezuela</option> <option value="Vietnam">Vietnam</option> <option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option> <option value="Virgin Islands (USA)">Virgin Islands (USA)</option> <option value="Wake Island">Wake Island</option> <option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option> <option value="Yemen">Yemen</option> <option value="Zaire">Zaire</option> <option value="Zambia">Zambia</option> <option value="Zimbabwe">Zimbabwe</option>';

		$(".field_home-address-6").find("input").after("<select id='home-address-country'></select>");
		$(".field_home-address-6").find("select").wrap("<div class='custom-input-class-select-container'></div>").html(html);

		$(".field_postal-address-6").find("input").after("<select id='postal-address-country'></select>");
		$(".field_postal-address-6").find("select").wrap("<div class='custom-input-class-select-container'></div>").html(html);

		$(".field_nationality").find("input").after("<select id='nationality' disabled></select>");
		$(".field_nationality").find("select").wrap("<div class='custom-input-class-select-container'></div>").html(html);

		$(".field_nationality").find("#nationality").on('change', function(e){
			$(this).parent().parent().find('input').val($(this).val());
		});

		$(".field_home-address-6").find("#home-address-country").on('change', function(e){
			$(this).parent().parent().find('input').val($(this).val());
		});

		$(".field_postal-address-6").find("#postal-address-country").on('change', function(e){
			$(this).parent().parent().find('input').val($(this).val());
		});

		$(".field_nationality").find("#nationality").val($(".field_nationality").find("input").val());
		$(".field_postal-address-6").find("#postal-address-country").val($(".field_postal-address-6").find("input").val());
		$(".field_home-address-6").find("#home-address-country").val($(".field_home-address-6").find("input").val());

		$(".field_date-of-birth").find("input").datepicker({ dateFormat: 'dd/mm/y' });

		function initInputTel($selector) {
            $selector.intlTelInput({
                utilsScript: "<?php echo JS; ?>/plugins/utils.js",
                nationalMode: false
            });
            $selector.intlTelInput("setCountry", "sg");   
        }

		initInputTel($(".field_work-telephone").find("input"));
		initInputTel($(".field_home-telephone").find("input"));
		initInputTel($(".field_mobile-telephone").find("input"));

		$("#profile-edit-form").validate({
			rules: {
				"field_19": {
					"required": {
						depends : function(elem){							
							if($("#field_20").val()!="" || $("#field_21").val()!="" || $("#field_22").val()!="" || $("#field_23").val()!="" || $("#field_24").val()!="") return true;
						}
					}
				},
				"field_20": {
					"required": {
						depends : function(elem){							
							if($("#field_19").val()!="" || $("#field_21").val()!="" || $("#field_22").val()!="" || $("#field_23").val()!="" || $("#field_24").val()!="") return true;
						}
					}
				},
				"field_21": {
					"required": {
						depends : function(elem){							
							if($("#field_19").val()!="" || $("#field_20").val()!="" || $("#field_22").val()!="" || $("#field_23").val()!="" || $("#field_24").val()!="") return true;
						}
					}
				},
				"field_22": {
					"required": {
						depends : function(elem){							
							if($("#field_19").val()!="" || $("#field_20").val()!="" || $("#field_21").val()!="" || $("#field_23").val()!="" || $("#field_24").val()!="") return true;
						}
					}
				},
				"field_23": {
					"required": {
						depends : function(elem){							
							if($("#field_19").val()!="" || $("#field_20").val()!="" || $("#field_21").val()!="" || $("#field_22").val()!="" || $("#field_24").val()!="") return true;
						}
					}
				},
				"field_24": {
					"required": {
						depends : function(elem){							
							if($("#field_19").val()!="" || $("#field_20").val()!="" || $("#field_21").val()!="" || $("#field_22").val()!="" || $("#field_23").val()!="") return true;
						}
					}
				},

				"field_25": {
					"required": {
						depends : function(elem){							
							if($("#field_26").val()!="" || $("#field_27").val()!="" || $("#field_28").val()!="" || $("#field_29").val()!="" || $("#field_30").val()!="") return true;
						}
					}
				},
				"field_26": {
					"required": {
						depends : function(elem){							
							if($("#field_25").val()!="" || $("#field_27").val()!="" || $("#field_28").val()!="" || $("#field_29").val()!="" || $("#field_30").val()!="") return true;
						}
					}
				},
				"field_27": {
					"required": {
						depends : function(elem){							
							if($("#field_25").val()!="" || $("#field_26").val()!="" || $("#field_28").val()!="" || $("#field_29").val()!="" || $("#field_30").val()!="") return true;
						}
					}
				},
				"field_28": {
					"required": {
						depends : function(elem){							
							if($("#field_25").val()!="" || $("#field_26").val()!="" || $("#field_27").val()!="" || $("#field_29").val()!="" || $("#field_30").val()!="") return true;
						}
					}
				},
				"field_29": {
					"required": {
						depends : function(elem){							
							if($("#field_25").val()!="" || $("#field_26").val()!="" || $("#field_27").val()!="" || $("#field_28").val()!="" || $("#field_30").val()!="") return true;
						}
					}
				},
				"field_30": {
					"required": {
						depends : function(elem){							
							if($("#field_25").val()!="" || $("#field_26").val()!="" || $("#field_27").val()!="" || $("#field_28").val()!="" || $("#field_29").val()!="") return true;
						}
					}
				}
			}
		})
		
	});
</script>

<?php endwhile; endif; ?>

<?php

/**
 * Fires after the display of member profile edit content.
 *
 * @since 1.1.0
 */
do_action( 'bp_after_profile_edit_content' ); ?>
