<?php
namespace Deploy\MikadofModules\Shortcodes\TabbedGallery;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class TabbedGalleryHolder implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkdf_tabbed_gallery_holder';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => 'Mikado Tabbed Gallery',
			'base'                    => $this->getBase(),
			'as_parent'               => array('only' => 'mkdf_tabbed_gallery_item'),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-tabbed-galley-holder extended-custom-icon',
			'js_view'                 => 'VcColumnView',
			'params'                  => array_merge(
				array(
					array(
						'type'       => 'textfield',
						'heading'    => 'Title',
						'param_name' => 'title'
					),
					array(
						'type'       => 'textfield',
						'heading'    => 'Button Text',
						'param_name' => 'button_text'
					),
					array(
						'type'       => 'textfield',
						'heading'    => 'Button Link',
						'param_name' => 'button_link'
					),
					array(
						'type'       => 'dropdown',
						'heading'    => 'Button Target',
						'param_name' => 'button_target',
						'value'      => array(
							'Same Window' => '',
							'New Window'  => '_blank'
						)
					)
				),
				deploy_mikado_icon_collections()->getVCParamsArray(array(), '', true, 'Button Icon Pack', 'Button Icon')
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'title'         => '',
			'button_text'   => '',
			'button_link'   => '',
			'button_target' => ''
		);

		$default_atts = array_merge($default_atts, deploy_mikado_icon_collections()->getShortcodeParams());
		$params       = shortcode_atts($default_atts, $atts);

		$params['content'] = $content;

		// Extract tab titles
		preg_match_all('/tab_title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);
		$tab_titles = array();

		/**
		 * get tab titles array
		 *
		 */
		if(isset($matches[0])) {
			$tab_titles = $matches[0];
		}

		$tab_title_array = array();

		foreach($tab_titles as $tab) {
			preg_match('/tab_title="([^\"]+)"/i', $tab[0], $tab_matches, PREG_OFFSET_CAPTURE);
			$tab_title_array[] = $tab_matches[1][0];
		}

		$params['tabs_titles']   = $tab_title_array;
		$params['button_params'] = $this->getButtonParams($params);

		return deploy_mikado_get_shortcode_module_template_part('templates/tabbed-gallery-holder-template', 'tabbed-gallery', '', $params);
	}

	private function getButtonParams($params) {
		$btn_params = array();

		if($params['button_text'] !== '') {
			$btn_params['text'] = $params['button_text'];
		}

		if($params['button_link'] !== '') {
			$btn_params['link'] = $params['button_link'];
		}

		if($params['button_target'] !== '') {
			$btn_params['target'] = $params['button_target'];
		}

		$iconPackName              = deploy_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
		$btn_params[$iconPackName] = $iconPackName ? $params[$iconPackName] : '';
		$btn_params['icon_pack']   = $params['icon_pack'];

		$btn_params['size']                   = 'large';
		$btn_params['type']                   = 'solid';

		return $btn_params;
	}

}
