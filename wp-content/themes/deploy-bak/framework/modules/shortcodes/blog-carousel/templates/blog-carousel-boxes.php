<div <?php deploy_mikado_class_attribute($holder_classes); ?>>
	<div class="mkdf-blog-carousel-inner">
		<?php if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); ?>
			<div class="mkdf-blog-box-whole-content">
				<div class="mkdf-blog-boxes-item-holder-outer">
					<?php if(has_post_thumbnail()) : ?>
						<?php if($params['hide_image'] === 'no') : ?>
						<div class="mkdf-blog-boxes-image-holder">
							<a href="<?php the_permalink(); ?>">
								<?php if(!$using_custom_image_sizes) : ?>
									<?php the_post_thumbnail($thumb_size); ?>
								<?php else: ?>
									<?php echo deploy_mikado_generate_thumbnail(get_post_thumbnail_id(), null, $custom_image_sizes[0], $custom_image_sizes[1]); ?>
								<?php endif; ?>
							</a>
						</div>
					<?php endif; ?>
					<?php endif; ?>

					<div class="mkdf-blog-boxes-content-holder">
						<div class="mkdf-blog-boxes-category">
							<?php the_category(', '); ?>
						</div>

						<div class="mkdf-boxes-content-holder">
							<h4 class="mkdf-boxes-item-title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
							</h4>

							<?php if($text_length !== '0' & $text_length !== '') : ?>
								<div class="mkdf-boxes-excerpt">
									<?php deploy_mikado_excerpt($text_length); ?>
								</div>
							<?php endif; ?>
						</div>

						<div class="mkdf-blog-boxes-info-section clearfix">
							<div class="mkdf-blog-info-section-item mkdf-blog-info-date-section">
							<span class="mkdf-blog-date-icon">
                                <?php echo deploy_mikado_icon_collections()->renderIcon('icon-calender', 'simple_line_icons'); ?>
                            </span>
								<span class="mkdf-blog-date"><?php the_time('M d, Y'); ?></span>
							</div>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile;
		else: ?>
			<p><?php esc_html_e('No posts were found.', 'deploy'); ?></p>
		<?php endif; ?>
	</div>
	<!-- close .mkdf-blog-carousel-inner -->
</div>