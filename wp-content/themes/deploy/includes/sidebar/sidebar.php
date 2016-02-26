<?php

if(!function_exists('deploy_mikado_register_sidebars')) {
    /**
     * Function that registers theme's sidebars
     */
    function deploy_mikado_register_sidebars() {

        register_sidebar(array(
            'name' => 'Sidebar',
            'id' => 'sidebar',
            'description' => 'Default Sidebar',
            'before_widget' => '<div id="%1$s" class="widget %2$s">',
            'after_widget' => '</div>',
            'before_title' => '<div class="mkdf-widget-title"><h4>',
            'after_title' => '</h4></div>'
        ));

    }

    add_action('widgets_init', 'deploy_mikado_register_sidebars');
}

if(!function_exists('deploy_mikado_add_support_custom_sidebar')) {
    /**
     * Function that adds theme support for custom sidebars. It also creates deploy_mikado_sidebar object
     */
    function deploy_mikado_add_support_custom_sidebar() {
        add_theme_support('deploy_mikado_sidebar');
        if (get_theme_support('deploy_mikado_sidebar')) new DeployMikadoSidebar();
    }

    add_action('after_setup_theme', 'deploy_mikado_add_support_custom_sidebar');
}
