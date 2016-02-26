<?php

namespace Deploy\MikadofModules\Shortcodes\TabbedGallery;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class TabbedGalleryItem implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkdf_tabbed_gallery_item';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                    => 'Mikado Tabbed Gallery Item',
			'base'                    => $this->getBase(),
			'as_parent'               => array('except' => 'vc_row'),
			'as_child'                => array('only' => 'mkdf_tabbed_gallery_holder'),
			'is_container'            => false,
			'category'                => 'by MIKADO',
			'icon'                    => 'icon-wpb-tabbed-galley-item extended-custom-icon',
			'show_settings_on_create' => true,
			'params'                  => array_merge(
				deploy_mikado_icon_collections()->getVCParamsArray(array(), '', true),
				array(
					array(
						'type'        => 'textfield',
						'admin_label' => true,
						'heading'     => 'Title',
						'param_name'  => 'tab_title',
						'description' => ''
					),
					array(
						'type'        => 'attach_images',
						'heading'     => 'Images',
						'param_name'  => 'images',
						'description' => 'Select images from media library'
					),
					array(
						'type'        => 'textfield',
						'heading'     => 'Image Size',
						'param_name'  => 'image_size',
						'description' => 'Enter image size. Example: thumbnail, medium, large, full or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use "thumbnail" size'
					)
				)
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'tab_title'  => 'Tab',
			'tab_id'     => '',
			'images'     => '',
			'image_size' => ''
		);

		$default_atts = array_merge($default_atts, deploy_mikado_icon_collections()->getShortcodeParams());
		$params       = shortcode_atts($default_atts, $atts);

		$iconPackName         = deploy_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
		$params['icon']       = !empty($params[$iconPackName]) ? $params[$iconPackName] : '';
		$params['tab_data']   = $this->getTabData($params);
		$params['image_size'] = $this->getImageSize($params['image_size']);
		$params['images']     = $this->getGalleryImages($params);

		return deploy_mikado_get_shortcode_module_template_part('templates/tabbed-gallery-item-template', 'tabbed-gallery', '', $params);
	}

	private function getTabData($params) {
		$data = array();

		if($params['icon'] !== '') {
			$data['data-icon-pack'] = $params['icon_pack'];

			if($params['icon'] !== '') {
				$data['data-icon-html'] = deploy_mikado_icon_collections()->renderIcon($params['icon'], $params['icon_pack']);
			}
		}

		return $data;
	}

	/**
	 * Return image size or custom image size array
	 *
	 * @param $image_size
	 * @return array
	 */
	private function getImageSize($image_size) {

		//Remove whitespaces
		$image_size = trim($image_size);
		//Find digits
		preg_match_all( '/\d+/', $image_size, $matches );

		if(in_array( $image_size, array('thumbnail', 'thumb', 'medium', 'large', 'full'))) {
			return $image_size;
		} elseif(!empty($matches[0])) {
			return array(
					$matches[0][0],
					$matches[0][1]
			);
		} else {
			return 'thumbnail';
		}

	}

	/**
	 * Return images for gallery
	 *
	 * @param $params
	 * @return array
	 */
	private function getGalleryImages($params) {
		$image_ids = array();

		if ($params['images'] !== '') {
			$image_ids = explode(',', $params['images']);
		}

		return $image_ids;

	}
}