<?php
$sidebar = deploy_mikado_sidebar_layout();

$excerpt_length_array = deploy_mikado_blog_lists_number_of_chars();
$excerpt_length = $excerpt_length_array['standard'];
?>
<?php get_header(); ?>
<?php deploy_mikado_get_title(); ?>
	<div class="mkdf-container">
		<?php do_action('deploy_mikado_after_container_open'); ?>
		<div class="mkdf-container-inner clearfix">
			<div class="mkdf-container">
				<?php do_action('deploy_mikado_after_container_open'); ?>
				<div class="mkdf-container-inner" >
					<div class="mkdf-blog-holder mkdf-blog-type-standard">

				<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<div class="mkdf-post-content">
							<div class="mkdf-post-text">
								<div class="mkdf-post-text-inner">
									<div class="mkdf-post-info">
										<?php deploy_mikado_post_info(deploy_mikado_get_post_info_config('standard')); ?>
									</div>
									<h3>
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
									</h3>
									<?php
										if(get_post_type() === 'post') {
											deploy_mikado_excerpt($excerpt_length);
										}

										deploy_mikado_read_more_button();
									?>
								</div>
							</div>
						</div>
					</article>
					<?php endwhile; ?>
					<?php
						if(deploy_mikado_options()->getOptionValue('pagination') == 'yes') {
							deploy_mikado_get_blog_pagination_template();
						}
					?>
					<?php else: ?>

						<div class="mkdf-two-columns-66-33 clearfix">
							<div class="mkdf-column1">
								<div class="mkdf-column-inner">
									<div class="entry">
										<div class="mkdf-search-no-results-holder">
											<h3><?php esc_html_e('Nothing found', 'deploy'); ?></h3>
											<p><?php esc_html_e('Sorry, no posts matched your search criteria. Maybe try something else for your search criteria?', 'deploy'); ?></p>
											<?php get_search_form(); ?>
										</div>
									</div>
								</div>
							</div>
							<div class="mkdf-column2">
								<div class="mkdf-column-inner">
									<?php get_sidebar(); ?>
								</div>
							</div>
						</div>

					<?php endif; ?>
				</div>
				<?php do_action('deploy_mikado_before_container_close'); ?>
			</div>
			</div>
		</div>
		<?php do_action('deploy_mikado_before_container_close'); ?>
	</div>
<?php get_footer(); ?>