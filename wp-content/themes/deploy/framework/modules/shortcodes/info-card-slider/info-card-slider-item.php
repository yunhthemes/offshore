<?php
namespace Deploy\MikadofModules\Shortcodes\InfoCardSlider;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class InfoCardSliderItem implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkdf_info_cart_slider_item';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => 'Info Card Slider Item',
			'base'                    => $this->base,
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-info-card-slider-item extended-custom-icon',
			'as_parent'               => array('except' => 'vc_row'),
			'as_child'                => array('only' => 'mkdf_info_card_slider'),
			'is_container'            => true,
			'show_settings_on_create' => true,
			'params'                  => array_merge(
				deploy_mikado_icon_collections()->getVCParamsArray(array(), '', true),
				array(
					array(
						'type'        => 'attach_image',
						'holder'      => 'div',
						'heading'     => 'Custom Icon',
						'param_name'  => 'custom_icon',
						'admin_label' => true
					),
					array(
						'type'        => 'textarea',
						'heading'     => 'Content',
						'description' => 'Insert text for card content',
						'param_name'  => 'card_content',
						'admin_label' => true
					),
					array(
						'type'         => 'textfield',
						'heading'      => 'Link',
						'descripition' => 'Insert card link',
						'param_name'   => 'link',
						'admin_label'  => true
					),
					array(
						'type'        => 'dropdown',
						'heading'     => 'Link Target',
						'param_name'  => 'link_target',
						'value'       => array(
							'Self'  => '_self',
							'Blank' => '_blank'
						),
						'save_always' => true,
						'dependency'  => array('element' => 'link', 'not_empty' => true),
						'admin_label' => true
					),
					array(
						'type'        => 'textfield',
						'heading'     => 'Link Text',
						'param_name'  => 'link_text',
						'value'       => '',
						'save_always' => true,
						'dependency'  => array('element' => 'link', 'not_empty' => true),
						'admin_label' => true
					)
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'card_content' => '',
			'link'         => '',
			'link_target'  => '',
			'custom_icon'  => '',
			'link_text'    => ''
		);

		$default_atts = array_merge($default_atts, deploy_mikado_icon_collections()->getShortcodeParams());
		$params       = shortcode_atts($default_atts, $atts);

		$iconPackName   = deploy_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
		$params['icon'] = $iconPackName ? $params[$iconPackName] : '';
		$params['link'] = !empty($params['link']) ? $params['link'] : 'javascript: void(0)';

		if(empty($params['icon'])) {
			$params['show_custom_icon'] = $params['custom_icon'] !== '';
			$params['show_icon']        = $params['show_custom_icon'];
		} else {
			$params['show_icon'] = $params['icon'] !== '';
		}

		return deploy_mikado_get_shortcode_module_template_part('templates/info-card-slider-item', 'info-card-slider', '', $params);
	}
}