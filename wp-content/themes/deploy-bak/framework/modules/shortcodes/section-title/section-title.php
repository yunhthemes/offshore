<?php
namespace Deploy\MikadofModules\Shortcodes\SectionTitle;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class SectionTitle implements ShortcodeInterface {
	private $base;

	/**
	 * SectionTitle constructor.
	 */
	public function __construct() {
		$this->base = 'mkdf_section_title';

		add_action('vc_before_init', array($this, 'vcMap'));
	}


	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => 'Section Title',
			'base'                      => $this->base,
			'category'                  => 'by MIKADO',
			'icon'                      => 'icon-wpb-section-title extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'textfield',
					'heading'     => 'Title',
					'param_name'  => 'title',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true,
					'description' => 'Enter title text'
				),
				array(
					'type'        => 'colorpicker',
					'heading'     => 'Title Color',
					'param_name'  => 'title_color',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true,
					'description' => 'Choose color of your title'
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Title Size',
					'param_name'  => 'title_size',
					'value'       => array(
						'Default' => '',
						'Small'   => 'small',
						'Medium'  => 'medium',
						'Large'   => 'large'
					),
					'save_always' => true,
					'admin_label' => true,
					'description' => 'Choose one of predefined title sizes'
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'title'       => '',
			'title_color' => '',
			'title_size'  => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		if($params['title'] !== '') {
			$params['section_title_classes'] = array('mkdf-section-title');

			if($params['title_size'] !== '') {
				$params['section_title_classes'][] = 'mkdf-section-title-'.$params['title_size'];
			}

			$params['section_title_styles'] = array();

			if($params['title_color'] !== '') {
				$params['section_title_styles'][] = 'color: '.$params['title_color'];
			}

			return deploy_mikado_get_shortcode_module_template_part('templates/section-title-template', 'section-title', '', $params);
		}
	}

}
