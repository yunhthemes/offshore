<?php

if(!function_exists('deploy_mikado_search_body_class')) {
	/**
	 * Function that adds body classes for different search types
	 *
	 * @param $classes array original array of body classes
	 *
	 * @return array modified array of classes
	 */
	function deploy_mikado_search_body_class($classes) {

		if(is_active_widget(false, false, 'mkd_search_opener')) {

			$classes[] = 'mkdf-'.deploy_mikado_options()->getOptionValue('search_type');

			if(deploy_mikado_options()->getOptionValue('search_type') == 'fullscreen-search') {

				$classes[] = 'mkdf-'.deploy_mikado_options()->getOptionValue('search_animation');

			}

		}

		return $classes;

	}

	add_filter('body_class', 'deploy_mikado_search_body_class');
}

if(!function_exists('deploy_mikado_get_search')) {
	/**
	 * Loads search HTML based on search type option.
	 */
	function deploy_mikado_get_search() {

		if(deploy_mikado_active_widget(false, false, 'mkd_search_opener')) {

			$search_type = deploy_mikado_options()->getOptionValue('search_type');

			if($search_type == 'search-slides-from-window-top') {
				deploy_mikado_set_search_position_in_menu($search_type);
				if(deploy_mikado_is_responsive_on()) {
					deploy_mikado_set_search_position_mobile();
				}

				return;
			} elseif($search_type === 'search-dropdown') {
				deploy_mikado_set_dropdown_search_position();

				return;
			}

			deploy_mikado_load_search_template();

		}
	}

}

if(!function_exists('deploy_mikado_set_position_for_covering_search')) {
	/**
	 * Finds part of header where search template will be loaded
	 */
	function deploy_mikado_set_position_for_covering_search() {

		$containing_sidebar = deploy_mikado_active_widget(false, false, 'mkd_search_opener');

		foreach($containing_sidebar as $sidebar) {

			if(strpos($sidebar, 'top-bar') !== false) {
				add_action('deploy_mikado_after_header_top_html_open', 'deploy_mikado_load_search_template');
			} else if(strpos($sidebar, 'main-menu') !== false) {
				add_action('deploy_mikado_after_header_menu_area_html_open', 'deploy_mikado_load_search_template');
			} else if(strpos($sidebar, 'mobile-logo') !== false) {
				add_action('deploy_mikado_after_mobile_header_html_open', 'deploy_mikado_load_search_template');
			} else if(strpos($sidebar, 'logo') !== false) {
				add_action('deploy_mikado_after_header_logo_area_html_open', 'deploy_mikado_load_search_template');
			} else if(strpos($sidebar, 'sticky') !== false) {
				add_action('deploy_mikado_after_sticky_menu_html_open', 'deploy_mikado_load_search_template');
			}

		}

	}

}

if(!function_exists('deploy_mikado_set_search_position_in_menu')) {
	/**
	 * Finds part of header where search template will be loaded
	 */
	function deploy_mikado_set_search_position_in_menu($type) {

		add_action('deploy_mikado_after_header_menu_area_html_open', 'deploy_mikado_load_search_template');

	}
}

if(!function_exists('deploy_mikado_set_search_position_mobile')) {
	/**
	 * Hooks search template to mobile header
	 */
	function deploy_mikado_set_search_position_mobile() {

		add_action('deploy_mikado_after_mobile_header_html_open', 'deploy_mikado_load_search_template');

	}

}

if(!function_exists('deploy_mikado_set_dropdown_search_position')) {
    function deploy_mikado_set_dropdown_search_position() {
        add_action('deploy_mikado_after_search_opener', 'deploy_mikado_load_search_template');
    }
}

if(!function_exists('deploy_mikado_load_search_template')) {
	/**
	 * Loads HTML template with parameters
	 */
	function deploy_mikado_load_search_template() {
		$search_type = deploy_mikado_options()->getOptionValue('search_type');

		$search_icon       = '';
		$search_icon_close = '';
		if(deploy_mikado_options()->getOptionValue('search_icon_pack') !== '') {
			$search_icon       = deploy_mikado_icon_collections()->getSearchIcon(deploy_mikado_options()->getOptionValue('search_icon_pack'), true);
			$search_icon_close = deploy_mikado_icon_collections()->getSearchClose(deploy_mikado_options()->getOptionValue('search_icon_pack'), true);
		}

		$parameters = array(
			'search_in_grid'    => deploy_mikado_options()->getOptionValue('search_in_grid') == 'yes' ? true : false,
			'search_icon'       => $search_icon,
			'search_icon_close' => $search_icon_close
		);

		deploy_mikado_get_module_template_part('templates/types/'.$search_type, 'search', '', $parameters);

	}

}