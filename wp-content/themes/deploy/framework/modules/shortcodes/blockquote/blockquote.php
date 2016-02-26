<?php
namespace Deploy\MikadofModules\Blockquote;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;
/**
 * Class Blockquote
 */
class Blockquote implements ShortcodeInterface {

	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'mkdf_blockquote';

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
	 * Maps shortcode to Visual Composer. Hooked on vc_before_init
	 *
	 * @see mkd_core_get_carousel_slider_array_vc()
	 */
	public function vcMap() {

		vc_map( array(
				'name' => 'Mikado Blockquote',
				'base' => $this->getBase(),
				'category' => 'by MIKADO',
				'icon' => 'icon-wpb-blockquote extended-custom-icon',
				'allowed_container_element' => 'vc_row',
				'params' => array(
					array(
						"type" => "textarea",
						"heading" => "Text",
						"param_name" => "text",
						"value" => "Blockquote text",
						"save_always" => true
					),
					array(
						"type" => "dropdown",
						"heading" => "Title tag",
						"param_name" => "title_tag",
						"value" => array(
							""   => "",
							"h2" => "h2",
							"h3" => "h3",
							"h4" => "h4",
							"h5" => "h5",
							"h6" => "h6",
						),
						"description" => ""
					),
					array(
						"type" => "textfield",
						"heading" => "Width (%)",
						"param_name" => "width"
					)
				)
		) );

	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'text' => '',
			'title_tag' => 'h4',
			'width' => '',
		);

		$params = shortcode_atts($args, $atts);

		$params['blockquote_style'] = $this->getBlockquoteStyle($params);
		$params['blockquote_title_tag'] = $this->getBlockquoteTitleTag($params,$args);

		//Get HTML from template
		$html = deploy_mikado_get_shortcode_module_template_part('templates/blockquote-template', 'blockquote', '', $params);

		return $html;

	}

	/**
	 * Return Style for Blockquote
	 *
	 * @param $params
	 * @return string
	 */
	private function getBlockquoteStyle($params) {
		$blockquote_style = array();

		if ($params['width'] !== '') {
			$width = strstr($params['width'], '%') ? $params['width'] : $params['width'].'%';
			$blockquote_style[] = 'width: '.$width;
		}

		return implode(';', $blockquote_style);
	}

	/**
	 * Return Blockquote Title Tag. If provided heading isn't valid get the default one
	 *
	 * @param $params
	 * @return string
	 */
	private function getBlockquoteTitleTag($params,$args) {
		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');
		return (in_array($params['title_tag'], $headings_array)) ? $params['title_tag'] : $args['title_tag'];
	}
}