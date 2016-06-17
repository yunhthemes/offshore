<?php
namespace Deploy\MikadofModules\PricingTable;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class PricingTable implements ShortcodeInterface{
	private $base;
	function __construct() {
		$this->base = 'mkdf_pricing_table';
		add_action('vc_before_init', array($this, 'vcMap'));
	}
	public function getBase() {
		return $this->base;
	}
	
	public function vcMap() {
		vc_map( array(
			'name' => 'Mikado Pricing Table',
			'base' => $this->base,
			'icon' => 'icon-wpb-pricing-table extended-custom-icon',
			'category' => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'as_child' => array('only' => 'mkdf_pricing_tables'),
			'params' => array_merge(

				deploy_mikado_icon_collections()->getVCParamsArray(array(), '', true),
				array(
					array(
						'type' => 'attach_image',
						'heading' => 'Image',
						'param_name' => 'image',
						'description' => 'Select image from media library.'
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Title',
						'param_name' => 'title',
						'value' => 'Basic Plan',
						'description' => ''
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Price',
						'param_name' => 'price',
						'description' => 'Default value is 100'
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Currency',
						'param_name' => 'currency',
						'description' => 'Default mark is $'
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Price Period',
						'param_name' => 'price_period',
						'description' => 'Default label is monthly'
					),
					array(
						'type' => 'dropdown',
						'admin_label' => true,
						'heading' => 'Show Button',
						'param_name' => 'show_button',
						'value' => array(
							'Yes' => 'yes',
							'No' => 'no'
						),
						"save_always" => true,
						'description' => ''
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Button Text',
						'param_name' => 'button_text',
						'dependency' => array('element' => 'show_button',  'value' => 'yes')
					),
					array(
						'type' => 'textfield',
						'admin_label' => true,
						'heading' => 'Button Link',
						'param_name' => 'link',
						'dependency' => array('element' => 'show_button',  'value' => 'yes')
					),
					array(
						"type" => "dropdown",
						"holder" => "div",
						"class" => "",
						"heading" => "Active",
						"param_name" => "active",
						"value" => array(
							"No" => "no",
							"Yes" => "yes"
						),
						"save_always" => true,
						"description" => ""
					),
					array(
						'type' => 'textarea_html',
						'holder' => 'div',
						'class' => '',
						'heading' => 'Content',
						'param_name' => 'content',
						'value' => '<li>content content content</li><li>content content content</li><li>content content content</li>',
						'description' => ''
					)
				)
			) // close array_merge
		));
	}

	public function render($atts, $content = null) {
	
		$args = array(
			'image'                        => '',
			'title'         			   => 'Basic Plan',
			'price'         			   => '100',
			'currency'      			   => '$',
			'price_period'  			   => 'Monthly',
			'show_button'				   => 'yes',
			'link'          			   => '#',
			'button_text'   			   => 'Purchase',
		    'active'                       => ''
		);

		$args = array_merge($args, deploy_mikado_icon_collections()->getShortcodeParams());
		$params       = shortcode_atts($args, $atts);

		extract($params);

		$html						= '';
		$pricing_table_clasess		= array('mkdf-price-table');

		if ($params['active'] == 'yes') {
			$pricing_table_clasess[] = 'mkdf-active-pricing-table';
		}

		if($params['show_button'] == 'no') {
			$pricing_table_clasess[] = 'mkdf-border-bottom';
		}

		$params['pricing_table_classes'] = $pricing_table_clasess;
		$params['content']= $content;

		$iconPackName   = deploy_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
		$params['icon'] = $iconPackName ? $params[$iconPackName] : '';

		$params['show_image'] = $params['image'] !== '';
		$params['has_icon'] = $params['show_image'] || $params['icon'] !== '';

		$html .= deploy_mikado_get_shortcode_module_template_part('templates/pricing-table-template', 'pricing-table', '', $params);
		return $html;

	}

}
