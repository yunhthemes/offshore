<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="mkdf-post-content">
		<div class="mkdf-post-text">
			<div class="mkdf-post-text-inner">
				<div class="mkdf-post-mark">
					<?php echo deploy_mikado_icon_collections()->renderIcon('icon_quotations', 'font_elegant'); ?>
				</div>
				<div class="mkdf-post-title-holder">
					<h4 class="mkdf-post-title"><?php echo esc_html(get_post_meta(get_the_ID(), 'mkdf_post_quote_text_meta', true)); ?></h4>
					<p class="mkdf-quote-author">- <?php the_title(); ?></p>
				</div>
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