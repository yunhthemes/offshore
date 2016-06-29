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

							<?php if(strpos(bp_the_profile_field_name(), 'telephone') || strpos(bp_the_profile_field_name(), 'address') || strpos(bp_the_profile_field_name(), 'currency')): ?>
								<?php if($email==false): $email = true; ?>
								<tr class="field_1 field_email required-field visibility-public alt field_type_textbox">

									<td class="label 1"><h6>Email</h6></td>

									<td class="data">
										<p><a href="#" rel="nofollow"><?php echo bp_get_displayed_user_email(); ?></a></p>
									</td>

								</tr>
								<?php endif; ?>
							<?php endif; ?>

							<tr<?php bp_field_css_class(); ?>>

								<td class="label <?php echo $index; ?>"><h6><?php echo bp_the_profile_field_name(); ?></h6></td>

								<td class="data"><?php bp_the_profile_field_value(); ?></td>

							</tr>							

						<?php endif; ?>

						<?php $index++; ?>

						<?php

						/**
						 * Fires after the display of a field table row for profile data.
						 *
						 * @since 1.1.0
						 */
						do_action( 'bp_profile_field_item' ); ?>

					<?php endwhile;
					$author_meta = get_user_by('id', get_current_user_id());		
					$author_registered = $author_meta->user_registered;		
					?>
					<tr class="optional-field visibility-public alt field_type_textbox">
						<td class="label 5"><h6>Account registered</h6></td>
						<td class="data"><p><?php if($author_registered) echo date("d M Y", strtotime($author_registered)) . ' at ' . date("H:i", strtotime($author_registered)); ?></p></td>
					</tr>

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