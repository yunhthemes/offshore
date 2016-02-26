<?php

add_action('after_setup_theme', 'deploy_mikado_admin_map_init', 0);

function deploy_mikado_admin_map_init() {

    do_action('deploy_mikado_before_options_map');

    require_once get_template_directory().'/framework/admin/options/elements/map.php';
    require_once get_template_directory().'/framework/admin/options/fonts/map.php';
    require_once get_template_directory().'/framework/admin/options/general/map.php';
    require_once get_template_directory().'/framework/admin/options/page/map.php';
    require_once get_template_directory().'/framework/admin/options/content/map.php';
    require_once get_template_directory().'/framework/admin/options/sidebar/map.php';
    require_once get_template_directory().'/framework/admin/options/parallax/map.php';
    require_once get_template_directory().'/framework/admin/options/social/map.php';
    require_once get_template_directory().'/framework/admin/options/contentbottom/map.php';
    require_once get_template_directory().'/framework/admin/options/error404/map.php';
    require_once get_template_directory().'/framework/admin/options/reset/map.php';


    do_action('deploy_mikado_options_map');

    do_action('deploy_mikado_after_options_map');

}