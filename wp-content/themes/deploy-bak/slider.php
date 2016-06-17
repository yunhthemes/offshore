<?php
$slider_shortcode = get_post_meta(deploy_mikado_get_page_id(), 'mkdf_page_slider_meta', true);
if (!empty($slider_shortcode)) { ?>
	<div class="mkdf-slider">
		<div class="mkdf-slider-inner">
			<?php echo do_shortcode(wp_kses_post($slider_shortcode)); // XSS OK ?>
		</div>
	</div>
<?php } ?>