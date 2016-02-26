<div class="mkdf-elements-holder-item <?php echo esc_attr($elements_holder_item_class); ?>" <?php echo deploy_mikado_get_inline_attrs($elements_holder_item_data); ?> <?php echo deploy_mikado_get_inline_style($elements_holder_item_style); ?>>
	<div class="mkdf-elements-holder-item-inner">
		<div class="mkdf-elements-holder-item-content <?php echo esc_attr($elements_holder_item_content_class); ?>" <?php echo deploy_mikado_get_inline_style($elements_holder_item_content_style); ?>>
			<?php if(count($elements_holder_item_content_responsive) > 0){ ?>
				<style type="text/css" data-type="mkdf-elements-custom-padding" scoped>
					<?php if($elements_holder_item_content_responsive['item_padding_1024_1280'] !== ''){ ?>
					@media only screen and (min-width: 1024px) and (max-width: 1280px) {
						.mkdf-elements-holder .mkdf-elements-holder-item-content.<?php echo esc_attr($elements_holder_item_content_class); ?> {
							padding: <?php echo esc_attr($elements_holder_item_content_responsive['item_padding_1024_1280']); ?> !important;
						}
					}
					<?php } ?>
					<?php if($elements_holder_item_content_responsive['item_padding_768_1024'] !== ''){ ?>
					@media only screen and (min-width: 768px) and (max-width: 1024px) {
						.mkdf-elements-holder .mkdf-elements-holder-item-content.<?php echo esc_attr($elements_holder_item_content_class); ?> {
							padding: <?php echo esc_attr($elements_holder_item_content_responsive['item_padding_768_1024']); ?> !important;
						}
					}
					<?php } ?>
					<?php if($elements_holder_item_content_responsive['item_padding_600_768'] !== ''){ ?>
					@media only screen and (min-width: 600px) and (max-width: 768px) {
						.mkdf-elements-holder .mkdf-elements-holder-item-content.<?php echo esc_attr($elements_holder_item_content_class); ?> {
							padding: <?php echo esc_attr($elements_holder_item_content_responsive['item_padding_600_768']); ?> !important;
						}
					}
					<?php } ?>
					<?php if($elements_holder_item_content_responsive['item_padding_480_600'] !== ''){ ?>
					@media only screen and (min-width: 480px) and (max-width: 600px) {
						.mkdf-elements-holder .mkdf-elements-holder-item-content.<?php echo esc_attr($elements_holder_item_content_class); ?> {
							padding: <?php echo esc_attr($elements_holder_item_content_responsive['item_padding_480_600']); ?> !important;
						}
					}
					<?php } ?>
					<?php if($elements_holder_item_content_responsive['item_padding_480'] !== ''){ ?>
					@media only screen and (max-width: 480px) {
						.mkdf-elements-holder .mkdf-elements-holder-item-content.<?php echo esc_attr($elements_holder_item_content_class); ?> {
							padding: <?php echo esc_attr($elements_holder_item_content_responsive['item_padding_480']); ?> !important;
						}
					}
					<?php } ?>
				</style>
			<?php } ?>
			<?php echo do_shortcode($content); ?>
		</div>
	</div>
</div>