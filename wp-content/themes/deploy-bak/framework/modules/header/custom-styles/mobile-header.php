<?php

if(!function_exists('deploy_mikado_mobile_header_general_styles')) {
    /**
     * Generates general custom styles for mobile header
     */
    function deploy_mikado_mobile_header_general_styles() {
        $mobile_header_styles = array();
        if(deploy_mikado_options()->getOptionValue('mobile_header_height') !== '') {
            $mobile_header_styles['height'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_header_height')).'px';
        }

        if(deploy_mikado_options()->getOptionValue('mobile_header_background_color')) {
            $mobile_header_styles['background-color'] = deploy_mikado_options()->getOptionValue('mobile_header_background_color');
        }

        echo deploy_mikado_dynamic_css('.mkdf-mobile-header .mkdf-mobile-header-inner', $mobile_header_styles);
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_mobile_header_general_styles');
}

if(!function_exists('deploy_mikado_mobile_navigation_styles')) {
    /**
     * Generates styles for mobile navigation
     */
    function deploy_mikado_mobile_navigation_styles() {
        $mobile_nav_styles = array();
        if(deploy_mikado_options()->getOptionValue('mobile_menu_background_color')) {
            $mobile_nav_styles['background-color'] = deploy_mikado_options()->getOptionValue('mobile_menu_background_color');
        }

        echo deploy_mikado_dynamic_css('.mkdf-mobile-header .mkdf-mobile-nav', $mobile_nav_styles);

        $mobile_nav_item_styles = array();
        if(deploy_mikado_options()->getOptionValue('mobile_menu_separator_color') !== '') {
            $mobile_nav_item_styles['border-bottom-color'] = deploy_mikado_options()->getOptionValue('mobile_menu_separator_color');
        }

        if(deploy_mikado_options()->getOptionValue('mobile_text_color') !== '') {
            $mobile_nav_item_styles['color'] = deploy_mikado_options()->getOptionValue('mobile_text_color');
        }

        if(deploy_mikado_is_font_option_valid(deploy_mikado_options()->getOptionValue('mobile_font_family'))) {
            $mobile_nav_item_styles['font-family'] = deploy_mikado_get_formatted_font_family(deploy_mikado_options()->getOptionValue('mobile_font_family'));
        }

        if(deploy_mikado_options()->getOptionValue('mobile_font_size') !== '') {
            $mobile_nav_item_styles['font-size'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_font_size')).'px';
        }

        if(deploy_mikado_options()->getOptionValue('mobile_line_height') !== '') {
            $mobile_nav_item_styles['line-height'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_line_height')).'px';
        }

        if(deploy_mikado_options()->getOptionValue('mobile_text_transform') !== '') {
            $mobile_nav_item_styles['text-transform'] = deploy_mikado_options()->getOptionValue('mobile_text_transform');
        }

        if(deploy_mikado_options()->getOptionValue('mobile_font_style') !== '') {
            $mobile_nav_item_styles['font-style'] = deploy_mikado_options()->getOptionValue('mobile_font_style');
        }

        if(deploy_mikado_options()->getOptionValue('mobile_font_weight') !== '') {
            $mobile_nav_item_styles['font-weight'] = deploy_mikado_options()->getOptionValue('mobile_font_weight');
        }

        $mobile_nav_item_selector = array(
            '.mkdf-mobile-header .mkdf-mobile-nav a',
            '.mkdf-mobile-header .mkdf-mobile-nav h4'
        );

        echo deploy_mikado_dynamic_css($mobile_nav_item_selector, $mobile_nav_item_styles);

        $mobile_nav_item_hover_styles = array();
        if(deploy_mikado_options()->getOptionValue('mobile_text_hover_color') !== '') {
            $mobile_nav_item_hover_styles['color'] = deploy_mikado_options()->getOptionValue('mobile_text_hover_color');
        }

        $mobile_nav_item_selector_hover = array(
            '.mkdf-mobile-header .mkdf-mobile-nav a:hover',
            '.mkdf-mobile-header .mkdf-mobile-nav h4:hover'
        );

        echo deploy_mikado_dynamic_css($mobile_nav_item_selector_hover, $mobile_nav_item_hover_styles);
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_mobile_navigation_styles');
}

if(!function_exists('deploy_mikado_mobile_logo_styles')) {
    /**
     * Generates styles for mobile logo
     */
    function deploy_mikado_mobile_logo_styles() {
        if(deploy_mikado_options()->getOptionValue('mobile_logo_height') !== '') { ?>
            @media only screen and (max-width: 1000px) {
            <?php echo deploy_mikado_dynamic_css(
                '.mkdf-mobile-header .mkdf-mobile-logo-wrapper a',
                array('height' => deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_logo_height')).'px !important')
            ); ?>
            }
        <?php }

        if(deploy_mikado_options()->getOptionValue('mobile_logo_height_phones') !== '') { ?>
            @media only screen and (max-width: 480px) {
            <?php echo deploy_mikado_dynamic_css(
                '.mkdf-mobile-header .mkdf-mobile-logo-wrapper a',
                array('height' => deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_logo_height_phones')).'px !important')
            ); ?>
            }
        <?php }

        if(deploy_mikado_options()->getOptionValue('mobile_header_height') !== '') {
            $max_height = intval(deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_header_height')) * 0.9).'px';
            echo deploy_mikado_dynamic_css('.mkdf-mobile-header .mkdf-mobile-logo-wrapper a', array('max-height' => $max_height));
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_mobile_logo_styles');
}

if(!function_exists('deploy_mikado_mobile_icon_styles')) {
    /**
     * Generates styles for mobile icon opener
     */
    function deploy_mikado_mobile_icon_styles() {
        $mobile_icon_styles = array();
        if(deploy_mikado_options()->getOptionValue('mobile_icon_color') !== '') {
            $mobile_icon_styles['color'] = deploy_mikado_options()->getOptionValue('mobile_icon_color');
        }

        if(deploy_mikado_options()->getOptionValue('mobile_icon_size') !== '') {
            $mobile_icon_styles['font-size'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_icon_size')).'px';
        }

        echo deploy_mikado_dynamic_css('.mkdf-mobile-header .mkdf-mobile-menu-opener a', $mobile_icon_styles);

        if(deploy_mikado_options()->getOptionValue('mobile_icon_hover_color') !== '') {
            echo deploy_mikado_dynamic_css(
                '.mkdf-mobile-header .mkdf-mobile-menu-opener a:hover',
                array('color' => deploy_mikado_options()->getOptionValue('mobile_icon_hover_color')));
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_mobile_icon_styles');
}