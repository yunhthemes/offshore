<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkdf-post-content">
		<div class="mkdf-audio-image-holder">
			<?php deploy_mikado_get_module_template_part('templates/lists/parts/image', 'blog'); ?>

			<?php if(has_post_thumbnail()) : ?>
				<div class="mkdf-audio-player-holder">
					<?php deploy_mikado_get_module_template_part('templates/parts/audio', 'blog'); ?>
				</div>
			<?php endif; ?>
		</div>

		<?php if(!has_post_thumbnail()) : ?>
			<?php deploy_mikado_get_module_template_part('templates/parts/audio', 'blog'); ?>
		<?php endif; ?>
		<div class="mkdf-post-text">
			<div class="mkdf-post-text-inner">
				<div class="mkdf-category">
					<?php the_category(', '); ?>
				</div>
				<?php deploy_mikado_get_module_template_part('templates/lists/parts/title', 'blog'); ?>
				<div class="mkdf-post-info">
					<?php deploy_mikado_post_info($post_info_array, $blog_type); ?>
				</div>
				<?php
					deploy_mikado_excerpt($excerpt_length);
					deploy_mikado_read_more_button();
				?>
			</div>
		</div>
	</div>
</article>