<?php

if(!function_exists('deploy_mikado_header_top_bar_styles')) {
    /**
     * Generates styles for header top bar
     */
    function deploy_mikado_header_top_bar_styles() {
        global $deploy_mikado_options;

        if($deploy_mikado_options['top_bar_height'] !== '') {
            echo deploy_mikado_dynamic_css('.mkdf-top-bar', array('height' => $deploy_mikado_options['top_bar_height'].'px'));
            echo deploy_mikado_dynamic_css('.mkdf-top-bar .mkdf-logo-wrapper a', array('max-height' => $deploy_mikado_options['top_bar_height'].'px'));

            echo deploy_mikado_dynamic_css('.mkdf-top-bar .mkdf-shopping-cart-outer .mkdf-shopping-cart-header .mkdf-header-cart', array('line-height' => deploy_mikado_options()->getOptionValue('top_bar_height').'px'));
        }

        if($deploy_mikado_options['top_bar_in_grid'] == 'yes') {
            $top_bar_grid_selector = '.mkdf-top-bar .mkdf-grid .mkdf-vertical-align-containers';
            $top_bar_grid_styles = array();
            if($deploy_mikado_options['top_bar_grid_background_color'] !== '') {
                $grid_background_color    = $deploy_mikado_options['top_bar_grid_background_color'];
                $grid_background_transparency = 1;

                if(deploy_mikado_options()->getOptionValue('top_bar_grid_background_transparency')) {
                    $grid_background_transparency = deploy_mikado_options()->getOptionValue('top_bar_grid_background_transparency');
                }

                $grid_background_color = deploy_mikado_rgba_color($grid_background_color, $grid_background_transparency);
                $top_bar_grid_styles['background-color'] = $grid_background_color;
            }

            echo deploy_mikado_dynamic_css($top_bar_grid_selector, $top_bar_grid_styles);
        }

        $background_color = deploy_mikado_options()->getOptionValue('top_bar_background_color');
        $top_bar_styles = array();
        if($background_color !== '') {
            $background_transparency = 1;
            if(deploy_mikado_options()->getOptionValue('top_bar_background_transparency') !== '') {
               $background_transparency = deploy_mikado_options()->getOptionValue('top_bar_background_transparency');
            }

            $background_color = deploy_mikado_rgba_color($background_color, $background_transparency);
            $top_bar_styles['background-color'] = $background_color;
        }

        echo deploy_mikado_dynamic_css('.mkdf-top-bar', $top_bar_styles);
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_header_top_bar_styles');
}

if(!function_exists('deploy_mikado_header_standard_menu_area_styles')) {
    /**
     * Generates styles for header standard menu
     */
    function deploy_mikado_header_standard_menu_area_styles() {
        global $deploy_mikado_options;

        $menu_area_header_standard_styles = array();

        if($deploy_mikado_options['menu_area_background_color_header_standard'] !== '') {
            $menu_area_background_color        = $deploy_mikado_options['menu_area_background_color_header_standard'];
            $menu_area_background_transparency = 1;

            if($deploy_mikado_options['menu_area_background_transparency_header_standard'] !== '') {
                $menu_area_background_transparency = $deploy_mikado_options['menu_area_background_transparency_header_standard'];
            }

            $menu_area_header_standard_styles['background-color'] = deploy_mikado_rgba_color($menu_area_background_color, $menu_area_background_transparency);
        }

        if($deploy_mikado_options['menu_area_height_header_standard'] !== '') {
            $max_height = intval(deploy_mikado_filter_px($deploy_mikado_options['menu_area_height_header_standard']) * 0.9).'px';
            echo deploy_mikado_dynamic_css('.mkdf-header-standard .mkdf-page-header .mkdf-logo-wrapper a', array('max-height' => $max_height));

            $menu_area_header_standard_styles['height'] = deploy_mikado_filter_px($deploy_mikado_options['menu_area_height_header_standard']).'px';

        }

        echo deploy_mikado_dynamic_css('.mkdf-header-standard .mkdf-page-header .mkdf-menu-area', $menu_area_header_standard_styles);

        $menu_area_grid_header_standard_styles = array();

        if($deploy_mikado_options['menu_area_in_grid_header_standard'] == 'yes' && $deploy_mikado_options['menu_area_grid_background_color_header_standard'] !== '') {
            $menu_area_grid_background_color        = $deploy_mikado_options['menu_area_grid_background_color_header_standard'];
            $menu_area_grid_background_transparency = 1;

            if($deploy_mikado_options['menu_area_grid_background_transparency_header_standard'] !== '') {
                $menu_area_grid_background_transparency = $deploy_mikado_options['menu_area_grid_background_transparency_header_standard'];
            }

            $menu_area_grid_header_standard_styles['background-color'] = deploy_mikado_rgba_color($menu_area_grid_background_color, $menu_area_grid_background_transparency);
        }

        echo deploy_mikado_dynamic_css('.mkdf-header-standard .mkdf-page-header .mkdf-menu-area .mkdf-grid .mkdf-vertical-align-containers', $menu_area_grid_header_standard_styles);
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_header_standard_menu_area_styles');
}

if(!function_exists('deploy_mikado_sticky_header_styles')) {
    /**
     * Generates styles for sticky haeder
     */
    function deploy_mikado_sticky_header_styles() {
        global $deploy_mikado_options;

        if($deploy_mikado_options['sticky_header_in_grid'] == 'yes' && $deploy_mikado_options['sticky_header_grid_background_color'] !== '') {
            $sticky_header_grid_background_color        = $deploy_mikado_options['sticky_header_grid_background_color'];
            $sticky_header_grid_background_transparency = 1;

            if($deploy_mikado_options['sticky_header_grid_transparency'] !== '') {
                $sticky_header_grid_background_transparency = $deploy_mikado_options['sticky_header_grid_transparency'];
            }

            echo deploy_mikado_dynamic_css('.mkdf-page-header .mkdf-sticky-header .mkdf-grid .mkdf-vertical-align-containers', array('background-color' => deploy_mikado_rgba_color($sticky_header_grid_background_color, $sticky_header_grid_background_transparency)));
        }

        if($deploy_mikado_options['sticky_header_background_color'] !== '') {

            $sticky_header_background_color              = $deploy_mikado_options['sticky_header_background_color'];
            $sticky_header_background_color_transparency = 1;

            if($deploy_mikado_options['sticky_header_transparency'] !== '') {
                $sticky_header_background_color_transparency = $deploy_mikado_options['sticky_header_transparency'];
            }

            echo deploy_mikado_dynamic_css('.mkdf-page-header .mkdf-sticky-header .mkdf-sticky-holder', array('background-color' => deploy_mikado_rgba_color($sticky_header_background_color, $sticky_header_background_color_transparency)));
        }

        if($deploy_mikado_options['sticky_header_height'] !== '') {
            $max_height = intval(deploy_mikado_filter_px($deploy_mikado_options['sticky_header_height']) * 0.9).'px';

            echo deploy_mikado_dynamic_css('.mkdf-page-header .mkdf-sticky-header', array('height' => $deploy_mikado_options['sticky_header_height'].'px'));
            echo deploy_mikado_dynamic_css('.mkdf-sticky-header .mkdf-shopping-cart-outer .mkdf-shopping-cart-header .mkdf-header-cart', array('line-height' => deploy_mikado_options()->getOptionValue('sticky_header_height').'px'));
            echo deploy_mikado_dynamic_css('.mkdf-page-header .mkdf-sticky-header .mkdf-logo-wrapper a', array('max-height' => $max_height));
        }

        $sticky_menu_item_styles = array();
        if($deploy_mikado_options['sticky_color'] !== '') {
            $sticky_menu_item_styles['color'] = $deploy_mikado_options['sticky_color'];
        }
        if($deploy_mikado_options['sticky_google_fonts'] !== '-1') {
            $sticky_menu_item_styles['font-family'] = deploy_mikado_get_formatted_font_family($deploy_mikado_options['sticky_google_fonts']);
        }
        if($deploy_mikado_options['sticky_fontsize'] !== '') {
            $sticky_menu_item_styles['font-size'] = $deploy_mikado_options['sticky_fontsize'].'px';
        }
        if($deploy_mikado_options['sticky_lineheight'] !== '') {
            $sticky_menu_item_styles['line-height'] = $deploy_mikado_options['sticky_lineheight'].'px';
        }
        if($deploy_mikado_options['sticky_texttransform'] !== '') {
            $sticky_menu_item_styles['text-transform'] = $deploy_mikado_options['sticky_texttransform'];
        }
        if($deploy_mikado_options['sticky_fontstyle'] !== '') {
            $sticky_menu_item_styles['font-style'] = $deploy_mikado_options['sticky_fontstyle'];
        }
        if($deploy_mikado_options['sticky_fontweight'] !== '') {
            $sticky_menu_item_styles['font-weight'] = $deploy_mikado_options['sticky_fontweight'];
        }
        if($deploy_mikado_options['sticky_letterspacing'] !== '') {
            $sticky_menu_item_styles['letter-spacing'] = $deploy_mikado_options['sticky_letterspacing'].'px';
        }

        $sticky_menu_item_selector = array(
            '.mkdf-main-menu.mkdf-sticky-nav > ul > li > a'
        );

        echo deploy_mikado_dynamic_css($sticky_menu_item_selector, $sticky_menu_item_styles);

        $sticky_menu_item_hover_styles = array();
        if($deploy_mikado_options['sticky_hovercolor'] !== '') {
            $sticky_menu_item_hover_styles['color'] = $deploy_mikado_options['sticky_hovercolor'];
        }

        $sticky_menu_item_hover_selector = array(
            '.mkdf-main-menu.mkdf-sticky-nav > ul > li:hover > a',
            '.mkdf-main-menu.mkdf-sticky-nav > ul > li.mkdf-active-item:hover > a',
            'body:not(.mkdf-menu-item-first-level-bg-color) .mkdf-main-menu.mkdf-sticky-nav > ul > li:hover > a',
            'body:not(.mkdf-menu-item-first-level-bg-color) .mkdf-main-menu.mkdf-sticky-nav > ul > li.mkdf-active-item:hover > a'
        );

        echo deploy_mikado_dynamic_css($sticky_menu_item_hover_selector, $sticky_menu_item_hover_styles);
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_sticky_header_styles');
}

if(!function_exists('deploy_mikado_fixed_header_styles')) {
    /**
     * Generates styles for fixed haeder
     */
    function deploy_mikado_fixed_header_styles() {
        global $deploy_mikado_options;

        if($deploy_mikado_options['fixed_header_grid_background_color'] !== '') {

            $fixed_header_grid_background_color              = $deploy_mikado_options['fixed_header_grid_background_color'];
            $fixed_header_grid_background_color_transparency = 1;

            if($deploy_mikado_options['fixed_header_grid_transparency'] !== '') {
                $fixed_header_grid_background_color_transparency = $deploy_mikado_options['fixed_header_grid_transparency'];
            }

            echo deploy_mikado_dynamic_css('.mkdf-header-type1 .mkdf-fixed-wrapper.fixed .mkdf-grid .mkdf-vertical-align-containers,
                                    .mkdf-header-type3 .mkdf-fixed-wrapper.fixed .mkdf-grid .mkdf-vertical-align-containers',
                array('background-color' => deploy_mikado_rgba_color($fixed_header_grid_background_color, $fixed_header_grid_background_color_transparency)));
        }

        if($deploy_mikado_options['fixed_header_background_color'] !== '') {

            $fixed_header_background_color              = $deploy_mikado_options['fixed_header_background_color'];
            $fixed_header_background_color_transparency = 1;

            if($deploy_mikado_options['fixed_header_transparency'] !== '') {
                $fixed_header_background_color_transparency = $deploy_mikado_options['fixed_header_transparency'];
            }

            echo deploy_mikado_dynamic_css('.mkdf-header-type1 .mkdf-fixed-wrapper.fixed .mkdf-menu-area,
                                    .mkdf-header-type3 .mkdf-fixed-wrapper.fixed .mkdf-menu-area',
                array('background-color' => deploy_mikado_rgba_color($fixed_header_background_color, $fixed_header_background_color_transparency)));
        }

    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_fixed_header_styles');
}

if(!function_exists('deploy_mikado_main_menu_styles')) {
    /**
     * Generates styles for main menu
     */
    function deploy_mikado_main_menu_styles() {
        global $deploy_mikado_options;

        if($deploy_mikado_options['menu_color'] !== '' || $deploy_mikado_options['menu_fontsize'] != '' || $deploy_mikado_options['menu_fontstyle'] !== '' || $deploy_mikado_options['menu_fontweight'] !== '' || $deploy_mikado_options['menu_texttransform'] !== '' || $deploy_mikado_options['menu_letterspacing'] !== '' || $deploy_mikado_options['menu_google_fonts'] != "-1") { ?>
            .mkdf-main-menu.mkdf-default-nav > ul > li > a,
            .mkdf-page-header #lang_sel > ul > li > a,
            .mkdf-page-header #lang_sel_click > ul > li > a,
            .mkdf-page-header #lang_sel ul > li:hover > a{
            <?php if($deploy_mikado_options['menu_color']) { ?> color: <?php echo esc_attr($deploy_mikado_options['menu_color']); ?>; <?php } ?>
            <?php if($deploy_mikado_options['menu_google_fonts'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $deploy_mikado_options['menu_google_fonts'])); ?>', sans-serif;
            <?php } ?>
            <?php if($deploy_mikado_options['menu_fontsize'] !== '') { ?> font-size: <?php echo esc_attr($deploy_mikado_options['menu_fontsize']); ?>px; <?php } ?>
            <?php if($deploy_mikado_options['menu_fontstyle'] !== '') { ?> font-style: <?php echo esc_attr($deploy_mikado_options['menu_fontstyle']); ?>; <?php } ?>
            <?php if($deploy_mikado_options['menu_fontweight'] !== '') { ?> font-weight: <?php echo esc_attr($deploy_mikado_options['menu_fontweight']); ?>; <?php } ?>
            <?php if($deploy_mikado_options['menu_texttransform'] !== '') { ?> text-transform: <?php echo esc_attr($deploy_mikado_options['menu_texttransform']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['menu_letterspacing'] !== '') { ?> letter-spacing: <?php echo esc_attr($deploy_mikado_options['menu_letterspacing']); ?>px; <?php } ?>
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_google_fonts'] != "-1") { ?>
            .mkdf-page-header #lang_sel_list{
            font-family: '<?php echo esc_attr(str_replace('+', ' ', $deploy_mikado_options['menu_google_fonts'])); ?>', sans-serif !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_hovercolor'] !== '') { ?>
            .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a,
            .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a,
            body:not(.mkdf-menu-item-first-level-bg-color) .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a,
            body:not(.mkdf-menu-item-first-level-bg-color) .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a,
            .mkdf-page-header #lang_sel ul li a:hover,
            .mkdf-page-header #lang_sel_click > ul > li a:hover{
            color: <?php echo esc_attr($deploy_mikado_options['menu_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_activecolor'] !== '') { ?>
            .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a,
            body:not(.mkdf-menu-item-first-level-bg-color) .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a{
            color: <?php echo esc_attr($deploy_mikado_options['menu_activecolor']); ?>;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_item_icon_position'] == "top" && $deploy_mikado_options['menu_item_icon_size'] !== "") { ?>
            body.mkdf-menu-with-large-icons .mkdf-main-menu.mkdf-default-nav > ul > li > a span.item_inner i{
            font-size: <?php echo esc_attr($deploy_mikado_options['menu_item_icon_size']); ?>px !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_light_hovercolor'] !== '') { ?>
            .light .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a,
            .light .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a{
            color: <?php echo esc_attr($deploy_mikado_options['menu_light_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_light_activecolor'] !== '') { ?>
            .light .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a{
            color: <?php echo esc_attr($deploy_mikado_options['menu_light_activecolor']); ?> !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_dark_hovercolor'] !== '') { ?>
            .dark .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a,
            .dark .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a{
            color: <?php echo esc_attr($deploy_mikado_options['menu_dark_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_dark_activecolor'] !== '') { ?>
            .dark .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a{
            color: <?php echo esc_attr($deploy_mikado_options['menu_dark_activecolor']); ?>;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_lineheight'] != "" || $deploy_mikado_options['menu_padding_left_right'] !== '') { ?>
            .mkdf-main-menu.mkdf-default-nav > ul > li > a span.item_inner{
            <?php if($deploy_mikado_options['menu_lineheight'] !== '') { ?> line-height: <?php echo esc_attr($deploy_mikado_options['menu_lineheight']); ?>px; <?php } ?>
            <?php if($deploy_mikado_options['menu_padding_left_right']) { ?> padding: 0  <?php echo esc_attr($deploy_mikado_options['menu_padding_left_right']); ?>px; <?php } ?>
            }
        <?php } ?>

        <?php if($deploy_mikado_options['menu_margin_left_right'] !== '') { ?>
            .mkdf-main-menu.mkdf-default-nav > ul > li{
            margin: 0  <?php echo esc_attr($deploy_mikado_options['menu_margin_left_right']); ?>px;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['enable_menu_item_text_decoration'] == 'yes') { ?>

            <?php if($deploy_mikado_options['menu_item_text_decoration_style'] == 'none') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a span.item_inner,
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a span.item_inner{
                text-decoration: none;
                }
            <?php } ?>
            <?php if($deploy_mikado_options['menu_item_text_decoration_style'] == 'underline') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a span.item_inner,
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a span.item_inner{
                text-decoration: underline;
                }
            <?php } ?>
            <?php if($deploy_mikado_options['menu_item_text_decoration_style'] == 'line-through') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a span.item_inner,
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a span.item_inner{
                text-decoration: line-through;
                }
            <?php } ?>
            <?php if($deploy_mikado_options['menu_item_text_decoration_style'] == 'overline') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li:hover > a span.item_inner,
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item:hover > a span.item_inner{
                text-decoration: overline;
                }
            <?php } ?>


            <?php if($deploy_mikado_options['menu_item_active_text_decoration_style'] == 'none') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a span.item_inner{
                text-decoration: none;
                }
            <?php } ?>
            <?php if($deploy_mikado_options['menu_item_active_text_decoration_style'] == 'underline') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a span.item_inner{
                text-decoration: underline;
                }
            <?php } ?>
            <?php if($deploy_mikado_options['menu_item_active_text_decoration_style'] == 'line-through') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a span.item_inner{
                text-decoration: line-through;
                }
            <?php } ?>
            <?php if($deploy_mikado_options['menu_item_active_text_decoration_style'] == 'overline') { ?>
                .mkdf-main-menu.mkdf-default-nav > ul > li.mkdf-active-item > a span.item_inner{
                text-decoration: overline;
                }
            <?php } ?>

        <?php } ?>

        <?php
        if($deploy_mikado_options['dropdown_background_color'] != "" || $deploy_mikado_options['dropdown_background_transparency'] != "") {

            //dropdown background and transparency styles
            $dropdown_bg_color_initial        = '#252525';
            $dropdown_bg_transparency_initial = 1;

            $dropdown_bg_color        = $deploy_mikado_options['dropdown_background_color'] !== "" ? $deploy_mikado_options['dropdown_background_color'] : $dropdown_bg_color_initial;
            $dropdown_bg_transparency = $deploy_mikado_options['dropdown_background_transparency'] !== "" ? $deploy_mikado_options['dropdown_background_transparency'] : $dropdown_bg_transparency_initial;

            $dropdown_bg_color_rgb = deploy_mikado_hex2rgb($dropdown_bg_color);

            ?>

            .mkdf-drop-down .second .inner ul,
            .mkdf-drop-down .second .inner ul li ul,
            .shopping_cart_dropdown,
            li.narrow .second .inner ul,
            .mkdf-main-menu.mkdf-default-nav #lang_sel ul ul,
            .mkdf-main-menu.mkdf-default-nav #lang_sel_click  ul ul,
            .header-widget.widget_nav_menu ul ul,
            .mkdf-drop-down .wide.wide_background .second{
            background-color: <?php echo esc_attr($dropdown_bg_color); ?>;
            background-color: rgba(<?php echo esc_attr($dropdown_bg_color_rgb[0]); ?>,<?php echo esc_attr($dropdown_bg_color_rgb[1]); ?>,<?php echo esc_attr($dropdown_bg_color_rgb[2]); ?>,<?php echo esc_attr($dropdown_bg_transparency); ?>);
            }

        <?php } //end dropdown background and transparency styles ?>

        <?php
        if($deploy_mikado_options['dropdown_top_padding'] !== '') {

            $menu_inner_ul_top = 15; //default value without border
            if($deploy_mikado_options['dropdown_top_padding'] !== '') {
                ?>
                li.narrow .second .inner ul,
                .mkdf-drop-down .wide .second .inner > ul{
                padding-top: <?php echo esc_attr($deploy_mikado_options['dropdown_top_padding']); ?>px;
                }
                <?php
                $menu_inner_ul_top = $deploy_mikado_options['dropdown_top_padding']; //overwrite default value
            } ?>
            .mkdf-drop-down .narrow .second .inner ul li ul,
            body.mkdf-slide-from-bottom .mkdf-drop-down .narrow .second .inner ul li:hover ul,
            body.mkdf-slide-from-top .narrow .second .inner ul li:hover ul{
            top:-<?php echo esc_attr($menu_inner_ul_top); ?>px;
            }

        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_bottom_padding'] !== '') { ?>
            li.narrow .second .inner ul,
            .mkdf-drop-down .wide .second .inner > ul{
            padding-bottom: <?php echo esc_attr($deploy_mikado_options['dropdown_bottom_padding']); ?>px;
            }
        <?php } ?>

        <?php
        if($deploy_mikado_options['dropdown_separator_color'] !== '') {
            ?>
            .mkdf-drop-down .second .inner ul li a,
            .header-widget.widget_nav_menu ul.menu li ul li a {
            border-color: <?php echo esc_attr($deploy_mikado_options['dropdown_separator_color']); ?>;
            }
        <?php } ?>

        <?php if(!empty($deploy_mikado_options['dropdown_vertical_separator_color'])) { ?>
            .mkdf-drop-down .wide .second ul li{
            border-left-color: <?php echo esc_attr($deploy_mikado_options['dropdown_vertical_separator_color']); ?>;
            }
        <?php } ?>


        <?php if($deploy_mikado_options['dropdown_top_position'] !== '') { ?>
            header .mkdf-drop-down .second {
            top: <?php echo esc_attr($deploy_mikado_options['dropdown_top_position']).'%;'; ?>
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_color'] !== '' || $deploy_mikado_options['dropdown_fontsize'] !== '' || $deploy_mikado_options['dropdown_lineheight'] !== '' || $deploy_mikado_options['dropdown_fontstyle'] !== '' || $deploy_mikado_options['dropdown_fontweight'] !== '' || $deploy_mikado_options['dropdown_google_fonts'] != "-1" || $deploy_mikado_options['dropdown_texttransform'] !== '' || $deploy_mikado_options['dropdown_letterspacing'] !== '') { ?>
            .mkdf-drop-down .second .inner > ul > li > a,
            .mkdf-drop-down .second .inner > ul > li > h4,
            .mkdf-drop-down .wide .second .inner > ul > li > h4,
            .mkdf-drop-down .wide .second .inner > ul > li > a,
            .mkdf-drop-down .wide .second ul li ul li.menu-item-has-children > a,
            .mkdf-drop-down .wide .second .inner ul li.sub ul li.menu-item-has-children > a,
            .mkdf-drop-down .wide .second .inner > ul li.sub .flexslider ul li  h4 a,
            .mkdf-drop-down .wide .second .inner > ul li .flexslider ul li  h4 a,
            .mkdf-drop-down .wide .second .inner > ul li.sub .flexslider ul li  h4,
            .mkdf-drop-down .wide .second .inner > ul li .flexslider ul li  h4,
            .mkdf-main-menu.mkdf-default-nav #lang_sel ul li li a,
            .mkdf-main-menu.mkdf-default-nav #lang_sel_click ul li ul li a,
            .mkdf-main-menu.mkdf-default-nav #lang_sel ul ul a,
            .mkdf-main-menu.mkdf-default-nav #lang_sel_click ul ul a{
            <?php if(!empty($deploy_mikado_options['dropdown_color'])) { ?> color: <?php echo esc_attr($deploy_mikado_options['dropdown_color']); ?>; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_google_fonts'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $deploy_mikado_options['dropdown_google_fonts'])); ?>', sans-serif !important;
            <?php } ?>
            <?php if($deploy_mikado_options['dropdown_fontsize'] !== '') { ?> font-size: <?php echo esc_attr($deploy_mikado_options['dropdown_fontsize']); ?>px; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_lineheight'] !== '') { ?> line-height: <?php echo esc_attr($deploy_mikado_options['dropdown_lineheight']); ?>px; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_fontstyle'] !== '') { ?> font-style: <?php echo esc_attr($deploy_mikado_options['dropdown_fontstyle']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_fontweight'] !== '') { ?>font-weight: <?php echo esc_attr($deploy_mikado_options['dropdown_fontweight']); ?>; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_texttransform'] !== '') { ?> text-transform: <?php echo esc_attr($deploy_mikado_options['dropdown_texttransform']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_letterspacing'] !== '') { ?> letter-spacing: <?php echo esc_attr($deploy_mikado_options['dropdown_letterspacing']); ?>px;  <?php } ?>
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_color'] !== '') { ?>
            .shopping_cart_dropdown ul li
            .item_info_holder .item_left a,
            .shopping_cart_dropdown ul li .item_info_holder .item_right .amount,
            .shopping_cart_dropdown .cart_bottom .subtotal_holder .total,
            .shopping_cart_dropdown .cart_bottom .subtotal_holder .total_amount{
            color: <?php echo esc_attr($deploy_mikado_options['dropdown_color']); ?>;
            }
        <?php } ?>

        <?php if(!empty($deploy_mikado_options['dropdown_hovercolor'])) { ?>
            .mkdf-drop-down .second .inner > ul > li:hover > a,
            .mkdf-drop-down .wide .second ul li ul li.menu-item-has-children:hover > a,
            .mkdf-drop-down .wide .second .inner ul li.sub ul li.menu-item-has-children:hover > a,
            .mkdf-main-menu.mkdf-default-nav #lang_sel ul li li:hover a,
            .mkdf-main-menu.mkdf-default-nav #lang_sel_click ul li ul li:hover a,
            .mkdf-main-menu.mkdf-default-nav #lang_sel ul li:hover > a,
            .mkdf-main-menu.mkdf-default-nav #lang_sel_click ul li:hover > a{
            color: <?php echo esc_attr($deploy_mikado_options['dropdown_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if(!empty($deploy_mikado_options['dropdown_background_hovercolor'])) { ?>
            .mkdf-drop-down li:not(.wide) .second .inner > ul > li:hover{
            background-color: <?php echo esc_attr($deploy_mikado_options['dropdown_background_hovercolor']); ?>;
            }
        <?php } ?>

        <?php if(!empty($deploy_mikado_options['dropdown_padding_top_bottom'])) { ?>
            .mkdf-drop-down .wide .second>.inner>ul>li.sub>ul>li>a,
            .mkdf-drop-down .second .inner ul li a,
            .mkdf-drop-down .wide .second ul li a,
            .mkdf-drop-down .second .inner ul.right li a{
            padding-top: <?php echo esc_attr($deploy_mikado_options['dropdown_padding_top_bottom']); ?>px;
            padding-bottom: <?php echo esc_attr($deploy_mikado_options['dropdown_padding_top_bottom']); ?>px;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_wide_color'] !== '' || $deploy_mikado_options['dropdown_wide_fontsize'] !== '' || $deploy_mikado_options['dropdown_wide_lineheight'] !== '' || $deploy_mikado_options['dropdown_wide_fontstyle'] !== '' || $deploy_mikado_options['dropdown_wide_fontweight'] !== '' || $deploy_mikado_options['dropdown_wide_google_fonts'] !== "-1" || $deploy_mikado_options['dropdown_wide_texttransform'] !== '' || $deploy_mikado_options['dropdown_wide_letterspacing'] !== '') { ?>
            .mkdf-drop-down .wide .second .inner > ul > li > a{
            <?php if($deploy_mikado_options['dropdown_wide_color'] !== '') { ?> color: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_color']); ?>; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_google_fonts'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $deploy_mikado_options['dropdown_wide_google_fonts'])); ?>', sans-serif !important;
            <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_fontsize'] !== '') { ?> font-size: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_fontsize']); ?>px; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_lineheight'] !== '') { ?> line-height: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_lineheight']); ?>px; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_fontstyle'] !== '') { ?> font-style: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_fontstyle']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_fontweight'] !== '') { ?>font-weight: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_fontweight']); ?>; <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_texttransform'] !== '') { ?> text-transform: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_texttransform']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_letterspacing'] !== '') { ?> letter-spacing: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_letterspacing']); ?>px;  <?php } ?>
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_wide_hovercolor'] !== '') { ?>
            .mkdf-drop-down .wide .second .inner > ul > li:hover > a {
            color: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_hovercolor']); ?> !important;
            }
        <?php } ?>

        <?php if(!empty($deploy_mikado_options['dropdown_wide_background_hovercolor'])) { ?>
            .mkdf-drop-down .wide .second .inner > ul > li:hover > a{
            background-color: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_background_hovercolor']); ?>
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_wide_padding_top_bottom'] !== '') { ?>
            .mkdf-drop-down .wide .second>.inner > ul > li.sub > ul > li > a,
            .mkdf-drop-down .wide .second .inner ul li a,
            .mkdf-drop-down .wide .second ul li a,
            .mkdf-drop-down .wide .second .inner ul.right li a{
            padding-top: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_padding_top_bottom']); ?>px;
            padding-bottom: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_padding_top_bottom']); ?>px;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_color_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_fontsize_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_lineheight_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_fontstyle_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_fontweight_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_google_fonts_thirdlvl'] != "-1" || $deploy_mikado_options['dropdown_texttransform_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_letterspacing_thirdlvl'] !== '') { ?>
            .mkdf-drop-down .second .inner ul li.sub ul li a{
            <?php if($deploy_mikado_options['dropdown_color_thirdlvl'] !== '') { ?> color: <?php echo esc_attr($deploy_mikado_options['dropdown_color_thirdlvl']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_google_fonts_thirdlvl'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $deploy_mikado_options['dropdown_google_fonts_thirdlvl'])); ?>', sans-serif;
            <?php } ?>
            <?php if($deploy_mikado_options['dropdown_fontsize_thirdlvl'] !== '') { ?> font-size: <?php echo esc_attr($deploy_mikado_options['dropdown_fontsize_thirdlvl']); ?>px;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_lineheight_thirdlvl'] !== '') { ?> line-height: <?php echo esc_attr($deploy_mikado_options['dropdown_lineheight_thirdlvl']); ?>px;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_fontstyle_thirdlvl'] !== '') { ?> font-style: <?php echo esc_attr($deploy_mikado_options['dropdown_fontstyle_thirdlvl']); ?>;   <?php } ?>
            <?php if($deploy_mikado_options['dropdown_fontweight_thirdlvl'] !== '') { ?> font-weight: <?php echo esc_attr($deploy_mikado_options['dropdown_fontweight_thirdlvl']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_texttransform_thirdlvl'] !== '') { ?> text-transform: <?php echo esc_attr($deploy_mikado_options['dropdown_texttransform_thirdlvl']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_letterspacing_thirdlvl'] !== '') { ?> letter-spacing: <?php echo esc_attr($deploy_mikado_options['dropdown_letterspacing_thirdlvl']); ?>px;  <?php } ?>
            }
        <?php } ?>
        <?php if($deploy_mikado_options['dropdown_hovercolor_thirdlvl'] !== '') { ?>
            .mkdf-drop-down .second .inner ul li.sub ul li:not(.flex-active-slide):hover > a:not(.flex-prev):not(.flex-next),
            .mkdf-drop-down .second .inner ul li ul li:not(.flex-active-slide):hover > a:not(.flex-prev):not(.flex-next){
            color: <?php echo esc_attr($deploy_mikado_options['dropdown_hovercolor_thirdlvl']); ?> !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_background_hovercolor_thirdlvl'] !== '') { ?>
            .mkdf-drop-down .second .inner ul li.sub ul li:hover,
            .mkdf-drop-down .second .inner ul li ul li:hover{
            background-color: <?php echo esc_attr($deploy_mikado_options['dropdown_background_hovercolor_thirdlvl']); ?>;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_wide_color_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_wide_fontsize_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_wide_lineheight_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_wide_fontstyle_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_wide_fontweight_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_wide_google_fonts_thirdlvl'] != "-1" || $deploy_mikado_options['dropdown_wide_texttransform_thirdlvl'] !== '' || $deploy_mikado_options['dropdown_wide_letterspacing_thirdlvl'] !== '') { ?>
            .mkdf-drop-down .wide .second .inner ul li.sub ul li a,
            .mkdf-drop-down .wide .second ul li ul li a{
            <?php if($deploy_mikado_options['dropdown_wide_color_thirdlvl'] !== '') { ?> color: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_color_thirdlvl']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_google_fonts_thirdlvl'] != "-1") { ?>
                font-family: '<?php echo esc_attr(str_replace('+', ' ', $deploy_mikado_options['dropdown_wide_google_fonts_thirdlvl'])); ?>', sans-serif;
            <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_fontsize_thirdlvl'] !== '') { ?> font-size: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_fontsize_thirdlvl']); ?>px;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_lineheight_thirdlvl'] !== '') { ?> line-height: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_lineheight_thirdlvl']); ?>px;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_fontstyle_thirdlvl'] !== '') { ?> font-style: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_fontstyle_thirdlvl']); ?>;   <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_fontweight_thirdlvl'] !== '') { ?> font-weight: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_fontweight_thirdlvl']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_texttransform_thirdlvl'] !== '') { ?> text-transform: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_texttransform_thirdlvl']); ?>;  <?php } ?>
            <?php if($deploy_mikado_options['dropdown_wide_letterspacing_thirdlvl'] !== '') { ?> letter-spacing: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_letterspacing_thirdlvl']); ?>px;  <?php } ?>
            }
        <?php } ?>
        <?php if($deploy_mikado_options['dropdown_wide_hovercolor_thirdlvl'] !== '') { ?>
            .mkdf-drop-down .wide .second .inner ul li.sub ul li:not(.flex-active-slide) > a:not(.flex-prev):not(.flex-next):hover,
            .mkdf-drop-down .wide .second .inner ul li ul li:not(.flex-active-slide) > a:not(.flex-prev):not(.flex-next):hover{
            color: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_hovercolor_thirdlvl']); ?> !important;
            }
        <?php } ?>

        <?php if($deploy_mikado_options['dropdown_wide_background_hovercolor_thirdlvl'] !== '') { ?>
            .mkdf-drop-down .wide .second .inner ul li.sub ul li:hover,
            .mkdf-drop-down .wide .second .inner ul li ul li:hover{
            background-color: <?php echo esc_attr($deploy_mikado_options['dropdown_wide_background_hovercolor_thirdlvl']); ?>;
            }
        <?php }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_main_menu_styles');
}
