<?php
namespace Deploy\MikadofModules\Shortcodes\ImageGallery;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class ImageGallery implements ShortcodeInterface {

	private $base;

	/**
	 * Image Gallery constructor.
	 */
	public function __construct() {
		$this->base = 'mkdf_image_gallery';

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

		vc_map(array(
			'name'                      => 'Mikado Image Gallery',
			'base'                      => $this->getBase(),
			'category'                  => 'by MIKADO',
			'icon'                      => 'icon-wpb-image-gallery extended-custom-icon',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
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
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Gallery Type',
					'admin_label' => true,
					'param_name'  => 'type',
					'value'       => array(
						'Slider'     => 'slider',
						'Image Grid' => 'image_grid'
					),
					'description' => 'Select gallery type',
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Slide duration',
					'admin_label' => true,
					'param_name'  => 'autoplay',
					'value'       => array(
						'3'       => '3',
						'5'       => '5',
						'10'      => '10',
						'Disable' => 'disable'
					),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'slider'
						)
					),
					'description' => 'Auto rotate slides each X seconds',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Slide Animation',
					'admin_label' => true,
					'param_name'  => 'slide_animation',
					'value'       => array(
						'Slide'      => 'slide',
						'Fade'       => 'fade',
						'Fade Up'    => 'fadeUp',
						'Back Slide' => 'backSlide',
						'Go Down'    => 'goDown'
					),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'slider'
						)
					)
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Column Number',
					'param_name'  => 'column_number',
					'value'       => array(2, 3, 4, 5),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'image_grid'
						)
					),
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Action on Click',
					'param_name'  => 'on_click',
					'value'       => array(
						'Do Nothing'           => '',
						'Open in Pretty Photo' => 'pretty_photo',
						'Open Custom Link'     => 'custom_link',
					),
					'save_always' => true,
				),
				array(
					'type'        => 'exploded_textarea',
					'heading'     => 'Custom Links',
					'param_name'  => 'custom_links',
					'value'       => '',
					'dependency'  => array('element' => 'on_click', 'value' => 'custom_link'),
					'save_always' => true,
					'description' => 'Enter links for each image (Note: divide links with linebreaks (Enter)).'
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Add Border Around Image',
					'param_name'  => 'image_border',
					'value'       => array(
						'No'  => 'no',
						'Yes' => 'yes'
					),
					'dependency'  => array('element' => 'type', 'value' => 'image_grid'),
					'save_always' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Add Box Shadow on Hover',
					'param_name'  => 'image_shadow',
					'value'       => array(
						'No'  => 'no',
						'Yes' => 'yes'
					),
					'dependency'  => array('element' => 'type', 'value' => 'image_grid'),
					'save_always' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Grayscale Images',
					'param_name'  => 'grayscale',
					'value'       => array(
						'No'  => 'no',
						'Yes' => 'yes'
					),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'image_grid'
						)
					)
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Show Navigation Arrows',
					'param_name'  => 'navigation',
					'value'       => array(
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'slider'
						)
					),
					'save_always' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Show Pagination',
					'param_name'  => 'pagination',
					'value'       => array(
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true,
					'dependency'  => array(
						'element' => 'type',
						'value'   => array(
							'slider'
						)
					)
				)
			)
		));

	}

	/**
	 * Renders shortcodes HTML
	 *
	 * @param $atts array of shortcode params
	 * @param $content string shortcode content
	 *
	 * @return string
	 */
	public function render($atts, $content = null) {

		$args = array(
			'images'          => '',
			'image_size'      => 'thumbnail',
			'type'            => 'slider',
			'autoplay'        => '5000',
			'slide_animation' => 'slide',
			'on_click'        => '',
			'custom_links'    => '',
			'pretty_photo'    => '',
			'column_number'   => '',
			'grayscale'       => '',
			'navigation'      => 'yes',
			'image_border'    => '',
			'image_shadow'    => '',
			'pagination'      => 'yes'
		);

		$params                    = shortcode_atts($args, $atts);
		$params['slider_data']     = $this->getSliderData($params);
		$params['image_size']      = $this->getImageSize($params['image_size']);
		$params['images']          = $this->getGalleryImages($params);
		$params['pretty_photo']    = $this->usePrettyPhoto($params);
		$params['has_link']        = $params['pretty_photo'] || !empty($params['custom_links']);
		$params['columns']         = 'mkdf-gallery-columns-'.$params['column_number'];
		$params['gallery_classes'] = ($params['grayscale'] == 'yes') ? 'mkdf-grayscale' : '';
		$params['link_data']       = '';

		if($this->usePrettyPhoto($params)) {
			$params['link_data'] = array(
				'data-rel' => 'prettyPhoto[single_pretty_photo]'
			);
		}

		if($params['type'] == 'image_grid') {
			$template = 'gallery-grid';
		} elseif($params['type'] == 'slider') {
			$template = 'gallery-slider';
		}

		$image_border = '';
		if($params['image_border'] === 'yes') {
			$image_border .= 'mkdf-border-image';
		}
		$params['border_image'] = $image_border;

		$image_hover = '';
		if($params['image_shadow'] === 'yes') {
			$image_hover .= 'mkdf-shadow-image';
		}
		$params['hover_image'] = $image_hover;

		$html = deploy_mikado_get_shortcode_module_template_part('templates/'.$template, 'imagegallery', '', $params);

		return $html;

	}

	/**
	 * Return images for gallery
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getGalleryImages($params) {
		$image_ids        = array();
		$images           = array();
		$image            = array();
		$links            = $this->getImageLinks($params);
		$use_custom_links = is_array($links) && count($links);
		$use_pretty_photo = $this->usePrettyPhoto($params);

		if($params['images'] !== '') {
			$image_ids = explode(',', $params['images']);
		}

		for($i = 0; $i < count($image_ids); $i++) {
			$image['image_id'] = $image_ids[$i];

			if($use_custom_links) {
				$image['image_link'] = !empty($links[$i]) ? $links[$i] : '#';
			} elseif($use_pretty_photo) {
				$image['image_link'] = wp_get_attachment_url($image_ids[$i]);
			}

			$images[] = $image;
		}

		return $images;
	}

	/**
	 * Return image size or custom image size array
	 *
	 * @param $image_size
	 *
	 * @return array
	 */
	private function getImageSize($image_size) {

		$image_size = trim($image_size);
		//Find digits
		preg_match_all('/\d+/', $image_size, $matches);
		if(in_array($image_size, array('thumbnail', 'thumb', 'medium', 'large', 'full'))) {
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
	 * Return all configuration data for slider
	 *
	 * @param $params
	 *
	 * @return array
	 */
	private function getSliderData($params) {

		$slider_data = array();

		$slider_data['data-autoplay']   = ($params['autoplay'] !== '') ? $params['autoplay'] : '';
		$slider_data['data-animation']  = ($params['slide_animation'] !== '') ? $params['slide_animation'] : '';
		$slider_data['data-navigation'] = ($params['navigation'] !== '') ? $params['navigation'] : '';
		$slider_data['data-pagination'] = ($params['pagination'] !== '') ? $params['pagination'] : '';

		return $slider_data;

	}

	private function getImageLinks($params) {
		$links = array();

		if(!empty($params['custom_links'])) {
			$links = explode(',', $params['custom_links']);
		}

		return $links;
	}

	private function usePrettyPhoto($params) {
		return isset($params['on_click']) && $params['on_click'] === 'pretty_photo';
	}

}