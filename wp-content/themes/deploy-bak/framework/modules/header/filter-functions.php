<?php

if(!function_exists('deploy_mikado_header_class')) {
	/**
	 * Function that adds class to header based on theme options
	 *
	 * @param array array of classes from main filter
	 *
	 * @return array array of classes with added header class
	 */
	function deploy_mikado_header_class($classes) {
		$header_type = deploy_mikado_get_meta_field_intersect('header_type', deploy_mikado_get_page_id());

		$classes[] = 'mkdf-'.$header_type;

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_header_class');
}

if(!function_exists('deploy_mikado_header_behaviour_class')) {
	/**
	 * Function that adds behaviour class to header based on theme options
	 *
	 * @param array array of classes from main filter
	 *
	 * @return array array of classes with added behaviour class
	 */
	function deploy_mikado_header_behaviour_class($classes) {

		$classes[] = 'mkdf-'.deploy_mikado_options()->getOptionValue('header_behaviour');

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_header_behaviour_class');
}

if(!function_exists('deploy_mikado_menu_item_icon_position_class')) {
	/**
	 * Function that adds menu item icon position class to header based on theme options
	 *
	 * @param array array of classes from main filter
	 *
	 * @return array array of classes with added menu item icon position class
	 */
	function deploy_mikado_menu_item_icon_position_class($classes) {

		if(deploy_mikado_options()->getOptionValue('menu_item_icon_position') == 'top') {
			$classes[] = 'mkdf-menu-with-large-icons';
		}

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_menu_item_icon_position_class');
}

if(!function_exists('deploy_mikado_mobile_header_class')) {
	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_mobile_header_class($classes) {
		$classes[] = 'mkdf-default-mobile-header';

		$classes[] = 'mkdf-sticky-up-mobile-header';

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_mobile_header_class');
}

if(!function_exists('deploy_mikado_menu_dropdown_appearance')) {
	/**
	 * Function that adds menu dropdown appearance class to body tag
	 *
	 * @param array array of classes from main filter
	 *
	 * @return array array of classes with added menu dropdown appearance class
	 */
	function deploy_mikado_menu_dropdown_appearance($classes) {

		if(deploy_mikado_options()->getOptionValue('menu_dropdown_appearance') !== 'default') {
			$classes[] = 'mkdf-'.deploy_mikado_options()->getOptionValue('menu_dropdown_appearance');
		}

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_menu_dropdown_appearance');
}

if(!function_exists('deploy_mikado_header_skin_class')) {

	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_header_skin_class($classes) {

		$id = deploy_mikado_get_page_id();

		if(get_post_meta($id, 'mkdf_header_style_meta', true) !== '') {
			$classes[] = 'mkdf-'.get_post_meta($id, 'mkdf_header_style_meta', true);
		} else if(deploy_mikado_options()->getOptionValue('header_style') !== '') {
			$classes[] = 'mkdf-'.deploy_mikado_options()->getOptionValue('header_style');
		}

		return $classes;

	}

	add_filter('body_class', 'deploy_mikado_header_skin_class');

}

if(!function_exists('deploy_mikado_header_scroll_style_class')) {

	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_header_scroll_style_class($classes) {

		if(deploy_mikado_get_meta_field_intersect('enable_header_style_on_scroll') == 'yes') {
			$classes[] = 'mkdf-header-style-on-scroll';
		}

		return $classes;

	}

	add_filter('body_class', 'deploy_mikado_header_scroll_style_class');

}

if(!function_exists('deploy_mikado_header_global_js_var')) {
	/**
	 * @param $global_variables
	 *
	 * @return mixed
	 */
	function deploy_mikado_header_global_js_var($global_variables) {

		$global_variables['mkdfTopBarHeight']                   = deploy_mikado_get_top_bar_height();
		$global_variables['mkdfStickyHeaderHeight']             = deploy_mikado_get_sticky_header_height();
		$global_variables['mkdfStickyHeaderTransparencyHeight'] = deploy_mikado_get_sticky_header_height_of_complete_transparency();

		return $global_variables;
	}

	add_filter('deploy_mikado_js_global_variables', 'deploy_mikado_header_global_js_var');
}

if(!function_exists('deploy_mikado_header_per_page_js_var')) {
	/**
	 * @param $perPageVars
	 *
	 * @return mixed
	 */
	function deploy_mikado_header_per_page_js_var($perPageVars) {
		$id = deploy_mikado_get_page_id();

		$perPageVars['mkdfStickyScrollAmount']           = deploy_mikado_get_sticky_scroll_amount();
		$perPageVars['mkdfStickyScrollAmountFullScreen'] = get_post_meta($id, 'mkdf_scroll_amount_for_sticky_fullscreen_meta', true) === 'yes';

		return $perPageVars;
	}

	add_filter('deploy_mikado_per_page_js_vars', 'deploy_mikado_header_per_page_js_var');
}

if(!function_exists('deploy_mikado_header_bottom_border_class')) {
	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_header_bottom_border_class($classes) {
		$id = deploy_mikado_get_page_id();

		$enable_boder = get_post_meta($id, 'mkdf_menu_area_bottom_border_enable_header_standard_meta', true) == 'yes';
		if($enable_boder) {
			$classes[] = 'mkdf-header-standard-border-enable';
		}

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_header_bottom_border_class');
}

if(!function_exists('deploy_mikado_header_in_grid_class')) {
	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_header_in_grid_class($classes) {
		$header_in_grid = deploy_mikado_options()->getOptionValue('menu_area_in_grid_header_standard') === 'yes';

		if($header_in_grid) {
			$classes[] = 'mkdf-header-standard-in-grid';
		} else {
			$classes[] = 'mkdf-header-standard-full-width';
		}

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_header_in_grid_class');
}

if(!function_exists('deploy_mikado_full_width_wide_menu_class')) {
	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_full_width_wide_menu_class($classes) {
		if(deploy_mikado_options()->getOptionValue('enable_wide_menu_background') === 'yes') {
			$classes[] = 'mkdf-full-width-wide-menu';
		}

		return $classes;
	}

	add_filter('body_class', 'deploy_mikado_full_width_wide_menu_class');
}

if(!function_exists('mkdf_top_bar_classes')) {
	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function mkdf_top_bar_classes($classes) {
		$id                     = deploy_mikado_get_page_id();
		$top_bar_border_enabled = get_post_meta($id, 'mkdf_top_bar_border_enable_meta', true);

		if($top_bar_border_enabled === 'yes') {
			$classes[] = 'mkdf-top-bar-border-enabled';
		}

		return $classes;
	}

	add_filter('body_class', 'mkdf_top_bar_classes');
}

if(!function_exists('deploy_mikado_get_top_bar_styles')) {
	/**
	 * Sets per page styles for header top bar
	 *
	 * @param $styles
	 *
	 * @return array
	 */
	function deploy_mikado_get_top_bar_styles($styles) {
		$id            = deploy_mikado_get_page_id();
		$class_prefix  = deploy_mikado_get_unique_page_class();
		$top_bar_style = array();

		$top_bar_bg_color     = get_post_meta($id, 'mkdf_top_bar_background_color_meta', true);
		$enable_bottom_border = get_post_meta($id, 'mkdf_top_bar_border_enable_meta', true) === 'yes';

		$top_bar_selector = array(
			$class_prefix.' .mkdf-top-bar'
		);

		if($top_bar_bg_color !== '') {
			$top_bar_transparency = get_post_meta($id, 'mkdf_top_bar_background_transparency_meta', true);
			if($top_bar_transparency === '') {
				$top_bar_transparency = 1;
			}

			$top_bar_style['background-color'] = deploy_mikado_rgba_color($top_bar_bg_color, $top_bar_transparency);
		}

		if($enable_bottom_border) {
			$bottom_border_color = get_post_meta($id, 'mkdf_top_bar_border_color_meta', true);

			if($bottom_border_color !== '') {
				$border_transparency = get_post_meta($id, 'mkdf_top_bar_border_color_transparency_meta', true);
				if($border_transparency === '') {
					$border_transparency = 1;
				}

				$top_bar_style['border-bottom-color'] = deploy_mikado_rgba_color($bottom_border_color, $border_transparency);
			}
		}

		$styles[] = deploy_mikado_dynamic_css($top_bar_selector, $top_bar_style);

		return $styles;
	}

	add_filter('deploy_mikado_add_page_custom_style', 'deploy_mikado_get_top_bar_styles');
}

if(!function_exists('mkdf_header_disable_box_shadow_class')) {
	/**
	 * Adds class to body when page option for disabling header box shadow is enabled
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function mkdf_header_disable_box_shadow_class($classes) {
		if(deploy_mikado_options()->getOptionValue('header_type') === 'header-standard') {
			$id = deploy_mikado_get_page_id();

			$disable_box_shadow = get_post_meta($id, 'mkdf_menu_area_bottom_disable_box_shadow_header_standard_meta', true);

			if($disable_box_shadow === 'yes') {
				$classes[] = 'mkdf-header-standard-no-shadow';
			}
		}

		return $classes;
	}

	add_action('body_class', 'mkdf_header_disable_box_shadow_class');
}