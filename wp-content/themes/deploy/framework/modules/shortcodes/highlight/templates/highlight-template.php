<?php
/**
 * Highlight shortcode template
 */
?>

<span class="mkdf-highlight" <?php deploy_mikado_inline_style($highlight_style);?>>
	<?php echo esc_html($content);?>
</span>