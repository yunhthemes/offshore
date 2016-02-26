<?php
namespace Deploy\MikadofModules\Shortcodes\ProcessCarousel;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class ProcessCarouselHolder implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkdf_process_carousel_holder';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => 'Mikado Process Carousel',
			'base'                    => $this->getBase(),
			'as_parent'               => array('only' => 'mkdf_process_carousel_item'),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-process-carousel-holder extended-custom-icon',
			'js_view'                 => 'VcColumnView',
			'params'                  => array()
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array();

		$params            = shortcode_atts($default_atts, $atts);
		$params['content'] = $content;

		// Extract tab titles
		preg_match_all('/image="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);
		$items_images = array();

		/**
		 * get tab titles array
		 *
		 */
		if (isset($matches[0])) {
			$items_images = $matches[0];
		}

		$items_images_array = array();

		foreach($items_images as $item_image) {
			preg_match('/image="([^\"]+)"/i', $item_image[0], $tab_matches, PREG_OFFSET_CAPTURE);
			$items_images_array[] = $tab_matches[1][0];
		}

		$params['items_images_array'] = $items_images_array;

		return deploy_mikado_get_shortcode_module_template_part('templates/process-carousel-holder-template', 'process-carousel', '', $params);
	}
}