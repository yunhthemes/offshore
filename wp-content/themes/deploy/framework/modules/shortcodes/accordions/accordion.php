<?php
namespace Deploy\MikadofModules\Accordion;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;
/**
	* class Accordions
*/
class Accordion implements ShortcodeInterface{
	/**
	 * @var string
	 */
	private $base;

	function __construct() {
		$this->base = 'mkdf_accordion';
		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return	$this->base;
	}

	public function vcMap() {

		vc_map( array(
			'name' =>  esc_html__( 'Mikado Accordion', 'deploy'),
			'base' => $this->base,
			'as_parent' => array('only' => 'mkdf_accordion_tab'),
			'content_element' => true,
			'category' => 'by MIKADO',
			'icon' => 'icon-wpb-accordion extended-custom-icon',
			'show_settings_on_create' => true,
			'js_view' => 'VcColumnView',
			'params' => array(
				array(
					'type' => 'textfield',
					'heading' => esc_html__( 'Extra class name', 'deploy'),
					'param_name' => 'el_class',
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'deploy')
				),
				array(
					'type' => 'dropdown',
					'class' => '',
					'heading' => 'Style',
					'param_name' => 'style',
					'value' => array(
						'Accordion'             => 'accordion',
						'Boxed Accordion'       => 'boxed_accordion',
						'Toggle'                => 'toggle',
						'Boxed Toggle'          => 'boxed_toggle'
					),
					'save_always' => true,
					'description' => ''
				)
			)
		) );
	}
	public function render($atts, $content = null) {
		$default_atts=(array(
			'title' => '',
			'style' => 'accordion'
		));
		$params = shortcode_atts($default_atts, $atts);
		extract($params);
		
 		$acc_class = $this->getAccordionClasses($params);
		$params['acc_class'] = $acc_class;
		$params['content'] = $content;
		
		$output = '';
		
		$output .= deploy_mikado_get_shortcode_module_template_part('templates/accordion-holder-template','accordions', '', $params);

		return $output;
	}

	/**
	   * Generates accordion classes
	   *
	   * @param $params
	   *
	   * @return string
	*/
	private function getAccordionClasses($params){
		
		$acc_class = '';
		$style = $params['style'];
		switch($style) {
			case 'toggle':
				$acc_class .= 'mkdf-toggle mkdf-initial';
				break;
			case 'boxed_toggle':
				$acc_class .= 'mkdf-toggle mkdf-boxed';
				break;
			case 'boxed_accordion':
				$acc_class .= 'mkdf-accordion mkdf-boxed';
				break;			
			default:
				$acc_class = 'mkdf-accordion mkdf-initial';
		}
		return $acc_class;
	}
}
