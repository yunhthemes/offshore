<?php
/**
 * Custom styles for Counter shortcode
 * Hooks to deploy_mikado_style_dynamic hook
 */

if (!function_exists('deploy_mikado_woo_single_style')) {

	function deploy_mikado_woo_single_style() {

        $styles = array();

		if (deploy_mikado_options()->getOptionValue('hide_product_info') === 'yes') {
			$styles['display'] = 'none';
		}

        $selector = array(
            '.single.single-product .product_meta'
        );

        echo deploy_mikado_dynamic_css($selector, $styles);

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_woo_single_style');

}

?>