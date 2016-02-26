<?php
/**
 * Team info on hover shortcode template
 */

global $mkdDeployIconCollections;
$number_of_social_icons = 5;
?>
<?php if ($team_name !== '' || $team_position !== '' || $team_social_icon_pack !== '') {?>
<div class="mkdf-team <?php echo esc_attr( $team_type )?>">

	<?php } ?>
	<div class="mkdf-team-inner">
		<?php if ( $team_image !== '' ) { ?>
		<div class="mkdf-team-image">
			<img src="<?php echo esc_url($team_image_src); ?>" alt="<?php esc_attr_e('team-image', 'deploy'); ?>" />
			<div class="mkdf-team-social-holder">
				<div class="mkdf-team-social">
					<div class="mkdf-team-social-inner">
						<div class="mkdf-team-title-holder">
							<?php if ( $team_name !== '' ) { ?>
							<<?php echo esc_attr($team_name_tag); ?> class="mkdf-team-name">
								<?php echo esc_attr( $team_name ); ?>
							</<?php echo esc_attr($team_name_tag); ?>>
							<?php }
							if ( $team_position !== '' ) { ?>
							<h6 class="mkdf-team-position">
								<?php echo esc_attr( $team_position ); ?>
							</h6>
							<?php } ?>
						</div>
						<div class="mkdf-team-social-wrapp">

							<?php foreach( $team_social_icons as $team_social_icon ) {
								print $team_social_icon;
							} ?>

						</div>
					</div>
				</div>
			</div>
		</div>
		<?php }

		if ($team_description !== '') { ?>
		<div class="mkdf-team-text">
			<div class="mkdf-team-text-inner">
				<div class="mkdf-team-description">
					<p><?php echo esc_attr( $team_description ); ?></p>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
</div>
