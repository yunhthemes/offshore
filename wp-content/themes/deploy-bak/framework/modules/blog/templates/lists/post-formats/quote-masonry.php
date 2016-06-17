<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<a href="<?php the_permalink() ?>">
		<div class="mkdf-post-content">
			<div class="mkdf-post-text">
				<div class="mkdf-post-text-inner">
					<div class="mkdf-category">
						<?php the_category(', '); ?>
					</div>
					<div class="mkdf-post-mark">
						<?php echo deploy_mikado_icon_collections()->renderIcon('icon_quotations', 'font_elegant'); ?>
					</div>
					<div class="mkdf-post-title-holder">
						<h4 class="mkdf-post-title">
							<a href="<?php esc_url(the_permalink()); ?>">
								<?php echo esc_html(get_post_meta(get_the_ID(), 'mkdf_post_quote_text_meta', true)); ?>
							</a>
						</h4>

						<p class="mkdf-quote-author">- <?php the_title(); ?></p>

						<div class="mkdf-post-info">
							<?php deploy_mikado_post_info($post_info_array, $blog_type); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</a>
</article>