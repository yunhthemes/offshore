<div id="tab-<?php echo sanitize_title( $tab_title )?>" <?php echo deploy_mikado_get_inline_attrs($tab_data); ?> class="mkdf-tg-tab-container">
	<div class="mkdf-tg-gallery">
		<?php if(is_array($images)) : ?>

			<?php foreach($images as $image) : ?>

				<div class="mkdf-tg-gallery-item mkdf-tg-hover">
					<div class="mkdf-tg-gallery-item-inner">
						<a href="<?php echo esc_url(wp_get_attachment_url($image))?>" data-rel="prettyPhoto[tabbed_gallery_<?php echo sanitize_title($tab_title); ?>]">
							<?php if(is_array($image_size) && count($image_size)) : ?>
								<?php echo deploy_mikado_generate_thumbnail($image, null, $image_size[0], $image_size[1]); ?>
							<?php else: ?>
								<?php echo wp_get_attachment_image($image, $image_size); ?>
							<?php endif; ?>
							<div class="mkdf-tg-image-overlay">
								<div class="mkdf-tg-image-overlay-tb">
									<div class="mkdf-tg-image-overlay-tc">
										<span class="icon_plus"></span>
									</div>
								</div>
							</div>
						</a>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	</div>
</div>