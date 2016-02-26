<?php

namespace MikadoCore\CPT\Testimonials\Shortcodes;


use MikadoCore\Lib;

/**
 * Class Testimonials
 * @package MikadoCore\CPT\Testimonials\Shortcodes
 */
class Testimonials implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'mkdf_testimonials';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/**
	 * Maps shortcode to Visual Composer
	 *
	 * @see vc_map()
	 */
	public function vcMap() {
		if(function_exists('vc_map')) {
			vc_map(array(
				'name'                      => 'Testimonials',
				'base'                      => $this->base,
				'category'                  => 'by MIKADO',
				'icon'                      => 'icon-wpb-testimonials extended-custom-icon',
				'allowed_container_element' => 'vc_row',
				'params'                    => array(
					array(
						'type'        => 'dropdown',
						'heading'     => 'Choose Testimonial Type',
						'param_name'  => 'testimonial_type',
						'value'       => array(
							'Slider'   => 'slider',
							'Carousel' => 'carousel'
						),
						'save_always' => true,
						'admin_label' => true,
						'description' => ''
					),
					array(
						'type'        => 'textfield',
						'heading'     => 'Category',
						'param_name'  => 'category',
						'value'       => '',
						'description' => 'Category Slug (leave empty for all)'
					),
					array(
						'type'        => 'textfield',
						'heading'     => 'Number',
						'param_name'  => 'number',
						'value'       => '',
						'description' => 'Number of Testimonials'
					),
					array(
						'type'        => 'dropdown',
						'heading'     => 'Enable Autoplay',
						'param_name'  => 'autoplay_enabled',
						'value'       => array(
							''    => '',
							'Yes' => 'yes',
							'No'  => 'no'
						),
						'save_always' => true,
						'description' => 'Enable automatic change of testimonials'
					),
					array(
						'type'        => 'dropdown',
						'heading'     => 'Set Quote',
						'param_name'  => 'quote_title',
						'value'       => array(
							'Yes' => 'yes',
							'No'  => 'no'
						),
						'save_always' => true,
						'description' => 'Add a quote on your title',
					    'dependency'  => array('element' => 'testimonial_type', 'value' => 'slider')
					),
					array(
						'type'        => 'textfield',
						'heading'     => 'Slider title',
						'param_name'  => 'testimonial_title',
						'value'       => '',
						'description' => 'Add your title for testimonial slider',
						'dependency'  => array('element' => 'testimonial_type', 'value' => 'slider')
					),
					array(
						'type'        => 'dropdown',
						'heading'     => 'Show Author',
						'param_name'  => 'show_author',
						'value'       => array(
							'Yes' => 'yes',
							'No'  => 'no'
						),
						'save_always' => true,
						'description' => '',
						'group'       => 'Design Options'
					),
					array(
						'type'        => 'dropdown',
						'heading'     => 'Show Navigation',
						'param_name'  => 'show_navigation',
						'value'       => array(
							'Yes' => 'yes',
							'No'  => 'no'
						),
						'save_always' => true,
						'description' => '',
						'group'       => 'Design Options',
						'dependency'  => array('element' => 'testimonial_type', 'value' => 'carousel')
					),
					array(
						'type'        => 'dropdown',
						'heading'     => 'Navigation Style',
						'param_name'  => 'navigation_style',
						'value'       => array(
							'Dark'    => 'dark',
							'Light'   => 'light'
						),
						'save_always' => true,
						'group'       => 'Design Options',
						'dependency'  => array('element' => 'show_navigation', 'value' => 'yes')
					),
					array(
						'type'        => 'dropdown',
						'heading'     => 'Slider Navigation Style',
						'param_name'  => 'nav_style',
						'value'       => array(
							'Dark'    => 'dark',
							'Light'   => 'light'
						),
						'save_always' => true,
						'group'       => 'Design Options',
						'dependency'  => array('element' => 'testimonial_type', 'value' => 'slider')
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'content_background_color',
						'heading'    => 'Content Background Color',
						'group'      => 'Design Options'
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'author_color',
						'heading'    => 'Author Name Color',
						'group'      => 'Design Options'
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'text_color',
						'heading'    => 'Text Color',
						'group'      => 'Design Options'
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'title_color',
						'heading'    => 'Title Color',
						'group'      => 'Design Options',
					    'dependency'  => array('element' => 'testimonial_type', 'value' => 'slider')
					),
					array(
						'type'       => 'colorpicker',
						'param_name' => 'author_background_color',
						'heading'    => 'Author Name Background Color',
						'group'      => 'Design Options',
						'dependency' => array('element' => 'testimonial_type', 'value' => 'carousel')
					)
				)
			));
		}
	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @param $content string shortcode content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args   = array(
			'testimonial_type'         => 'slider',
			'number'                   => '-1',
			'category'                 => '',
			'testimonial_title'        => '',
			'show_author'              => 'yes',
			'show_navigation'          => '',
			'navigation_style'         => '',
			'quote_title'              => '',
			'nav_style'                => '',
			'content_background_color' => '',
			'author_color'             => '',
			'text_color'               => '',
			'title_color'              => '',
			'author_background_color'  => '',
			'autoplay_enabled'         => ''
		);
		$params = shortcode_atts($args, $atts);

		//Extract params for use in method
		extract($params);

		if($params['autoplay_enabled'] == '') {
			$params['autoplay_enabled'] = $params['testimonial_type'] == 'slider' ? 'yes' : 'no';
		}


		$data_attr  = $this->getDataParams($params);
		$query_args = $this->getQueryParams($params);

		$holder_classes = array(
			'mkdf-testimonials-holder',
			'mkdf-testimonials-'.$params['testimonial_type'],
			'clearfix',
			'mkdf-carousel-navigation'
		);

		if($quote_title === 'yes') {
			$holder_classes[] = 'mkdf-slider-with-quote';
		}

		if(!empty($params['navigation_style'])) {
			$holder_classes[] = 'mkdf-carousel-navigation-'.$params['navigation_style'];
		}

		if(($params['navigation_style']) == 'dark') {
			$holder_classes[] = 'mkdf-carousel-navigation-'.$params['navigation_style'];
		}

		if(($params['nav_style']) == 'dark') {
			$holder_classes[] = 'mkdf-slider-navigation-'.$params['nav_style'];
		}


		$titleStyles = $this->getTitleStyles($params);


		$html = '';
		$html .= '<div '.mkd_core_get_class_attribute($holder_classes).'>';
		if ($quote_title == 'yes') {
			$html .= '<span class="mkdf-quote-title">'.'<span aria-hidden="true" class="icon_quotations"></span>'.'</span>';
		}

		if ($testimonial_title !=='') {
			$html .= '<h2 class="mkdf-testimonial-title" '.deploy_mikado_get_inline_style($titleStyles).'>'.$testimonial_title.'</h2>';
		}
		$html .= '<div class="mkdf-testimonials" '.mkd_core_get_inline_attrs($data_attr).'>';
		$html .= '</div>';
		$html .= '<div class="mkdf-testimonials" '.mkd_core_get_inline_attrs($data_attr).'>';

		query_posts($query_args);
		if(have_posts()) :
			while(have_posts()) : the_post();
				$author = get_post_meta(get_the_ID(), 'mkdf_testimonial_author', true);
				$text   = get_post_meta(get_the_ID(), 'mkdf_testimonial_text', true);
				$title  = get_post_meta(get_the_ID(), 'mkdf_testimonial_title', true);
				$job    = get_post_meta(get_the_ID(), 'mkdf_testimonial_job', true);

				$params['author']         = $author;
				$params['text']           = $text;
				$params['title']          = $title;
				$params['job']            = $job;
				$params['current_id']     = get_the_ID();
				$params['content_styles'] = $this->getContentStyles($params);
				$params['author_styles']  = $this->getAuthorStyles($params);
				$params['holder_classes'] = $this->getHolderClasses($params);

				$html .= mkd_core_get_shortcode_module_template_part('testimonials', 'testimonials-template', $params['testimonial_type'], $params);

			endwhile;
		else:
			$html .= __('Sorry, no posts matched your criteria.', 'mkd_core');
		endif;

		wp_reset_query();
		$html .= '</div>';
		$html .= '</div>';

		return $html;
	}

	/**
	 * Generates testimonial data attribute array
	 *
	 * @param $params
	 *
	 * @return string
	 */
	private function getDataParams($params) {
		$data_attr = array();

		if(!empty($params['show_navigation'])) {
			$data_attr['data-show-navigation'] = $params['show_navigation'];
		}

		if(!empty($params['autoplay_enabled'])) {
			$data_attr['data-autoplay'] = $params['autoplay_enabled'];
		}

		return $data_attr;
	}

	/**
	 * Generates testimonials query attribute array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getQueryParams($params) {

		$args = array(
			'post_type'      => 'testimonials',
			'orderby'        => 'date',
			'order'          => 'DESC',
			'posts_per_page' => $params['number']
		);

		if($params['category'] != "") {
			$args['testimonials_category'] = $params['category'];
		}

		return $args;
	}

	private function getContentStyles($params) {
		$styles = array();

		if(!empty($params['content_background_color'])) {
			$styles[] = 'background-color: '.$params['content_background_color'];
		}

		if(!empty($params['text_color'])) {
			$styles[] = 'color: '.$params['text_color'];
		}

		return $styles;
	}

	private function getAuthorStyles($params) {
		$styles = array();

		if(!empty($params['author_color'])) {
			$styles[] = 'color: '.$params['author_color'];
		}

		if($params['testimonial_type'] == 'carousel' && !empty($params['author_background_color'])) {
			$styles[] = 'background-color: '.$params['author_background_color'];
		}

		return $styles;
	}

	private function getHolderClasses($params) {
		$classes = array();

		if($params['testimonial_type'] == 'carousel') {
			$classes[] = 'mkdf-testimonial-content';
		}

		return $classes;
	}

	private function getTitleStyles($params) {
		$styles = array();

		if($params['title_color'] !== '') {
			$styles[] = 'color: '.$params['title_color'];
		}

		return $styles;
	}
}