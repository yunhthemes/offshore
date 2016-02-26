<?php
if (!function_exists('deploy_mikado_register_side_area_sidebar')) {
	/**
	 * Register side area sidebar
	 */
	function deploy_mikado_register_side_area_sidebar() {

		register_sidebar(array(
			'name' => 'Side Area',
			'id' => 'sidearea', //TODO Change name of sidebar
			'description' => 'Side Area',
			'before_widget' => '<div id="%1$s" class="widget mkdf-sidearea %2$s">',
			'after_widget' => '</div>',
			'before_title' => '<h4 class="mkdf-sidearea-widget-title">',
			'after_title' => '</h4>'
		));

	}

	add_action('widgets_init', 'deploy_mikado_register_side_area_sidebar');

}

if(!function_exists('deploy_mikado_side_menu_body_class')) {
    /**
     * Function that adds body classes for different side menu styles
     *
     * @param $classes array original array of body classes
     *
     * @return array modified array of classes
     */
    function deploy_mikado_side_menu_body_class($classes) {

		if (is_active_widget( false, false, 'mkdf_side_area_opener' )) {

			if (deploy_mikado_options()->getOptionValue('side_area_type')) {

				$classes[] = 'mkdf-' . deploy_mikado_options()->getOptionValue('side_area_type');

				if (deploy_mikado_options()->getOptionValue('side_area_type') === 'side-menu-slide-with-content') {

					$classes[] = 'mkdf-' . deploy_mikado_options()->getOptionValue('side_area_slide_with_content_width');

				}

        	}

		}

		return $classes;

    }

    add_filter('body_class', 'deploy_mikado_side_menu_body_class');
}


if(!function_exists('deploy_mikado_get_side_area')) {
	/**
	 * Loads side area HTML
	 */
	function deploy_mikado_get_side_area() {

		if (is_active_widget( false, false, 'mkdf_side_area_opener' )) {

			$parameters = array(
				'show_side_area_title' => deploy_mikado_options()->getOptionValue('side_area_title') !== '' ? true : false, //Dont show title if empty
			);

			deploy_mikado_get_module_template_part('templates/sidearea', 'sidearea', '', $parameters);

		}

	}

}

if (!function_exists('deploy_mikado_get_side_area_title')) {
	/**
	 * Loads side area title HTML
	 */
	function deploy_mikado_get_side_area_title() {

		$parameters = array(
			'side_area_title' => deploy_mikado_options()->getOptionValue('side_area_title')
		);

		deploy_mikado_get_module_template_part('templates/parts/title', 'sidearea', '', $parameters);

	}
}