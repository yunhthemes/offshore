<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkdf-post-content">
		<div class="mkdf-post-image">
			<?php deploy_mikado_get_module_template_part('templates/parts/video', 'blog'); ?>
		</div>
		<div class="mkdf-post-text">
			<div class="mkdf-post-text-inner">
				<div class="mkdf-category">
					<?php the_category(', '); ?>
				</div>
				<?php deploy_mikado_get_module_template_part('templates/lists/parts/title', 'blog'); ?>
				<?php
					deploy_mikado_excerpt($excerpt_length);
				?>
				<div class="mkdf-post-info">
					<?php deploy_mikado_post_info($post_info_array, $blog_type); ?>
				</div>
			</div>
		</div>
	</div>
</article>