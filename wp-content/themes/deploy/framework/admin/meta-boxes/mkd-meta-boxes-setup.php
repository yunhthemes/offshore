<?php

add_action('after_setup_theme', 'deploy_mikado_meta_boxes_map_init', 1);
function deploy_mikado_meta_boxes_map_init() {
    /**
    * Loades all meta-boxes by going through all folders that are placed directly in meta-boxes folder
    * and loads map.php file in each.
    *
    * @see http://php.net/manual/en/function.glob.php
    */

    do_action('deploy_mikado_before_meta_boxes_map');

	global $deploy_mikado_options;
	global $deploy_mikado_framework;

    foreach(glob(get_template_directory().'/framework/admin/meta-boxes/*/map.php') as $meta_box_load) {
        include_once $meta_box_load;
    }

	do_action('deploy_mikado_meta_boxes_map');

	do_action('deploy_mikado_after_meta_boxes_map');
}