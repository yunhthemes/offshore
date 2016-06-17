<?php
namespace Deploy\MikadofModules\OrderedList;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class OrderedList implements ShortcodeInterface{
	private $base;
	function __construct() {
		$this->base = 'mkdf_list_ordered';
		add_action('vc_before_init', array($this, 'vcMap'));
	}
	public function getBase() {
		return $this->base;
	}
	public function vcMap() {

		vc_map( array(
			'name' => 'Mikado List - Ordered',
			'base' => $this->base,
			'icon' => 'icon-wpb-ordered-list extended-custom-icon',
			'category' => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'params' => array(
				array(
					'type' => 'textarea_html',
					'holder' => 'div',
					'class' => '',
					'heading' => 'Content',
					'param_name' => 'content',
					'value' => '<ol><li>Lorem Ipsum</li><li>Lorem Ipsum</li><li>Lorem Ipsum</li></ol>',
					'description' => ''
				)
			)
		) );

	}

	public function render($atts, $content = null) {
		$html = '';
		$html .= '<div class= "mkdf-ordered-list" >' . do_shortcode($content) . '</div>';
        return $html;
	}
	
}

