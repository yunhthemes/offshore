<div class="mkdf-message  <?php echo esc_attr($message_classes)?>" <?php  echo deploy_mikado_get_inline_style($message_styles)?>>
	<div class="mkdf-message-inner">
		<?php		
		if($type == 'with_icon'){
			$icon_html = deploy_mikado_get_shortcode_module_template_part('templates/' . $type, 'message', '', $params);
			print $icon_html;
		}
		?>
		<a href="#" class="mkdf-close">
			<i class="q_font_simple_line_icon icon-close" <?php deploy_mikado_inline_style($close_icon_style);?>></i>
		</a>
		<div class="mkdf-message-text-holder">
			<div class="mkdf-message-text">
				<div class="mkdf-message-text-inner">
					<?php echo do_shortcode($content); ?>
				</div>
			</div>
		</div>
	</div>
</div>
