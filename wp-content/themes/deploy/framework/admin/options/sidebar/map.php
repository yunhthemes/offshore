<?php

if(!function_exists('deploy_mikado_sidebar_options_map')) {

	function deploy_mikado_sidebar_options_map() {

//		deploy_mikado_add_admin_page(
//			array(
//				'slug'  => '_sidebar_page',
//				'title' => 'Sidebar',
//				'icon'  => 'fa fa-bars'
//			)
//		);


	}

	add_action('deploy_mikado_options_map', 'deploy_mikado_sidebar_options_map', 8);

}