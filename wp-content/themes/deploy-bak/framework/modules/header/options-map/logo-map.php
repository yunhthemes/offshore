<?php

if ( ! function_exists('deploy_mikado_logo_options_map') ) {

	function deploy_mikado_logo_options_map() {

//		deploy_mikado_add_admin_page(
//			array(
//				'slug' => '_logo_page',
//				'title' => 'Logo',
//				'icon' => 'fa fa-coffee'
//			)
//		);



	}

	add_action( 'deploy_mikado_options_map', 'deploy_mikado_logo_options_map', 2);

}