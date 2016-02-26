<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkdf-post-content">
		<?php deploy_mikado_get_module_template_part('templates/single/parts/gallery', 'blog'); ?>
		<div class="mkdf-post-text">
			<div class="mkdf-post-text-inner clearfix">
				<?php if(deploy_mikado_options()->getOptionValue('blog_enable_single_category') === 'yes') : ?>
					<div class="mkdf-category">
						<?php the_category(', '); ?>
					</div>
				<?php endif; ?>
				<?php deploy_mikado_get_module_template_part('templates/single/parts/title', 'blog'); ?>
				<div class="mkdf-post-info">
					<?php deploy_mikado_post_info($post_info_array) ?>
				</div>
				<?php the_content(); ?>
			</div>
		</div>
	</div>
	<?php do_action('deploy_mikado_before_blog_article_closed_tag'); ?>
</article>