<?php
/**
 * Blockquote shortcode template
 */
?>

<blockquote class="mkdf-blockquote-shortcode" <?php deploy_mikado_inline_style($blockquote_style); ?>>
	<span class="mkdf-blockquote-text"><?php echo esc_attr($text); ?></span>
</blockquote>