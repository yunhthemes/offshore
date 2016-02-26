<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkdf-post-content">
		<div class="mkdf-post-text">
			<div class="mkdf-post-text-inner">
				<div class="mkdf-category">
					<?php the_category(', '); ?>
				</div>
				<div class="mkdf-post-mark">
					<?php echo deploy_mikado_icon_collections()->renderIcon('icon-link', 'simple_line_icons'); ?>
				</div>
				<h4 class="mkdf-post-title">
					<a href="<?php esc_url(the_permalink()); ?>"><?php the_title(); ?></a>
				</h4>

				<div class="mkdf-post-info">
					<?php deploy_mikado_post_info($post_info_array, $blog_type); ?>
				</div>
			</div>
		</div>
	</div>
</article>