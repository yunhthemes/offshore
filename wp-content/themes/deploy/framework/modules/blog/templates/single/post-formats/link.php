<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php $post_link = get_post_meta(get_the_ID(), 'mkdf_post_link_link_meta', true); ?>


		<div class="mkdf-post-content">

			<div class="mkdf-post-text">
				<div class="mkdf-post-text-inner">
					<div class="mkdf-post-mark">
						<?php echo deploy_mikado_icon_collections()->renderIcon('icon-link', 'simple_line_icons'); ?>
					</div>
					<h4 class="mkdf-post-title">
						<?php if($post_link !== '') : ?>
							<a target="_blank" href="<?php echo esc_url($post_link); ?>">
						<?php endif; ?>

						<?php the_title(); ?>
						<?php if($post_link !== '') : ?>
							</a>
						<?php endif; ?>
					</h4>
					<div class="mkdf-content-info">
						<div class="mkdf-post-info">
							<?php deploy_mikado_post_info($post_info_array); ?>
						</div>
						<?php the_content(); ?>
					</div>
				</div>
			</div>
		</div>
</article>