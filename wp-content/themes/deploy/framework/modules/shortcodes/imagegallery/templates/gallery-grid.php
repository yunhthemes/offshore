<div class="mkdf-image-gallery">
	<div class="mkdf-image-gallery-grid clearfix <?php echo esc_html($columns); ?> <?php echo esc_html($gallery_classes); ?>">
		<?php foreach($images as $image) { ?>
			<div class="mkdf-gallery-image <?php echo esc_attr($border_image); ?> <?php echo esc_attr($hover_image); ?>">
				<?php if($has_link) : ?>
					<a href="<?php echo esc_url($image['image_link']) ?>" <?php echo deploy_mikado_get_inline_attrs($link_data); ?>>
				<?php endif; ?>

					<?php if(is_array($image_size) && count($image_size)) : ?>
						<?php echo deploy_mikado_generate_thumbnail($image['image_id'], null, $image_size[0], $image_size[1]); ?>
					<?php else: ?>
						<?php echo wp_get_attachment_image($image['image_id'], $image_size); ?>
					<?php endif; ?>

				<?php if($has_link) : ?>
					</a>
				<?php endif; ?>
			</div>
		<?php } ?>
	</div>
</div>