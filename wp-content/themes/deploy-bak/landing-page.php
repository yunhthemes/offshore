<?php
/*
Template Name: Landing Page
*/
$sidebar = deploy_mikado_sidebar_layout();

?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <?php deploy_mikado_wp_title(); ?>

        <?php
        /**
         * deploy_mikado_header_meta hook
         *
         * @see deploy_mikado_header_meta() - hooked with 10
         * @see mkd_user_scalable_meta() - hooked with 10
         */
        do_action('deploy_mikado_header_meta');
        ?>

        <?php wp_head(); ?>
    </head>

<body <?php body_class(); ?>>

<?php
if(deploy_mikado_options()->getOptionValue('smooth_page_transitions') === 'yes') { ?>
	<div class="mkdf-smooth-transition-loader mkdf-mimic-ajax">
		<div class="mkdf-st-loader">
			<div class="mkdf-st-loader1">
				<?php deploy_mikado_loading_spinners(); ?>
			</div>
		</div>
	</div>
<?php } ?>

<div class="mkdf-wrapper">
	<div class="mkdf-wrapper-inner">
		<div class="mkdf-content">
			<div class="mkdf-content-inner">
				<?php deploy_mikado_get_title(); ?>
				<?php get_template_part('slider');?>
				<div class="mkdf-full-width">
					<div class="mkdf-full-width-inner">
						<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
							<?php if(($sidebar == 'default')||($sidebar == '')) : ?>
								<?php the_content(); ?>
								<?php do_action('deploy_mikado_page_after_content'); ?>
							<?php elseif($sidebar == 'sidebar-33-right' || $sidebar == 'sidebar-25-right'): ?>
								<div <?php echo deploy_mikado_sidebar_columns_class(); ?>>
									<div class="mkdf-column1 mkdf-content-left-from-sidebar">
										<div class="mkdf-column-inner">
											<?php the_content(); ?>
											<?php do_action('deploy_mikado_page_after_content'); ?>
										</div>
									</div>
									<div class="mkdf-column2">
										<?php get_sidebar(); ?>
									</div>
								</div>
							<?php elseif($sidebar == 'sidebar-33-left' || $sidebar == 'sidebar-25-left'): ?>
								<div <?php echo deploy_mikado_sidebar_columns_class(); ?>>
									<div class="mkdf-column1">
										<?php get_sidebar(); ?>
									</div>
									<div class="mkdf-column2 mkdf-content-right-from-sidebar">
										<div class="mkdf-column-inner">
											<?php the_content(); ?>
											<?php do_action('deploy_mikado_page_after_content'); ?>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endwhile; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php wp_footer(); ?>
</body>
</html>