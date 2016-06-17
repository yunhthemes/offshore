<?php
/**
 * Counter shortcode template
 */
?>
<div <?php deploy_mikado_class_attribute($counter_classes); ?> <?php echo deploy_mikado_get_inline_style($counter_holder_styles); ?>>

	<div class="mkdf-counter-icon"><?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack); ?></div>

	<span class="mkdf-counter <?php echo esc_attr($type) ?>" <?php echo deploy_mikado_get_inline_style($counter_styles); ?>>
		<?php echo esc_attr($digit); ?>
	</span>
	<h4 class="mkdf-counter-title">
		<?php echo esc_attr($title); ?>
	</h4>
	<?php if ($text != "") { ?>
		<p class="mkdf-counter-text"><?php echo esc_html($text); ?></p>
	<?php } ?>

</div>