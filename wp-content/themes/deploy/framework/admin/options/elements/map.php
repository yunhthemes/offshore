<?php

if ( ! function_exists('deploy_mikado_load_elements_map') ) {
	/**
	 * Add Elements option page for shortcodes
	 */
	function deploy_mikado_load_elements_map() {

		deploy_mikado_add_admin_page(
			array(
				'slug' => '_elements_page',
				'title' => 'Elements',
				'icon' => 'fa fa-star'
			)
		);

		do_action( 'deploy_mikado_options_elements_map' );

	}

	add_action('deploy_mikado_options_map', 'deploy_mikado_load_elements_map', 10);

}