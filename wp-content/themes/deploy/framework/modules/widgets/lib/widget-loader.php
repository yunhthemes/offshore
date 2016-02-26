<?php

if (!function_exists('deploy_mikado_register_widgets')) {

	function deploy_mikado_register_widgets() {

		$widgets = array(
			'DeployMikadoLatestPosts',
			'DeployMikadoSearchOpener',
			'DeployMikadoSideAreaOpener',
			'DeployMikadoStickySidebar',
			'MikadoHtmlDeployWidget'
		);

		if(deploy_mikado_is_wpml_installed()) {
			$widgets[] = 'DeployMikadoLanguageDropdown';
		}

		foreach ($widgets as $widget) {
			register_widget($widget);
		}

	}

}

add_action('widgets_init', 'deploy_mikado_register_widgets');