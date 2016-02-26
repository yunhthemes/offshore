<div <?php deploy_mikado_class_attribute($holder_classes); ?>>
	<div class="mkdf-blog-carousel-inner <?php echo esc_attr($gray); ?>">
		<?php if($query->have_posts()) : while($query->have_posts()) : $query->the_post(); ?>
			<div class="mkdf-blog-standard-whole-content">
				<div class="mkdf-blog-standard-item-holder-outer">
					<?php if(has_post_thumbnail()) : ?>

						<div class="mkdf-blog-standard-image-holder">
							<a href="<?php the_permalink(); ?>">
								<?php if(!$using_custom_image_sizes) : ?>
									<?php the_post_thumbnail($thumb_size); ?>
								<?php else: ?>
									<?php echo deploy_mikado_generate_thumbnail(get_post_thumbnail_id(), null, $custom_image_sizes[0], $custom_image_sizes[1]); ?>
								<?php endif; ?>
							</a>
						</div>
					<?php endif; ?>

					<div class="mkdf-blog-carousel-gray-gradient"></div>
					<div class="mkdf-blog-carousel-primary-gradient"></div>
					<div class="mkdf-standard-content-holder">
						<?php if($params['remove_category'] === 'no') : ?>
							<div class="mkdf-blog-standard-category">
								<?php the_category(' '); ?>
							</div>
						<?php endif; ?>
						<a href="<?php the_permalink(); ?>">
							<div class="mkdf-blog-whole-link">
								<div class="mkdf-blog-whole-section">
									<div class="mkdf-blog-standard-date-section">
										<span class="mkdf-blog-date"><?php the_time('M d, Y'); ?></span>
									</div>
									<h3 class="mkdf-standard-item-title">
										<?php the_title(); ?>
									</h3>
								</div>
							</div>
						</a>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		<?php endif; ?>
	</div>
</div>