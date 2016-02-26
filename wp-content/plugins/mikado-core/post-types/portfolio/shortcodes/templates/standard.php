<!--space for right ordering on the list- has to be here-->
<article class="mkdf-portfolio-item mix <?php echo esc_attr($categories) ?>">
	<div class="mkdf-item-image-holder">
		<a href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($item_target); ?>">
			<?php
			echo get_the_post_thumbnail(get_the_ID(), $thumb_size);
			?>
			<span class="mkdf-item-image-overlay"></span>
		</a>
		<a class="mkdf-item-image-overlay-icon" href="<?php echo esc_url(wp_get_attachment_url(get_post_thumbnail_id())); ?>" data-rel="prettyPhoto[pretty_photo_gallery]">
			<span class="icon_plus"></span>
		</a>
	</div>
	<div class="mkdf-item-text-holder-outer">
		<div class="mkdf-item-text-holder">
			<div class="mkdf-item-text-holder-inner">
				<<?php echo esc_attr($title_tag) ?> class="mkdf-item-title">
				<a href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($item_target); ?>">
					<?php echo esc_attr(get_the_title()); ?>
				</a>
				</<?php echo esc_attr($title_tag) ?>>
			</div>

			<?php if($show_excerpt == 'yes') : ?>

				<div class="mkdf-item-excerpt">
					<div class="mkdf-item-excerpt-inner">
						<?php the_excerpt(); ?>
					</div>
				</div>

			<?php endif; ?>
		<a class="mkdf-arrow-link" href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($item_target); ?>">
			<span class="mkdf-al-icon">
				<span class="icon-arrow-right-circle"></span>
			</span>
			<span class="mkdf-al-text"><?php esc_html_e('Learn More', 'mkd_core'); ?></span>

		</a>
		</div>
	</div>
</article>
<!--space for right ordering on the list- has to be here-->