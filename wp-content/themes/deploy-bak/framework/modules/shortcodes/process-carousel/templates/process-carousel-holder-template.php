<div class="mkdf-process-carousel">
	<div class="mkdf-pc-holder clearfix">
		<div class="mkdf-pc-image-holder">
			<?php if(is_array($items_images_array)) : ?>
				<div class="mkdf-pc-image-slider">
					<?php foreach($items_images_array as $item_image) : ?>
						<div class="mkdf-pc-item-image" style="background-image: url(<?php echo esc_url(wp_get_attachment_url($item_image)); ?>)">
							<div class="mkdf-pc-item-actual-image">
								<?php echo wp_get_attachment_image($item_image, 'full'); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<div class="mkdf-pc-item-image-preload">
				<div class="mkdf-pulse-loader-holder">
					<div class="mkdf-pulse-loader"></div>
				</div>
			</div>
		</div>
		<div class="mkdf-pc-holder-inner">
			<div class="mkdf-pc-carousel-holder">
				<?php echo do_shortcode($content); ?>
			</div>
			<div class="mkdf-pc-navigation clearfix"></div>
		</div>
	</div>

</div>