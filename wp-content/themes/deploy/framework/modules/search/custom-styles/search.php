<?php

if (!function_exists('deploy_mikado_search_covers_header_style')) {

	function deploy_mikado_search_covers_header_style()
	{

		if (deploy_mikado_options()->getOptionValue('search_height') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-header-bottom.mkdf-animated .mkdf-form-holder-outer, .mkdf-search-slide-header-bottom .mkdf-form-holder-outer, .mkdf-search-slide-header-bottom', array(
				'height' => deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_height')) . 'px'
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_covers_header_style');

}

if (!function_exists('deploy_mikado_search_opener_icon_size')) {

	function deploy_mikado_search_opener_icon_size()
	{

		if (deploy_mikado_options()->getOptionValue('header_search_icon_size')) {
			echo deploy_mikado_dynamic_css('.mkdf-search-opener', array(
				'font-size' => deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('header_search_icon_size')) . 'px'
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_opener_icon_size');

}

if (!function_exists('deploy_mikado_search_opener_icon_colors')) {

	function deploy_mikado_search_opener_icon_colors()
	{

		if (deploy_mikado_options()->getOptionValue('header_search_icon_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-opener', array(
				'color' => deploy_mikado_options()->getOptionValue('header_search_icon_color')
			));
		}

		if (deploy_mikado_options()->getOptionValue('header_search_icon_hover_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-opener:hover', array(
				'color' => deploy_mikado_options()->getOptionValue('header_search_icon_hover_color')
			));
		}

		if (deploy_mikado_options()->getOptionValue('header_light_search_icon_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-light-header .mkdf-page-header > div:not(.mkdf-sticky-header) .mkdf-search-opener,
			.mkdf-light-header.mkdf-header-style-on-scroll .mkdf-page-header .mkdf-search-opener,
			.mkdf-light-header .mkdf-top-bar .mkdf-search-opener', array(
				'color' => deploy_mikado_options()->getOptionValue('header_light_search_icon_color') . ' !important'
			));
		}

		if (deploy_mikado_options()->getOptionValue('header_light_search_icon_hover_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-light-header .mkdf-page-header > div:not(.mkdf-sticky-header) .mkdf-search-opener:hover,
			.mkdf-light-header.mkdf-header-style-on-scroll .mkdf-page-header .mkdf-search-opener:hover,
			.mkdf-light-header .mkdf-top-bar .mkdf-search-opener:hover', array(
				'color' => deploy_mikado_options()->getOptionValue('header_light_search_icon_hover_color') . ' !important'
			));
		}

		if (deploy_mikado_options()->getOptionValue('header_dark_search_icon_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-dark-header .mkdf-page-header > div:not(.mkdf-sticky-header) .mkdf-search-opener,
			.mkdf-dark-header.mkdf-header-style-on-scroll .mkdf-page-header .mkdf-search-opener,
			.mkdf-dark-header .mkdf-top-bar .mkdf-search-opener', array(
				'color' => deploy_mikado_options()->getOptionValue('header_dark_search_icon_color') . ' !important'
			));
		}
		if (deploy_mikado_options()->getOptionValue('header_dark_search_icon_hover_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-dark-header .mkdf-page-header > div:not(.mkdf-sticky-header) .mkdf-search-opener:hover,
			.mkdf-dark-header.mkdf-header-style-on-scroll .mkdf-page-header .mkdf-search-opener:hover,
			.mkdf-dark-header .mkdf-top-bar .mkdf-search-opener:hover', array(
				'color' => deploy_mikado_options()->getOptionValue('header_dark_search_icon_hover_color') . ' !important'
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_opener_icon_colors');

}

if (!function_exists('deploy_mikado_search_opener_icon_background_colors')) {

	function deploy_mikado_search_opener_icon_background_colors()
	{

		if (deploy_mikado_options()->getOptionValue('search_icon_background_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-opener', array(
				'background-color' => deploy_mikado_options()->getOptionValue('search_icon_background_color')
			));
		}

		if (deploy_mikado_options()->getOptionValue('search_icon_background_hover_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-opener:hover', array(
				'background-color' => deploy_mikado_options()->getOptionValue('search_icon_background_hover_color')
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_opener_icon_background_colors');
}

if (!function_exists('deploy_mikado_search_opener_text_styles')) {

	function deploy_mikado_search_opener_text_styles()
	{
		$text_styles = array();

		if (deploy_mikado_options()->getOptionValue('search_icon_text_color') !== '') {
			$text_styles['color'] = deploy_mikado_options()->getOptionValue('search_icon_text_color');
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_text_fontsize') !== '') {
			$text_styles['font-size'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_icon_text_fontsize')) . 'px';
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_text_lineheight') !== '') {
			$text_styles['line-height'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_icon_text_lineheight')) . 'px';
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_text_texttransform') !== '') {
			$text_styles['text-transform'] = deploy_mikado_options()->getOptionValue('search_icon_text_texttransform');
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_text_google_fonts') !== '-1') {
			$text_styles['font-family'] = deploy_mikado_get_formatted_font_family(deploy_mikado_options()->getOptionValue('search_icon_text_google_fonts')) . ', sans-serif';
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_text_fontstyle') !== '') {
			$text_styles['font-style'] = deploy_mikado_options()->getOptionValue('search_icon_text_fontstyle');
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_text_fontweight') !== '') {
			$text_styles['font-weight'] = deploy_mikado_options()->getOptionValue('search_icon_text_fontweight');
		}

		if (!empty($text_styles)) {
			echo deploy_mikado_dynamic_css('.mkdf-search-icon-text', $text_styles);
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_text_color_hover') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-opener:hover .mkdf-search-icon-text', array(
				'color' => deploy_mikado_options()->getOptionValue('search_icon_text_color_hover')
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_opener_text_styles');
}

if (!function_exists('deploy_mikado_search_opener_spacing')) {

	function deploy_mikado_search_opener_spacing()
	{
		$spacing_styles = array();

		if (deploy_mikado_options()->getOptionValue('search_padding_left') !== '') {
			$spacing_styles['padding-left'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_padding_left')) . 'px';
		}
		if (deploy_mikado_options()->getOptionValue('search_padding_right') !== '') {
			$spacing_styles['padding-right'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_padding_right')) . 'px';
		}
		if (deploy_mikado_options()->getOptionValue('search_margin_left') !== '') {
			$spacing_styles['margin-left'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_margin_left')) . 'px';
		}
		if (deploy_mikado_options()->getOptionValue('search_margin_right') !== '') {
			$spacing_styles['margin-right'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_margin_right')) . 'px';
		}

		if (!empty($spacing_styles)) {
			echo deploy_mikado_dynamic_css('.mkdf-search-opener', $spacing_styles);
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_opener_spacing');
}

if (!function_exists('deploy_mikado_search_bar_background')) {

	function deploy_mikado_search_bar_background()
	{

		if (deploy_mikado_options()->getOptionValue('search_background_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-header-bottom, .mkdf-search-cover, .mkdf-search-fade .mkdf-fullscreen-search-holder .mkdf-fullscreen-search-table, .mkdf-fullscreen-search-overlay, .mkdf-search-slide-window-top, .mkdf-search-slide-window-top input[type="text"]', array(
				'background-color' => deploy_mikado_options()->getOptionValue('search_background_color')
			));
		}
	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_bar_background');
}

if (!function_exists('deploy_mikado_search_text_styles')) {

	function deploy_mikado_search_text_styles()
	{
		$text_styles = array();

		if (deploy_mikado_options()->getOptionValue('search_text_color') !== '') {
			$text_styles['color'] = deploy_mikado_options()->getOptionValue('search_text_color');
		}
		if (deploy_mikado_options()->getOptionValue('search_text_fontsize') !== '') {
			$text_styles['font-size'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_text_fontsize')) . 'px';
		}
		if (deploy_mikado_options()->getOptionValue('search_text_texttransform') !== '') {
			$text_styles['text-transform'] = deploy_mikado_options()->getOptionValue('search_text_texttransform');
		}
		if (deploy_mikado_options()->getOptionValue('search_text_google_fonts') !== '-1') {
			$text_styles['font-family'] = deploy_mikado_get_formatted_font_family(deploy_mikado_options()->getOptionValue('search_text_google_fonts')) . ', sans-serif';
		}
		if (deploy_mikado_options()->getOptionValue('search_text_fontstyle') !== '') {
			$text_styles['font-style'] = deploy_mikado_options()->getOptionValue('search_text_fontstyle');
		}
		if (deploy_mikado_options()->getOptionValue('search_text_fontweight') !== '') {
			$text_styles['font-weight'] = deploy_mikado_options()->getOptionValue('search_text_fontweight');
		}
		if (deploy_mikado_options()->getOptionValue('search_text_letterspacing') !== '') {
			$text_styles['letter-spacing'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_text_letterspacing')) . 'px';
		}

		if (!empty($text_styles)) {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-header-bottom input[type="text"], .mkdf-search-cover input[type="text"], .mkdf-fullscreen-search-holder .mkdf-search-field, .mkdf-search-slide-window-top input[type="text"]', $text_styles);
		}
		if (deploy_mikado_options()->getOptionValue('search_text_disabled_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-header-bottom.mkdf-disabled input[type="text"]::-webkit-input-placeholder, .mkdf-search-slide-header-bottom.mkdf-disabled input[type="text"]::-moz-input-placeholder', array(
				'color' => deploy_mikado_options()->getOptionValue('search_text_disabled_color')
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_text_styles');
}

if (!function_exists('deploy_mikado_search_label_styles')) {

	function deploy_mikado_search_label_styles()
	{
		$text_styles = array();

		if (deploy_mikado_options()->getOptionValue('search_label_text_color') !== '') {
			$text_styles['color'] = deploy_mikado_options()->getOptionValue('search_label_text_color');
		}
		if (deploy_mikado_options()->getOptionValue('search_label_text_fontsize') !== '') {
			$text_styles['font-size'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_label_text_fontsize')) . 'px';
		}
		if (deploy_mikado_options()->getOptionValue('search_label_text_texttransform') !== '') {
			$text_styles['text-transform'] = deploy_mikado_options()->getOptionValue('search_label_text_texttransform');
		}
		if (deploy_mikado_options()->getOptionValue('search_label_text_google_fonts') !== '-1') {
			$text_styles['font-family'] = deploy_mikado_get_formatted_font_family(deploy_mikado_options()->getOptionValue('search_label_text_google_fonts')) . ', sans-serif';
		}
		if (deploy_mikado_options()->getOptionValue('search_label_text_fontstyle') !== '') {
			$text_styles['font-style'] = deploy_mikado_options()->getOptionValue('search_label_text_fontstyle');
		}
		if (deploy_mikado_options()->getOptionValue('search_label_text_fontweight') !== '') {
			$text_styles['font-weight'] = deploy_mikado_options()->getOptionValue('search_label_text_fontweight');
		}
		if (deploy_mikado_options()->getOptionValue('search_label_text_letterspacing') !== '') {
			$text_styles['letter-spacing'] = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_label_text_letterspacing')) . 'px';
		}

		if (!empty($text_styles)) {
			echo deploy_mikado_dynamic_css('.mkdf-fullscreen-search-holder .mkdf-search-label', $text_styles);
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_label_styles');
}

if (!function_exists('deploy_mikado_search_icon_styles')) {

	function deploy_mikado_search_icon_styles()
	{

		if (deploy_mikado_options()->getOptionValue('search_icon_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-window-top > i, .mkdf-search-slide-header-bottom .mkdf-search-submit i, .mkdf-fullscreen-search-holder .mkdf-search-submit', array(
				'color' => deploy_mikado_options()->getOptionValue('search_icon_color')
			));
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_hover_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-window-top > i:hover, .mkdf-search-slide-header-bottom .mkdf-search-submit i:hover, .mkdf-fullscreen-search-holder .mkdf-search-submit:hover', array(
				'color' => deploy_mikado_options()->getOptionValue('search_icon_hover_color')
			));
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_disabled_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-header-bottom.mkdf-disabled .mkdf-search-submit i, .mkdf-search-slide-header-bottom.mkdf-disabled .mkdf-search-submit i:hover', array(
				'color' => deploy_mikado_options()->getOptionValue('search_icon_disabled_color')
			));
		}
		if (deploy_mikado_options()->getOptionValue('search_icon_size') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-window-top > i, .mkdf-search-slide-header-bottom .mkdf-search-submit i, .mkdf-fullscreen-search-holder .mkdf-search-submit', array(
				'font-size' => deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_icon_size')) . 'px'
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_icon_styles');
}

if (!function_exists('deploy_mikado_search_close_icon_styles')) {

	function deploy_mikado_search_close_icon_styles()
	{

		if (deploy_mikado_options()->getOptionValue('search_close_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-window-top .mkdf-search-close i, .mkdf-search-cover .mkdf-search-close i, .mkdf-fullscreen-search-close i', array(
				'color' => deploy_mikado_options()->getOptionValue('search_close_color')
			));
		}
		if (deploy_mikado_options()->getOptionValue('search_close_hover_color') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-window-top .mkdf-search-close i:hover, .mkdf-search-cover .mkdf-search-close i:hover, .mkdf-fullscreen-search-close i:hover', array(
				'color' => deploy_mikado_options()->getOptionValue('search_close_hover_color')
			));
		}
		if (deploy_mikado_options()->getOptionValue('search_close_size') !== '') {
			echo deploy_mikado_dynamic_css('.mkdf-search-slide-window-top .mkdf-search-close i, .mkdf-search-cover .mkdf-search-close i, .mkdf-fullscreen-search-close i', array(
				'font-size' => deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('search_close_size')) . 'px'
			));
		}

	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_search_close_icon_styles');
}

?>
