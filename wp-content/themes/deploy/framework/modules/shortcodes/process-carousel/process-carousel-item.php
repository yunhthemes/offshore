<?php
namespace Deploy\MikadofModules\Shortcodes\ProcessCarousel;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class ProcessCarouselItem implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkdf_process_carousel_item';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => 'Mikado Process Carousel Item',
			'base'                    => $this->getBase(),
			'as_child'                => array('only' => 'mkdf_process_carousel_holder'),
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-process-carousel-item extended-custom-icon',
			'show_settings_on_create' => true,
			'params'                  => array(
				array(
					'type'        => 'textfield',
					'heading'     => 'Title',
					'param_name'  => 'title',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				),
				array(
					'type'        => 'textarea',
					'heading'     => 'Text',
					'param_name'  => 'text',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Digit',
					'param_name'  => 'digit',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				),
				array(
					'type'        => 'attach_image',
					'heading'     => 'Image',
					'param_name'  => 'image',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Link',
					'param_name'  => 'link',
					'value'       => '',
					'save_always' => true,
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Link Target',
					'param_name'  => 'link_target',
					'value'       => array(
						'Same Window' => '',
						'New Window'  => '_blank'
					),
					'save_always' => true,
					'admin_label' => true,
					'dependency'  => array('element' => 'link', 'not_empty' => true)
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'title'       => '',
			'text'        => '',
			'digit'       => '',
			'image'       => '',
			'link'        => '',
			'link_target' => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		return deploy_mikado_get_shortcode_module_template_part('templates/process-carousel-item-template', 'process-carousel', '', $params);
	}

}