<?php
namespace Deploy\MikadofModules\Shortcodes\InfoCardSlider;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class InfoCardSlider implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkdf_info_card_slider';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => 'Info Card Slider',
			'base'                    => $this->base,
			'as_parent'               => array('only' => 'mkdf_info_cart_slider_item'),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-info-card-slider extended-custom-icon',
			'js_view'                 => 'VcColumnView',
			'params'                  => array(
				array(
					'type'        => 'dropdown',
					'heading'     => 'Add Left / Right Padding',
					'param_name'  => 'holder_padding',
					'value'       => array(
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true,
					'admin_label' => true
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'holder_padding' => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		$params['content'] = $content;

		$params['holder_classes'] = array('mkdf-info-card-slider mkdf-carousel-navigation');

		if($params['holder_padding'] === 'yes') {
			$params['holder_classes'][] = 'mkdf-info-card-slider-with-padding';
		}

		return deploy_mikado_get_shortcode_module_template_part('templates/info-card-slider-holder', 'info-card-slider', '', $params);
	}

}