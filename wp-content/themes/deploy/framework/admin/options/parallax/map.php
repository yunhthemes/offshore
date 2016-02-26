<?php

if(!function_exists('deploy_mikado_parallax_options_map')) {
	/**
	 * Parallax options page
	 */
	function deploy_mikado_parallax_options_map() {

//		deploy_mikado_add_admin_page(
//			array(
//				'slug' => '_parallax_page',
//				'title' => 'Parallax',
//				'icon' => 'fa fa-unsorted'
//			)
//		);

		$panel_parallax = deploy_mikado_add_admin_panel(
			array(
				'page'  => '_elements_page',
				'name'  => 'panel_parallax',
				'title' => 'Parallax'
			)
		);

		deploy_mikado_add_admin_field(array(
			'type'          => 'onoff',
			'name'          => 'parallax_on_off',
			'default_value' => 'off',
			'label'         => 'Parallax on touch devices',
			'description'   => 'Enabling this option will allow parallax on touch devices',
			'parent'        => $panel_parallax
		));

		deploy_mikado_add_admin_field(array(
			'type'          => 'text',
			'name'          => 'parallax_min_height',
			'default_value' => '400',
			'label'         => 'Parallax Min Height',
			'description'   => 'Set a minimum height for parallax images on small displays (phones, tablets, etc.)',
			'args'          => array(
				'col_width' => 3,
				'suffix'    => 'px'
			),
			'parent'        => $panel_parallax
		));

	}

	add_action('deploy_mikado_options_elements_map', 'deploy_mikado_parallax_options_map', 3);

}