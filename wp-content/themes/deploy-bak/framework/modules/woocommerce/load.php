<?php

include_once get_template_directory().'/framework/modules/woocommerce/woocommerce-functions.php';

if (deploy_mikado_is_woocommerce_installed()) {
	include_once get_template_directory().'/framework/modules/woocommerce/options-map/map.php';
	include_once get_template_directory().'/framework/modules/woocommerce/woocommerce-template-hooks.php';
	include_once get_template_directory().'/framework/modules/woocommerce/woocommerce-config.php';
	include_once get_template_directory().'/framework/modules/woocommerce/custom-styles/woocommerce.php';
	include_once get_template_directory().'/framework/modules/woocommerce/widgets/woocommerce-dropdown-cart.php';
}