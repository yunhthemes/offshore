<div class="item-list-tabs no-ajax" id="subnav" role="navigation">
	<ul>		
		<li id="public-personal-li"><a id="public" href="<?php echo home_url( '/client-dashboard/' . bp_core_get_username( get_current_user_id() ) ) . '/profile'; ?>">View</a></li>
		<li id="edit-personal-li"><a id="edit" href="<?php echo home_url( '/client-dashboard/' . bp_core_get_username( get_current_user_id() ) ) . '/profile/edit'; ?>">Edit</a></li>
		<li class="current selected"><a id="settings" href="<?php echo home_url( '/client-dashboard/' . bp_core_get_username( get_current_user_id() ) ) . '/settings'; ?>">Change password</a></li>
	</ul>
</div><!-- .item-list-tabs -->
<div class="vc_empty_space" style="height: 29px"><span class="vc_empty_space_inner"></span></div>
<?php
/**
 * BuddyPress - Members Single Profile
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_before_member_settings_template' ); ?>

<form action="<?php echo bp_displayed_user_domain() . bp_get_settings_slug() . '/general'; ?>" method="post" class="standard-form" id="settings-form">

	<?php //if ( !is_super_admin() ) : ?>
		<?php _e( 'Current Password', 'buddypress' ); ?><!-- <label for="pwd"></label> --> <!-- <span>(required to update email or change current password)</span> -->
		<input type="password" name="pwd" id="pwd" size="16" value="" class="settings-input small" <?php bp_form_field_attributes( 'password' ); ?>/><!--  &nbsp;<a href="<?php echo wp_lostpassword_url(); ?>" title="<?php esc_attr_e( 'Password Lost and Found', 'buddypress' ); ?>"><?php _e( 'Lost your password?', 'buddypress' ); ?></a> -->
	<?php //endif; ?>
	<!-- <label for="email"><?php _e( 'Account Email', 'buddypress' ); ?></label>
	<input type="email" name="email" id="email" value="<?php echo bp_get_displayed_user_email(); ?>" class="settings-input" <?php bp_form_field_attributes( 'email' ); ?>/> -->
	<!-- <label for="pass1"><?php _e( 'Change Password <span>(leave blank for no change)</span>', 'buddypress' ); ?></label> -->
	 &nbsp;<?php _e( 'New Password', 'buddypress' ); ?><br />
	<input type="password" name="pass1" id="pass1" size="16" value="" class="settings-input small password-entry" <?php bp_form_field_attributes( 'password' ); ?>/>
	<div id="pass-strength-result"></div>
	<label for="pass2" class="bp-screen-reader-text"><?php _e( 'Repeat New Password', 'buddypress' ); ?></label>
	<?php _e( 'Repeat New Password', 'buddypress' ); ?><br />
	<input type="password" name="pass2" id="pass2" size="16" value="" class="settings-input small password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/>

	<?php

	/**
	 * Fires before the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_before_submit' ); ?>

	<div class="submit">
		<input type="submit" name="submit" value="<?php esc_attr_e( 'Save changes', 'buddypress' ); ?>" id="submit" class="auto" />
	</div>

	<?php

	/**
	 * Fires after the display of the submit button for user general settings saving.
	 *
	 * @since 1.5.0
	 */
	do_action( 'bp_core_general_settings_after_submit' ); ?>

	<?php wp_nonce_field( 'bp_settings_general' ); ?>

</form>
<script>
	jQuery(document).ready(function($){
		$("#settings-form").validate({
			rules: {
				pwd: "required",
				pass1: {
					required: true
				},
				pass2: {
					required: true,
					equalTo: "#pass1"
				}
			},
            errorPlacement: function(error, element) {                            
                element.attr("placeholder", error.text());
            }
		});
	});
</script>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/settings/profile.php */
do_action( 'bp_after_member_settings_template' ); ?>
