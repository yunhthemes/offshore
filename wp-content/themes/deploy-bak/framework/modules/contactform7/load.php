<?php

if (deploy_mikado_contact_form_7_installed()) {
	include_once get_template_directory().'/framework/modules/contactform7/options-map/map.php';
	include_once get_template_directory().'/framework/modules/contactform7/custom-styles/contact-form.php';
	include_once get_template_directory().'/framework/modules/contactform7/contact-form-7-config.php';
}