<?php

if(!function_exists('deploy_mikado_button_typography_styles')) {
    /**
     * Typography styles for all button types
     */
    function deploy_mikado_button_typography_styles() {
        $selector = '.mkdf-btn';
        $styles = array();

        $font_family = deploy_mikado_options()->getOptionValue('button_font_family');
        if(deploy_mikado_is_font_option_valid($font_family)) {
            $styles['font-family'] = deploy_mikado_get_font_option_val($font_family);
        }

        $text_transform = deploy_mikado_options()->getOptionValue('button_text_transform');
        if(!empty($text_transform)) {
            $styles['text-transform'] = $text_transform;
        }

        $font_style = deploy_mikado_options()->getOptionValue('button_font_style');
        if(!empty($font_style)) {
            $styles['font-style'] = $font_style;
        }

        $letter_spacing = deploy_mikado_options()->getOptionValue('button_letter_spacing');
        if($letter_spacing !== '') {
            $styles['letter-spacing'] = deploy_mikado_filter_px($letter_spacing).'px';
        }

        $font_weight = deploy_mikado_options()->getOptionValue('button_font_weight');
        if(!empty($font_weight)) {
            $styles['font-weight'] = $font_weight;
        }

        echo deploy_mikado_dynamic_css($selector, $styles);
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_button_typography_styles');
}

if(!function_exists('deploy_mikado_button_outline_styles')) {
    /**
     * Generate styles for outline button
     */
    function deploy_mikado_button_outline_styles() {
        //outline styles
        $outline_styles   = array();
        $outline_selector = '.mkdf-btn.mkdf-btn-outline';

        if(deploy_mikado_options()->getOptionValue('btn_outline_text_color')) {
            $outline_styles['color'] = deploy_mikado_options()->getOptionValue('btn_outline_text_color');
        }

        if(deploy_mikado_options()->getOptionValue('btn_outline_border_color')) {
            $outline_styles['border-color'] = deploy_mikado_options()->getOptionValue('btn_outline_border_color');
        }

        echo deploy_mikado_dynamic_css($outline_selector, $outline_styles);

        //outline hover styles
        if(deploy_mikado_options()->getOptionValue('btn_outline_hover_text_color')) {
            echo deploy_mikado_dynamic_css(
                '.mkdf-btn.mkdf-btn-outline:not(.mkdf-btn-custom-hover-color):hover',
                array('color' => deploy_mikado_options()->getOptionValue('btn_outline_hover_text_color').'!important')
            );
        }

        if(deploy_mikado_options()->getOptionValue('btn_outline_hover_bg_color')) {
            echo deploy_mikado_dynamic_css(
                '.mkdf-btn.mkdf-btn-outline:not(.mkdf-btn-custom-hover-bg):hover',
                array('background-color' => deploy_mikado_options()->getOptionValue('btn_outline_hover_bg_color').'!important')
            );
        }

        if(deploy_mikado_options()->getOptionValue('btn_outline_hover_border_color')) {
            echo deploy_mikado_dynamic_css(
                '.mkdf-btn.mkdf-btn-outline:not(.mkdf-btn-custom-border-hover):hover',
                array('border-color' => deploy_mikado_options()->getOptionValue('btn_outline_hover_border_color').'!important')
            );
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_button_outline_styles');
}

if(!function_exists('deploy_mikado_button_solid_styles')) {
    /**
     * Generate styles for solid type buttons
     */
    function deploy_mikado_button_solid_styles() {
        //solid styles
        $solid_selector = '.mkdf-btn.mkdf-btn-solid';
        $solid_styles = array();

        if(deploy_mikado_options()->getOptionValue('btn_solid_text_color')) {
            $solid_styles['color'] = deploy_mikado_options()->getOptionValue('btn_solid_text_color');
        }

        if(deploy_mikado_options()->getOptionValue('btn_solid_border_color')) {
            $solid_styles['border-color'] = deploy_mikado_options()->getOptionValue('btn_solid_border_color');
        }

        if(deploy_mikado_options()->getOptionValue('btn_solid_bg_color')) {
            $solid_styles['background-color'] = deploy_mikado_options()->getOptionValue('btn_solid_bg_color');
        }

        echo deploy_mikado_dynamic_css($solid_selector, $solid_styles);

        //solid hover styles
        if(deploy_mikado_options()->getOptionValue('btn_solid_hover_text_color')) {
            echo deploy_mikado_dynamic_css(
                '.mkdf-btn.mkdf-btn-solid:not(.mkdf-btn-custom-hover-color):hover',
                array('color' => deploy_mikado_options()->getOptionValue('btn_solid_hover_text_color').'!important')
            );
        }

        if(deploy_mikado_options()->getOptionValue('btn_solid_hover_bg_color')) {
            echo deploy_mikado_dynamic_css(
                '.mkdf-btn.mkdf-btn-solid:not(.mkdf-btn-custom-hover-bg):hover',
                array('background-color' => deploy_mikado_options()->getOptionValue('btn_solid_hover_bg_color').'!important')
            );
        }

        if(deploy_mikado_options()->getOptionValue('btn_solid_hover_border_color')) {
            echo deploy_mikado_dynamic_css(
                '.mkdf-btn.mkdf-btn-solid:not(.mkdf-btn-custom-hover-bg):hover',
                array('border-color' => deploy_mikado_options()->getOptionValue('btn_solid_hover_border_color').'!important')
            );
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_button_solid_styles');
}