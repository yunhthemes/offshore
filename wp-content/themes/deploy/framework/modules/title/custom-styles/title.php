<?php

if (!function_exists('deploy_mikado_title_area_typography_style')) {

    function deploy_mikado_title_area_typography_style(){

        $title_styles = array();

        if(deploy_mikado_options()->getOptionValue('page_title_color') !== '') {
            $title_styles['color'] = deploy_mikado_options()->getOptionValue('page_title_color');
        }
        if(deploy_mikado_options()->getOptionValue('page_title_google_fonts') !== '-1') {
            $title_styles['font-family'] = deploy_mikado_get_formatted_font_family(deploy_mikado_options()->getOptionValue('page_title_google_fonts'));
        }
        if(deploy_mikado_options()->getOptionValue('page_title_fontsize') !== '') {
            $title_styles['font-size'] = deploy_mikado_options()->getOptionValue('page_title_fontsize').'px';
        }
        if(deploy_mikado_options()->getOptionValue('page_title_lineheight') !== '') {
            $title_styles['line-height'] = deploy_mikado_options()->getOptionValue('page_title_lineheight').'px';
        }
        if(deploy_mikado_options()->getOptionValue('page_title_texttransform') !== '') {
            $title_styles['text-transform'] = deploy_mikado_options()->getOptionValue('page_title_texttransform');
        }
        if(deploy_mikado_options()->getOptionValue('page_title_fontstyle') !== '') {
            $title_styles['font-style'] = deploy_mikado_options()->getOptionValue('page_title_fontstyle');
        }
        if(deploy_mikado_options()->getOptionValue('page_title_fontweight') !== '') {
            $title_styles['font-weight'] = deploy_mikado_options()->getOptionValue('page_title_fontweight');
        }
        if(deploy_mikado_options()->getOptionValue('page_title_letter_spacing') !== '') {
            $title_styles['letter-spacing'] = deploy_mikado_options()->getOptionValue('page_title_letter_spacing').'px';
        }

        $title_selector = array(
            '.mkdf-title .mkdf-title-holder h1'
        );

        echo deploy_mikado_dynamic_css($title_selector, $title_styles);


        $subtitle_styles = array();

        if(deploy_mikado_options()->getOptionValue('page_subtitle_color') !== '') {
            $subtitle_styles['color'] = deploy_mikado_options()->getOptionValue('page_subtitle_color');
        }
        if(deploy_mikado_options()->getOptionValue('page_subtitle_google_fonts') !== '-1') {
            $subtitle_styles['font-family'] = deploy_mikado_get_formatted_font_family(deploy_mikado_options()->getOptionValue('page_subtitle_google_fonts'));
        }
        if(deploy_mikado_options()->getOptionValue('page_subtitle_fontsize') !== '') {
            $subtitle_styles['font-size'] = deploy_mikado_options()->getOptionValue('page_subtitle_fontsize').'px';
        }
        if(deploy_mikado_options()->getOptionValue('page_subtitle_lineheight') !== '') {
            $subtitle_styles['line-height'] = deploy_mikado_options()->getOptionValue('page_subtitle_lineheight').'px';
        }
        if(deploy_mikado_options()->getOptionValue('page_subtitle_texttransform') !== '') {
            $subtitle_styles['text-transform'] = deploy_mikado_options()->getOptionValue('page_subtitle_texttransform');
        }
        if(deploy_mikado_options()->getOptionValue('page_subtitle_fontstyle') !== '') {
            $subtitle_styles['font-style'] = deploy_mikado_options()->getOptionValue('page_subtitle_fontstyle');
        }
        if(deploy_mikado_options()->getOptionValue('page_subtitle_fontweight') !== '') {
            $subtitle_styles['font-weight'] = deploy_mikado_options()->getOptionValue('page_subtitle_fontweight');
        }
        if(deploy_mikado_options()->getOptionValue('page_subtitle_letter_spacing') !== '') {
            $subtitle_styles['letter-spacing'] = deploy_mikado_options()->getOptionValue('page_subtitle_letter_spacing').'px';
        }

        $subtitle_selector = array(
            '.mkdf-title .mkdf-title-holder .mkdf-subtitle'
        );

        echo deploy_mikado_dynamic_css($subtitle_selector, $subtitle_styles);


        $breadcrumb_styles = array();

        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_color') !== '') {
            $breadcrumb_styles['color'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_color');
        }
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_google_fonts') !== '-1') {
            $breadcrumb_styles['font-family'] = deploy_mikado_get_formatted_font_family(deploy_mikado_options()->getOptionValue('page_breadcrumb_google_fonts'));
        }
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_fontsize') !== '') {
            $breadcrumb_styles['font-size'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_fontsize').'px';
        }
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_lineheight') !== '') {
            $breadcrumb_styles['line-height'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_lineheight').'px';
        }
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_texttransform') !== '') {
            $breadcrumb_styles['text-transform'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_texttransform');
        }
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_fontstyle') !== '') {
            $breadcrumb_styles['font-style'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_fontstyle');
        }
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_fontweight') !== '') {
            $breadcrumb_styles['font-weight'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_fontweight');
        }
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_letter_spacing') !== '') {
            $breadcrumb_styles['letter-spacing'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_letter_spacing').'px';
        }

        $breadcrumb_selector = array(
            '.mkdf-title .mkdf-title-holder .mkdf-breadcrumbs a, .mkdf-title .mkdf-title-holder .mkdf-breadcrumbs span'
        );

        echo deploy_mikado_dynamic_css($breadcrumb_selector, $breadcrumb_styles);

        $breadcrumb_selector_styles = array();
        if(deploy_mikado_options()->getOptionValue('page_breadcrumb_hovercolor') !== '') {
            $breadcrumb_selector_styles['color'] = deploy_mikado_options()->getOptionValue('page_breadcrumb_hovercolor');
        }

        $breadcrumb_hover_selector = array(
            '.mkdf-title .mkdf-title-holder .mkdf-breadcrumbs a:hover'
        );

        echo deploy_mikado_dynamic_css($breadcrumb_hover_selector, $breadcrumb_selector_styles);

    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_title_area_typography_style');

}


