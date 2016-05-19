<?php
/**
 * BuddyPress - Members Profile Loop
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_before_profile_loop_content' ); ?>

<?php if ( bp_has_profile() ) : ?>

	<?php while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

		<?php if ( bp_profile_group_has_fields() ) : ?>

			<?php

			/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
			do_action( 'bp_before_profile_field_content' ); ?>

			<div class="bp-widget <?php bp_the_profile_group_slug(); ?>">

				<!-- <h4><?php bp_the_profile_group_name(); ?></h4> -->

				<table class="profile-fields">

					<?php $index = 0; while ( bp_profile_fields() ) : bp_the_profile_field(); ?>
						
						<?php if ( bp_field_has_data() ) : ?>
							

							<?php if($index==2): ?>
							<tr class="field_1 field_email required-field visibility-public alt field_type_textbox">

								<td class="label 1"><h6>Email</h6></td>

								<td class="data">
									<p><a href="#" rel="nofollow"><?php echo bp_get_displayed_user_email(); ?></a></p>
								</td>

							</tr>
							<?php endif; ?>

							<tr<?php bp_field_css_class(); ?>>

								<td class="label <?php echo $index; ?>"><h6><?php bp_the_profile_field_name(); ?></h6></td>

								<td class="data"><?php bp_the_profile_field_value(); ?></td>

							</tr>

							<?php $index++; ?>

						<?php endif; ?>

						<?php

						/**
						 * Fires after the display of a field table row for profile data.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_profile_field_item' ); ?>

					<?php endwhile; ?>

				</table>
			</div>

			<?php

			/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
			do_action( 'bp_after_profile_field_content' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php

	/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
	do_action( 'bp_profile_field_buttons' ); ?>

<?php endif; ?>

<?php

/** This action is documented in bp-templates/bp-legacy/buddypress/members/single/profile/profile-wp.php */
do_action( 'bp_after_profile_loop_content' ); ?>