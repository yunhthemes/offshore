<div <?php deploy_mikado_class_attribute($pricing_table_classes)?>>
	<div class="mkdf-price-table-inner">
		<div class="mkdf-price-table-whole-content">
			<ul>
				<?php if($has_icon) : ?>
					<li class="mkdf-table-image">
						<span class="mkdf-image-content">
							<span class="mkdf-image-content-inner">
								<?php if($show_image) : ?>
									<?php echo wp_get_attachment_image($image); ?>
								<?php else: ?>
									<?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack); ?>
								<?php endif; ?>
							</span>
						</span>
					</li>
				<?php endif; ?>
				<li class="mkdf-table-title">
					<span class="mkdf-title-content"><?php echo esc_html($title) ?></span>
				</li>
				<li class="mkdf-table-prices">
					<div class="mkdf-price-in-table">
						<sup class="mkdf-value"><?php echo esc_html($currency) ?></sup>
						<span class="mkdf-price"><?php echo esc_html($price)?></span>
						<span class="mkdf-mark"><?php echo esc_html($price_period)?></span>
					</div>
				</li>
				<li class="mkdf-table-content">
					<?php $content = preg_replace('#^<\/p>|<p>$#', '', $content); ?>
					<?php echo do_shortcode($content); ?>
				</li>
			</ul>
			<?php
			if($show_button == "yes" && $button_text !== ''){ ?>
				<div class="mkdf-table-button">
					<a href="<?php echo esc_attr($link)?>"><?php echo esc_html($button_text)?></a>
				</div>
			<?php } ?>
		</div>
	</div>
</div>
