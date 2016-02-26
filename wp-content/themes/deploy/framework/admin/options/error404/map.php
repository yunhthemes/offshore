<?php

if ( ! function_exists('deploy_mikado_error_404_options_map') ) {

	function deploy_mikado_error_404_options_map() {

		deploy_mikado_add_admin_page(array(
			'slug' => '__404_error_page',
			'title' => '404 Error Page',
			'icon' => 'fa fa-exclamation-triangle'
		));

		$panel_404_options = deploy_mikado_add_admin_panel(array(
			'page' => '__404_error_page',
			'name'	=> 'panel_404_options',
			'title'	=> '404 Page Option'
		));

		deploy_mikado_add_admin_field(array(
			'parent' => $panel_404_options,
			'type' => 'text',
			'name' => '404_title',
			'default_value' => '',
			'label' => 'Title',
			'description' => 'Enter title for 404 page'
		));

		deploy_mikado_add_admin_field(array(
			'parent' => $panel_404_options,
			'type' => 'text',
			'name' => '404_text',
			'default_value' => '',
			'label' => 'Text',
			'description' => 'Enter text for 404 page'
		));

		deploy_mikado_add_admin_field(array(
			'parent' => $panel_404_options,
			'type' => 'text',
			'name' => '404_back_to_home',
			'default_value' => '',
			'label' => 'Back to Home Button Label',
			'description' => 'Enter label for "Back to Home" button'
		));

	}

	add_action( 'deploy_mikado_options_map', 'deploy_mikado_error_404_options_map', 15 );

}