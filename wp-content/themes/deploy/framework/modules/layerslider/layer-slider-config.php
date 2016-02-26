<?php
	if(!function_exists('deploy_mikado_layerslider_overrides')) {
		/**
		 * Disables Layer Slider auto update box
		 */
		function deploy_mikado_layerslider_overrides() {
			$GLOBALS['lsAutoUpdateBox'] = false;
		}

		add_action('layerslider_ready', 'deploy_mikado_layerslider_overrides');
	}
?>