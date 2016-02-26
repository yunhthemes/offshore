<?php
namespace Deploy\MikadofModules\Shortcodes\BlogCarousel;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class BlogCarousel implements ShortcodeInterface {
	private $base;

	public function __construct() {
		$this->base = 'mkdf_blog_carousel';

		add_action('vc_before_init', array($this, 'vcMap'));
	}

	public function getBase() {
		return $this->base;
	}

	public function vcMap() {
		vc_map(array(
			'name'                      => 'Blog Carousel',
			'base'                      => $this->base,
			'icon'                      => 'icon-wpb-blog-list extended-custom-icon',
			'category'                  => 'by MIKADO',
			'allowed_container_element' => 'vc_row',
			'params'                    => array(
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__('Type', 'deploy'),
					'param_name'  => 'type',
					'value'       => array(
						'Boxes'    => 'boxes',
						'Standard' => 'standard'
					),
					'description' => '',
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Number of Posts',
					'param_name'  => 'number_of_posts',
					'description' => '',
					'group'       => 'Query Options',
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Order By',
					'param_name'  => 'order_by',
					'value'       => array(
						'Title' => 'title',
						'Date'  => 'date'
					),
					'save_always' => true,
					'description' => '',
					'group'       => 'Query Options',
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Order',
					'param_name'  => 'order',
					'value'       => array(
						'ASC'  => 'ASC',
						'DESC' => 'DESC'
					),
					'save_always' => true,
					'description' => '',
					'group'       => 'Query Options',
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Category Slug',
					'param_name'  => 'category',
					'description' => 'Leave empty for all or use comma for list',
					'group'       => 'Query Options',
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Hide Featured Image?',
					'param_name'  => 'hide_image',
					'value'       => array(
						'No'  => 'no',
						'Yes' => 'yes'
					),
					'save_always' => true,
					'description' => '',
					'dependency'  => array('element' => 'type', 'value' => 'boxes'),
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Image Size',
					'param_name'  => 'image_size',
					'value'       => array(
						'Original'    => 'original',
						'Landscape'   => 'landscape',
						'Square'      => 'square',
						'Custom Size' => 'custom_size'
					),
					'description' => '',
					'save_always' => true,
					'admin_label' => true
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Custom Image Size',
					'param_name'  => 'custom_image_size',
					'value'       => '',
					'description' => 'Enter image size in pixels: 200x100 (Width x Height)',
					'save_always' => true,
					'admin_label' => true,
					'dependency'  => array('element' => 'image_size', 'value' => array('custom_size'))
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Grayscale Image',
					'param_name'  => 'grayscale',
					'value'       => array(
						'No'  => 'no',
						'Yes' => 'yes'
					),
					'dependency'  => array('element' => 'type', 'value' => 'standard'),
					'save_always' => true,
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Hide Category?',
					'param_name'  => 'remove_category',
					'value'       => array(
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true,
					'description' => '',
					'admin_label' => true
				),
				array(
					'type'        => 'dropdown',
					'heading'     => 'Disable Border Around Box?',
					'param_name'  => 'disable_border',
					'value'       => array(
						''    => '',
						'Yes' => 'yes',
						'No'  => 'no'
					),
					'save_always' => true,
					'description' => '',
					'admin_label' => true,
					'dependency'  => array('element' => 'type', 'value' => 'boxes')
				),
				array(
					'type'        => 'textfield',
					'heading'     => 'Excerpt Length',
					'param_name'  => 'text_length',
					'description' => 'Number of characters',
					'dependency'  => array('element' => 'type', 'value' => 'boxes'),
					'admin_label' => true
				),
			)
		));
	}

	public function render($atts, $content = null) {
		$default_atts = array(
			'type'              => 'boxes',
			'number_of_posts'   => '',
			'order_by'          => '',
			'order'             => '',
			'grayscale'         => '',
			'category'          => '',
			'image_size'        => '',
			'custom_image_size' => '',
			'text_length'       => '',
			'remove_category'   => '',
			'disable_border'    => '',
			'hide_image'        => ''
		);

		$params = shortcode_atts($default_atts, $atts);

		$params['query']                    = $this->getQueryObject($params);
		$params['using_custom_image_sizes'] = $params['image_size'] === 'custom_size' && !empty($params['custom_image_size']);
		$params['thumb_size']               = $this->generateImageSize($params);
		$params['holder_classes']           = $this->getHolderClasses($params);
		$params['show_share']               = deploy_mikado_options()->getOptionValue('enable_social_share') == 'yes';
		$params['show_likes']               = deploy_mikado_options()->getOptionValue('enable_blog_like') == 'yes';
		$params['gallery_classes']          = ($params['grayscale'] == 'yes') ? 'mkdf-grayscale' : '';

		if($params['using_custom_image_sizes']) {
			$params['custom_image_sizes'] = $this->getCustomImageSizes($params);
		}

		$grayscale_image = '';

		if($params['grayscale'] == 'yes') {
			$grayscale_image .= 'mkdf-grayscale';
		}

		$params['gray'] = $grayscale_image;

		return deploy_mikado_get_shortcode_module_template_part('templates/blog-carousel', 'blog-carousel', $params['type'], $params);
	}

	private function getQueryObject($params) {
		$queryArray = array('post_type' => 'post');

		if(!empty($params['order_by'])) {
			$queryArray['orderby'] = $params['order_by'];
		}

		if(!empty($params['order'])) {
			$queryArray['order'] = $params['order'];
		}

		if(!empty($params['number_of_posts'])) {
			$queryArray['posts_per_page'] = $params['number_of_posts'];
		}

		if(!empty($params['category'])) {
			$queryArray['category_name'] = $params['category'];
		}

		return new \WP_Query($queryArray);
	}

	private function generateImageSize($params) {
		$thumbImageSize = '';
		$imageSize      = $params['using_custom_image_sizes'] ? $params['custom_image_size']  : $params['image_size'];

		if(!$params['using_custom_image_sizes']) {
			if($imageSize !== '' && $imageSize == 'landscape') {
				$thumbImageSize .= 'deploy-portfolio-landscape';
			} else if($imageSize === 'square') {
				$thumbImageSize .= 'deploy-portfolio-square';
			} else if($imageSize !== '' && $imageSize == 'original') {
				$thumbImageSize .= 'full';
			}
		}

		return $thumbImageSize;
	}

	private function getHolderClasses($params) {
		$classes = array(
			'mkdf-blog-carousel',
			'mkdf-carousel-navigation'
		);

		if($params['type'] == 'boxes') {
			$classes[] = 'mkdf-boxes';

			if(!empty($params['disable_border']) && $params['disable_border'] === 'yes') {
				$classes[] = 'mkdf-boxes-no-border';
			}
		}

		$classes[] = 'mkdf-blog-carousel-'.$params['type'];

		return $classes;
	}

	private function getCustomImageSizes($params) {
		$customImageSizes = array();
		if(!empty($params['custom_image_size'])) {
			$imageSize = trim($params['custom_image_size']);
			//Find digits
			preg_match_all('/\d+/', $imageSize, $matches);
			if(!empty($matches[0])) {
				$customImageSizes = array(
					$matches[0][0],
					$matches[0][1]
				);
			}
		}

		return $customImageSizes;
	}
}