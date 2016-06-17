<?php

//define constants
define('MIKADO_ROOT', get_template_directory_uri());
define('MIKADO_ROOT_DIR', get_template_directory());
define('MIKADO_ASSETS_ROOT', get_template_directory_uri().'/assets');
define('MIKADO_ASSETS_ROOT_DIR', get_template_directory().'/assets');
define('MIKADO_FRAMEWORK_ROOT', get_template_directory_uri().'/framework');
define('MIKADO_FRAMEWORK_ROOT_DIR', get_template_directory().'/framework');
define('MIKADO_FRAMEWORK_MODULES_ROOT_DIR', get_template_directory().'/framework/modules');
define('MIKADO_THEME_ENV', 'prod');

//include necessary files
include_once get_template_directory().'/framework/mkd-framework.php';
include_once get_template_directory().'/includes/nav-menu/mkd-menu.php';
include_once get_template_directory().'/includes/sidebar/mkd-custom-sidebar.php';
include_once get_template_directory().'/includes/mkdf-related-posts.php';
include_once get_template_directory().'/includes/mkd-options-helper-functions.php';
include_once get_template_directory().'/includes/sidebar/sidebar.php';
require_once get_template_directory().'/includes/plugins/class-tgm-plugin-activation.inc';
include_once get_template_directory().'/includes/plugins/plugins-activation.php';
include_once get_template_directory().'/assets/custom-styles/general-custom-styles.php';
include_once get_template_directory().'/assets/custom-styles/general-custom-styles-responsive.php';

if(!is_admin()) {
    include_once get_template_directory().'/includes/mkd-body-class-functions.php';
    include_once get_template_directory().'/includes/mkd-loading-spinners.php';
}