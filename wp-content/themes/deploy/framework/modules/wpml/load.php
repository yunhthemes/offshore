<?php

if (deploy_mikado_is_wpml_installed()) {
	include_once get_template_directory().'/framework/modules/wpml/wpml-functions.php';
	include_once get_template_directory().'/framework/modules/wpml/widgets/language-dropdown.php';
}