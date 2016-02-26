<?php

namespace Deploy\MikadofModules\AccordionTab;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

/**
 * class Accordions
 */
class AccordionTab implements ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	function __construct() {
		$this->base = 'mkdf_accordion_tab';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		if(function_exists('vc_map')) {
			vc_map(array(
				"name"                    => esc_html__('Mikado Accordion Tab', 'deploy'),
				"base"                    => $this->base,
				"as_parent"               => array('except' => 'vc_row'),
				"as_child"                => array('only' => 'mkdf_accordion'),
				'is_container'            => true,
				"category"                => 'by MIKADO',
				"icon"                    => "icon-wpb-accordion-section extended-custom-icon",
				"show_settings_on_create" => true,
				"js_view"                 => 'VcColumnView',
				'params'                  => array_merge(
					deploy_mikado_icon_collections()->getVCParamsArray(array(), '', true),
					array(
						array(
							'type'        => 'textfield',
							'heading'     => esc_html__('Title', 'deploy'),
							'param_name'  => 'title',
							'admin_label' => true,
							'value'       => esc_html__('Section', 'deploy'),
							'description' => esc_html__('Enter accordion section title.', 'deploy')
						),
						array(
							'type'        => 'el_id',
							'heading'     => esc_html__('Section ID', 'deploy'),
							'param_name'  => 'el_id',
							'description' => sprintf(esc_html__('Enter optional row ID. Make sure it is unique, and it is valid as w3c specification: %s (Must not have spaces)', 'deploy'), '<a target="_blank" href="http://www.w3schools.com/tags/att_global_id.asp">'.esc_html__('link', 'deploy').'</a>'),
						),
						array(
							'type'        => 'dropdown',
							'class'       => '',
							'heading'     => 'Title Tag',
							'param_name'  => 'title_tag',
							'value'       => array(
								''   => '',
								'p'  => 'p',
								'h2' => 'h2',
								'h3' => 'h3',
								'h4' => 'h4',
								'h5' => 'h5',
								'h6' => 'h6',
							),
							'description' => ''
						),
						array(
							'type'        => 'textfield',
							'heading'     => 'Link',
							'param_name'  => 'link',
							'admin_label' => true,
							'value'       => '',
							'description' => 'Enter link for this accordion tab'
						),
						array(
							'type'        => 'textfield',
							'heading'     => 'Link Text',
							'param_name'  => 'link_text',
							'admin_label' => true,
							'value'       => '',
							'description' => 'Enter link for this accordion tab',
							'dependency'  => array('element' => 'link', 'not_empty' => true)
						),
						array(
							'type'        => 'dropdown',
							'heading'     => 'Link Target',
							'param_name'  => 'link_target',
							'admin_label' => true,
							'value'       => array(
								'Same Window' => '',
								'New Window'  => '_blank'
							),
							'save_always' => true,
							'description' => 'Choose link target for this accordion tab',
							'dependency'  => array('element' => 'link', 'not_empty' => true)
						)
					)
				)
			));
		}
	}

	public function render($atts, $content = null) {

		$default_atts = (array(
			'title'       => 'Accordion Title',
			'title_tag'   => 'h4',
			'el_id'       => '',
			'link'        => '',
			'link_target' => '',
			'link_text'   => ''
		));

		$default_atts = array_merge($default_atts, deploy_mikado_icon_collections()->getShortcodeParams());
		$params       = shortcode_atts($default_atts, $atts);

		$iconPackName   = deploy_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
		$params['icon'] = $iconPackName ? $params[$iconPackName] : '';

		$params['link_params'] = $this->getLinkParams($params);

		extract($params);
		$params['content'] = $content;

		$output = '';

		$output .= deploy_mikado_get_shortcode_module_template_part('templates/accordion-template', 'accordions', '', $params);

		return $output;

	}

	private function getLinkParams($params) {
		$linkParams = array();

		if(!empty($params['link']) && !empty($params['link_text'])) {
			$linkParams['link'] = $params['link'];
			$linkParams['link_text'] = $params['link_text'];

			$linkParams['link_target'] = !empty($params['link_target']) ? $params['link_target'] : '_self';
		}

		return $linkParams;
	}

}