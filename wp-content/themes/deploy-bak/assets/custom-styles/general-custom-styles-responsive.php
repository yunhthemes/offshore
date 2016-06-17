<?php
if(!function_exists('deploy_mikado_design_responsive_styles')) {
    /**
     * Generates general responsive custom styles
     */
    function deploy_mikado_design_responsive_styles() {

        $parallax_style = array();
        if (deploy_mikado_options()->getOptionValue('parallax_min_height') !== '') {
            $parallax_style['height'] = 'auto !important';
            $parallax_style['min-height'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('parallax_min_height')).'px';
        }

		echo deploy_mikado_dynamic_css('.mkdf-section.mkdf-parallax-section-holder', $parallax_style);
    }

    add_action('deploy_mikado_style_dynamic_responsive_480', 'deploy_mikado_design_responsive_styles');
    add_action('deploy_mikado_style_dynamic_responsive_480_768', 'deploy_mikado_design_responsive_styles');
}

if(!function_exists('deploy_mikado_content_responsive_styles')) {
    /**
     * Generates content responsive custom styles
     */
    function deploy_mikado_content_responsive_styles() {
        $content_style = array();
        if (deploy_mikado_options()->getOptionValue('content_top_padding_mobile')) {
            $padding_top_mobile = (deploy_mikado_options()->getOptionValue('content_top_padding_mobile'));
            $content_style['padding-top'] = deploy_mikado_filter_px($padding_top_mobile) . 'px !important';

        }

        $content_selector = array(
            '.mkdf-content .mkdf-content-inner > .mkdf-container > .mkdf-container-inner',
            '.mkdf-content .mkdf-content-inner > .mkdf-full-width > .mkdf-full-width-inner',
        );
        echo deploy_mikado_dynamic_css($content_selector, $content_style);
    }

    add_action('deploy_mikado_style_dynamic_responsive_1024', 'deploy_mikado_content_responsive_styles');
}