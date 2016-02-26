<?php

if(!function_exists('deploy_mikado_general_options_map')) {
    /**
     * General options page
     */
    function deploy_mikado_general_options_map() {

        deploy_mikado_add_admin_page(
            array(
                'slug'  => '',
                'title' => 'General',
                'icon'  => 'fa fa-institution'
            )
        );

	    $panel_logo = deploy_mikado_add_admin_panel(
		    array(
			    'page' => '',
			    'name' => 'panel_logo',
			    'title' => 'Branding'
		    )
	    );

	    deploy_mikado_add_admin_field(
		    array(
			    'parent' => $panel_logo,
			    'type' => 'yesno',
			    'name' => 'hide_logo',
			    'default_value' => 'no',
			    'label' => 'Hide Logo',
			    'description' => 'Enabling this option will hide logo image',
			    'args' => array(
				    "dependence" => true,
				    "dependence_hide_on_yes" => "#mkdf_hide_logo_container",
				    "dependence_show_on_yes" => ""
			    )
		    )
	    );

	    $hide_logo_container = deploy_mikado_add_admin_container(
		    array(
			    'parent' => $panel_logo,
			    'name' => 'hide_logo_container',
			    'hidden_property' => 'hide_logo',
			    'hidden_value' => 'yes'
		    )
	    );

	    deploy_mikado_add_admin_field(
		    array(
			    'name' => 'logo_image',
			    'type' => 'image',
			    'default_value' => MIKADO_ASSETS_ROOT."/img/logo.png",
			    'label' => 'Logo Image - Default',
			    'description' => 'Choose a default logo image to display ',
			    'parent' => $hide_logo_container
		    )
	    );

	    deploy_mikado_add_admin_field(
		    array(
			    'name' => 'logo_image_dark',
			    'type' => 'image',
			    'default_value' => MIKADO_ASSETS_ROOT."/img/logo.png",
			    'label' => 'Logo Image - Dark',
			    'description' => 'Choose a default logo image to display ',
			    'parent' => $hide_logo_container
		    )
	    );

	    deploy_mikado_add_admin_field(
		    array(
			    'name' => 'logo_image_light',
			    'type' => 'image',
			    'default_value' => MIKADO_ASSETS_ROOT."/img/logo_white.png",
			    'label' => 'Logo Image - Light',
			    'description' => 'Choose a default logo image to display ',
			    'parent' => $hide_logo_container
		    )
	    );

	    deploy_mikado_add_admin_field(
		    array(
			    'name' => 'logo_image_sticky',
			    'type' => 'image',
			    'default_value' => MIKADO_ASSETS_ROOT."/img/logo_white.png",
			    'label' => 'Logo Image - Sticky',
			    'description' => 'Choose a default logo image to display ',
			    'parent' => $hide_logo_container
		    )
	    );

	    deploy_mikado_add_admin_field(
		    array(
			    'name' => 'logo_image_mobile',
			    'type' => 'image',
			    'default_value' => MIKADO_ASSETS_ROOT."/img/logo.png",
			    'label' => 'Logo Image - Mobile',
			    'description' => 'Choose a default logo image to display ',
			    'parent' => $hide_logo_container
		    )
	    );

        $panel_design_style = deploy_mikado_add_admin_panel(
            array(
                'page'  => '',
                'name'  => 'panel_design_style',
                'title' => 'Appearance'
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'google_fonts',
                'type'          => 'font',
                'default_value' => '-1',
                'label'         => 'Font Family',
                'description'   => 'Choose a default Google font for your site',
                'parent'        => $panel_design_style
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'additional_google_fonts',
                'type'          => 'yesno',
                'default_value' => 'no',
                'label'         => 'Additional Google Fonts',
                'description'   => '',
                'parent'        => $panel_design_style,
                'args'          => array(
                    "dependence"             => true,
                    "dependence_hide_on_yes" => "",
                    "dependence_show_on_yes" => "#mkdf_additional_google_fonts_container"
                )
            )
        );

        $additional_google_fonts_container = deploy_mikado_add_admin_container(
            array(
                'parent'          => $panel_design_style,
                'name'            => 'additional_google_fonts_container',
                'hidden_property' => 'additional_google_fonts',
                'hidden_value'    => 'no'
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'additional_google_font1',
                'type'          => 'font',
                'default_value' => '-1',
                'label'         => 'Font Family',
                'description'   => 'Choose additional Google font for your site',
                'parent'        => $additional_google_fonts_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'additional_google_font2',
                'type'          => 'font',
                'default_value' => '-1',
                'label'         => 'Font Family',
                'description'   => 'Choose additional Google font for your site',
                'parent'        => $additional_google_fonts_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'additional_google_font3',
                'type'          => 'font',
                'default_value' => '-1',
                'label'         => 'Font Family',
                'description'   => 'Choose additional Google font for your site',
                'parent'        => $additional_google_fonts_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'additional_google_font4',
                'type'          => 'font',
                'default_value' => '-1',
                'label'         => 'Font Family',
                'description'   => 'Choose additional Google font for your site',
                'parent'        => $additional_google_fonts_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'additional_google_font5',
                'type'          => 'font',
                'default_value' => '-1',
                'label'         => 'Font Family',
                'description'   => 'Choose additional Google font for your site',
                'parent'        => $additional_google_fonts_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'first_color',
                'type'        => 'color',
                'label'       => 'First Main Color',
                'description' => 'Choose the most dominant theme color. Default color is #ff1d4d',
                'parent'      => $panel_design_style
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'page_background_color',
                'type'        => 'color',
                'label'       => 'Page Background Color',
                'description' => 'Choose the background color for page content. Default color is #ffffff',
                'parent'      => $panel_design_style
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'selection_color',
                'type'        => 'color',
                'label'       => 'Text Selection Color',
                'description' => 'Choose the color users see when selecting text',
                'parent'      => $panel_design_style
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'boxed',
                'type'          => 'yesno',
                'default_value' => 'no',
                'label'         => 'Boxed Layout',
                'description'   => '',
                'parent'        => $panel_design_style,
                'args'          => array(
                    "dependence"             => true,
                    "dependence_hide_on_yes" => "",
                    "dependence_show_on_yes" => "#mkdf_boxed_container"
                )
            )
        );

        $boxed_container = deploy_mikado_add_admin_container(
            array(
                'parent'          => $panel_design_style,
                'name'            => 'boxed_container',
                'hidden_property' => 'boxed',
                'hidden_value'    => 'no'
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'page_background_color_in_box',
                'type'        => 'color',
                'label'       => 'Page Background Color',
                'description' => 'Choose the page background color outside box.',
                'parent'      => $boxed_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'boxed_background_image',
                'type'        => 'image',
                'label'       => 'Background Image',
                'description' => 'Choose an image to be displayed in background',
                'parent'      => $boxed_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'boxed_pattern_background_image',
                'type'        => 'image',
                'label'       => 'Background Pattern',
                'description' => 'Choose an image to be used as background pattern',
                'parent'      => $boxed_container
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'boxed_background_image_attachment',
                'type'          => 'select',
                'default_value' => 'fixed',
                'label'         => 'Background Image Attachment',
                'description'   => 'Choose background image attachment',
                'parent'        => $boxed_container,
                'options'       => array(
                    'fixed'  => 'Fixed',
                    'scroll' => 'Scroll'
                )
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'initial_content_width',
                'type'          => 'select',
                'default_value' => 'grid-1300',
                'label'         => 'Initial Width of Content',
                'description'   => 'Choose the initial width of content which is in grid (Applies to pages set to "Default Template" and rows set to "In Grid"',
                'parent'        => $panel_design_style,
                'options'       => array(
                    ""          => "1100px",
                    "grid-1300" => "1300px- default",
                    "grid-1200" => "1200px",
                    "grid-1000" => "1000px",
                    "grid-800"  => "800px"
                )
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'preload_pattern_image',
                'type'        => 'image',
                'label'       => 'Preload Pattern Image',
                'description' => 'Choose preload pattern image to be displayed until images are loaded ',
                'parent'      => $panel_design_style
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'element_appear_amount',
                'type'        => 'text',
                'label'       => 'Element Appearance',
                'description' => 'For animated elements, set distance (related to browser bottom) to start the animation',
                'parent'      => $panel_design_style,
                'args'        => array(
                    'col_width' => 2,
                    'suffix'    => 'px'
                )
            )
        );

        $panel_settings = deploy_mikado_add_admin_panel(
            array(
                'page'  => '',
                'name'  => 'panel_settings',
                'title' => 'Behavior'
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'smooth_scroll',
                'type'          => 'yesno',
                'default_value' => 'no',
                'label'         => 'Smooth Scroll',
                'description'   => 'Enabling this option will perform a smooth scrolling effect on every page (except on Mac and touch devices)',
                'parent'        => $panel_settings
            )
        );

	    deploy_mikado_add_admin_field(
		    array(
			    'name'          => 'smooth_page_transitions',
			    'type'          => 'yesno',
			    'default_value' => 'no',
			    'label'         => 'Smooth Page Transitions',
			    'description'   => 'Enabling this option will perform a smooth transition between pages when clicking on links.',
			    'parent'        => $panel_settings,
			    'args'          => array(
				    'dependence' => true,
				    'dependence_hide_on_yes' => '',
				    'dependence_show_on_yes' => '#mkdf_page_transitions_container'
			    )
		    )
	    );

	    $page_transitions_container = deploy_mikado_add_admin_container(
		    array(
			    'parent'            => $panel_settings,
			    'name'              => 'page_transitions_container',
			    'hidden_property'   => 'smooth_page_transitions',
			    'hidden_value'      => 'no'
		    )
	    );

	    deploy_mikado_add_admin_field(
		    array(
			    'name'          => 'smooth_pt_bgnd_color',
			    'type'          => 'color',
			    'label'         => 'Page Loader Background Color',
			    'parent'        => $page_transitions_container
		    )
	    );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'elements_animation_on_touch',
                'type'          => 'yesno',
                'default_value' => 'no',
                'label'         => 'Elements Animation on Mobile/Touch Devices',
                'description'   => 'Enabling this option will allow elements (shortcodes) to animate on mobile / touch devices',
                'parent'        => $panel_settings
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'show_back_button',
                'type'          => 'yesno',
                'default_value' => 'yes',
                'label'         => 'Show "Back To Top Button"',
                'description'   => 'Enabling this option will display a Back to Top button on every page',
                'parent'        => $panel_settings
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'          => 'responsiveness',
                'type'          => 'yesno',
                'default_value' => 'yes',
                'label'         => 'Responsiveness',
                'description'   => 'Enabling this option will make all pages responsive',
                'parent'        => $panel_settings
            )
        );

        $panel_custom_code = deploy_mikado_add_admin_panel(
            array(
                'page'  => '',
                'name'  => 'panel_custom_code',
                'title' => 'Custom Code'
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'custom_css',
                'type'        => 'textarea',
                'label'       => 'Custom CSS',
                'description' => 'Enter your custom CSS here',
                'parent'      => $panel_custom_code
            )
        );

        deploy_mikado_add_admin_field(
            array(
                'name'        => 'custom_js',
                'type'        => 'textarea',
                'label'       => 'Custom JS',
                'description' => 'Enter your custom Javascript here',
                'parent'      => $panel_custom_code
            )
        );
    }

    add_action('deploy_mikado_options_map', 'deploy_mikado_general_options_map', 1);

}