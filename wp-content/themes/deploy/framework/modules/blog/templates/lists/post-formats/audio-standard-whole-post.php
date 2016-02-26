<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkdf-post-content">
		<?php deploy_mikado_get_module_template_part('templates/lists/parts/image', 'blog'); ?>
		<?php deploy_mikado_get_module_template_part('templates/parts/audio', 'blog'); ?>
		<div class="mkdf-post-text">
			<div class="mkdf-post-text-inner">
				<?php deploy_mikado_get_module_template_part('templates/lists/parts/title', 'blog'); ?>
				<div class="mkdf-post-info">
					<?php deploy_mikado_post_info($post_info_array, $blog_type); ?>
				</div>
				<?php
					the_content();
				?>
			</div>
		</div>
	</div>
</article>