<?php

//load lib
include_once get_template_directory().'/framework/modules/header/lib/header-functions.php';
include_once get_template_directory().'/framework/modules/header/lib/header-abstract.php';
include_once get_template_directory().'/framework/modules/header/lib/header-factory.php';
include_once get_template_directory().'/framework/modules/header/lib/header-connector.php';

//options
include_once get_template_directory().'/framework/modules/header/options-map/header-map.inc';
include_once get_template_directory().'/framework/modules/header/options-map/logo-map.php';
include_once get_template_directory().'/framework/modules/header/options-map/mobile-header.php';

//header types
include_once get_template_directory().'/framework/modules/header/types/header-standard.php';

include_once get_template_directory().'/framework/modules/header/functions.php';
include_once get_template_directory().'/framework/modules/header/filter-functions.php';
include_once get_template_directory().'/framework/modules/header/template-functions.php';
include_once get_template_directory().'/framework/modules/header/template-hooks.php';
include_once get_template_directory().'/framework/modules/header/widget-areas-functions.php';

//custom styles
include_once get_template_directory().'/framework/modules/header/custom-styles/header.inc';
include_once get_template_directory().'/framework/modules/header/custom-styles/mobile-header.php';