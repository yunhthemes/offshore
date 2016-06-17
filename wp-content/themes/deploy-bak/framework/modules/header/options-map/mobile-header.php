<?php

if ( ! function_exists('deploy_mikado_mobile_header_options_map') ) {

	function deploy_mikado_mobile_header_options_map() {

//		deploy_mikado_add_admin_page(array(
//			'slug'  => '_mobile_header',
//			'title' => 'Mobile Header',
//			'icon'  => 'fa fa-mobile'
//		));

	}

	add_action( 'deploy_mikado_options_map', 'deploy_mikado_mobile_header_options_map', 4);

}