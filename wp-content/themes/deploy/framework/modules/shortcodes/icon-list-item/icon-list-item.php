<?php
namespace Deploy\MikadofModules\IconListItem;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Icon List Item
 */

class IconListItem implements ShortcodeInterface{
	/**
	 * @var string
	 */
	private $base;
	function __construct() {
		$this->base = 'mkdf_icon_list_item';
		
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
	 */
	
	public function vcMap() {
		vc_map( array(
			'name' => 'Mikado Icon List Item',
			'base' => $this->base,
			'icon' => 'icon-wpb-icon-list-item extended-custom-icon',
			'category' => 'by MIKADO',
			'params' => array_merge(
				\DeployMikadoIconCollections::get_instance()->getVCParamsArray(),
				array(
					array(
						'type' => 'textfield',
						'heading' => 'Icon Size (px)',
						'param_name' => 'icon_size',
						'description' => ''
					),
					array(
						'type' => 'colorpicker',
						'heading' => 'Icon Color',
						'param_name' => 'icon_color',
						'description' => ''
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Title',
						'param_name' => 'title',
						'description' => ''
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Margin Below Title',
						'param_name' => 'margin_bottom',
						'description' => ''
					),
					array(
						'type' => 'dropdown',
						'class' => '',
						'heading' => 'Title Tag',
						'param_name' => 'title_tag',
						'value' => array(
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
						'type' => 'textfield',
						'heading' => 'Title size (px)',
						'param_name' => 'title_size',
						'description' => '',
						'dependency' => Array('element' => 'title', 'not_empty' => true)
					),
					array(
						'type' => 'colorpicker',
						'heading' => 'Title Color',
						'param_name' => 'title_color',
						'description' => '',
						'dependency' => Array('element' => 'title', 'not_empty' => true)
					)
				)
			)
		) );

	}
	
	public function render($atts, $content = null) {
		$args = array(
            'icon_size'     => '',
            'icon_color'    => '',
            'title'         => '',
            'margin_bottom' => '',
            'title_tag'     => 'p',
            'title_color'   => '',
            'title_size'    => ''
        );

        $args = array_merge($args, deploy_mikado_icon_collections()->getShortcodeParams());
		
        $params = shortcode_atts($args, $atts);
		
		//Extract params for use in method
		extract($params);
		$iconPackName = deploy_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
		$iconClasses = '';
		
		//generate icon holder classes
		$iconClasses .= 'mkdf-icon-list-item-icon ';
		$iconClasses .= $params['icon_pack'];

		//get correct heading value. If provided heading isn't valid get the default one
		$headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');
		$params['title_tag'] = (in_array($params['title_tag'], $headings_array)) ? $params['title_tag'] : $args['title_tag'];

		$params['icon_classes'] = $iconClasses;
		$params['icon'] = $params[$iconPackName];		
		$params['icon_attributes']['style'] =  $this->getIconStyle($params);
		$params['icon_attributes']['class'] = 'mkdf-icon-list-item-icon-elem';
		$params['title_style'] =  $this->getTitleStyle($params);
		$params['list_item_style'] =  $this->getListItemClasses($params);

		//Get HTML from template
		$html = deploy_mikado_get_shortcode_module_template_part('templates/icon-list-item-template', 'icon-list-item', '', $params);
		return $html;
	}
	 /**
     * Generates icon styles
     *
     * @param $params
     *
     * @return array
     */
	private function getIconStyle($params){
		$iconStylesArray = array();
		if(!empty($params['icon_color'])) {
			$iconStylesArray[] = 'color:' . $params['icon_color'];
		}

		if (!empty($params['icon_size'])) {
			$iconStylesArray[] = 'font-size:' .deploy_mikado_filter_px( $params['icon_size']) . 'px';
		}
		
		 return implode(';', $iconStylesArray);
	}
	 /**
     * Generates title styles
     *
     * @param $params
     *
     * @return array
     */
	private function getTitleStyle($params){
		$titleStylesArray = array();
		if(!empty($params['title_color'])) {
			$titleStylesArray[] = 'color:' . $params['title_color'];
		}

		if (!empty($params['title_size'])) {
			$titleStylesArray[] = 'font-size:' .deploy_mikado_filter_px( $params['title_size']) . 'px';
		}
		
		 return implode(';', $titleStylesArray);
	}

	private function getListItemClasses($params) {
		$classes = array();

		if ($params['margin_bottom'] != '') {
			$classes[] = 'margin-bottom:' .$params['margin_bottom'] .'px';
		}

		return $classes;
	}

}