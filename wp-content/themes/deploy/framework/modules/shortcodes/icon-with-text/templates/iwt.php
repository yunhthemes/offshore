<div <?php deploy_mikado_class_attribute($holder_classes); ?>>
	<div class="mkdf-iwt-icon-holder">
		<?php if(!empty($custom_icon)) : ?>
			<div class="mkdf-iwt-custom-icon-holder">
				<?php echo wp_get_attachment_image($custom_icon, 'full'); ?>

				<?php if(!empty($custom_hover_icon)) : ?>
					<?php echo wp_get_attachment_image($custom_hover_icon, 'full'); ?>
				<?php endif; ?>
			</div>

		<?php else: ?>
			<?php echo deploy_mikado_get_shortcode_module_template_part('templates/icon', 'icon-with-text', '', array('icon_parameters' => $icon_parameters)); ?>
		<?php endif; ?>
	</div>
	<div class="mkdf-iwt-content-holder" <?php deploy_mikado_inline_style($content_styles); ?>>
		<div class="mkdf-iwt-title-holder">
			<<?php echo esc_attr($title_tag); ?> <?php deploy_mikado_inline_style($title_styles); ?>>
				<?php if(!empty($link)) : ?>
					<a class="mkdf-anchor" href="<?php echo esc_url($link); ?>" <?php deploy_mikado_inline_attr($target, 'target'); ?>>
				<?php endif; ?>

				<?php echo esc_html($title); ?>

				<?php if(!empty($link)) : ?>
					</a>
				<?php endif; ?>

			</<?php echo esc_attr($title_tag); ?>>
	</div>
	<div class="mkdf-iwt-text-holder">
		<p <?php deploy_mikado_inline_style($text_styles); ?>><?php echo esc_html($text); ?></p>

		<?php if(!empty($link) && !empty($link_text)) : ?>
			<a class="mkdf-arrow-link" href="<?php echo esc_attr($link); ?>" <?php deploy_mikado_inline_attr($target, 'target'); ?>>
			<span class="mkdf-al-icon">
				<span class="icon-arrow-right-circle"></span>
			</span>
				<span class="mkdf-iwt-link"><?php echo esc_html($link_text); ?></span>
			</a>
		<?php endif; ?>
	</div>
</div>
</div>