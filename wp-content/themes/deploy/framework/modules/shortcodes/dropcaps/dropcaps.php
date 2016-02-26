<?php
namespace Deploy\MikadofModules\Dropcaps;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;
/**
 * Class Dropcaps
 */
class Dropcaps implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'mkdf_dropcaps';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	/**
	 * Returns base for shortcode
	 * @return string
	 */
	public function getBase() {
		return $this->base;
	}

	/*
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 *
	 * @see mkd_core_get_carousel_slider_array_vc()
	 */
	 
	public function vcMap() {
	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'type' => '',
			'color' => '',
			'background_color' => '',
			'border_color' => ''
		);

		$params = shortcode_atts($args, $atts);

		$params['letter'] = $content;
		$params['dropcaps_style'] = $this->getDropcapsStyle($params);
		$params['dropcaps_class'] = $this->getDropcapsClass($params);

		//Get HTML from template
		$html = deploy_mikado_get_shortcode_module_template_part('templates/dropcaps-template', 'dropcaps', '', $params);

		return $html;

	}

	/**
	 * Return Style for Dropcaps
	 *
	 * @param $params
	 * @return string
	 */
	private function getDropcapsStyle($params) {
		$dropcaps_style = array();

		if ($params['color'] !== '') {
			$dropcaps_style[] = 'color: '.$params['color'];
		}

		if ((($params['type'] == 'square') || ($params['type'] == 'circle')) && ($params['background_color'] !== '')) {
			$dropcaps_style[] = 'background-color: '.$params['background_color'];
		}

		if ((($params['type'] == 'square') || ($params['type'] == 'circle')) && ($params['border_color'] !== '')) {
			$dropcaps_style[] = 'border: ' .'1px solid ' .$params['border_color'];
		}

		return implode(';', $dropcaps_style);
	}

	/**
	 * Return Class for Dropcaps
	 *
	 * @param $params
	 * @return string
	 */
	private function getDropcapsClass($params) {
		return ($params['type'] !== '') ? 'mkdf-'.$params['type'] : '';
	}
}