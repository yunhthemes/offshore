<?php
namespace MikadoCore\CPT\Portfolio\Shortcodes;

use MikadoCore\Lib;

/**
 * Class PortfolioList
 * @package MikadoCore\CPT\Portfolio\Shortcodes
 */
class PortfolioList implements Lib\ShortcodeInterface {
	/**
	 * @var string
	 */
	private $base;

	public function __construct() {
		$this->base = 'mkdf_portfolio_list';

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
	 * Maps shortcode to Visual Composer
	 *
	 * @see vc_map
	 */
	public function vcMap() {
		if(function_exists('vc_map')) {

			$icons_array = array();
			if(mkd_core_theme_installed()) {
				$icons_array = deploy_mikado_icon_collections()->getVCParamsArray();
			}

			vc_map(array(
					'name'                      => 'Portfolio List',
					'base'                      => $this->getBase(),
					'category'                  => 'by MIKADO',
					'icon'                      => 'icon-wpb-portfolio extended-custom-icon',
					'allowed_container_element' => 'vc_row',
					'params'                    => array_merge(
						array(
							array(
								'type'        => 'dropdown',
								'heading'     => 'Portfolio List Template',
								'param_name'  => 'type',
								'value'       => array(
									'Standard' => 'standard',
									'Gallery'  => 'gallery'
								),
								'admin_label' => true,
								'description' => ''
							),
							array(
								'type'        => 'textfield',
								'heading'     => 'Extra Class Name',
								'param_name'  => 'extra_class_name',
								'admin_label' => true,
								'description' => ''
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Title Tag',
								'param_name'  => 'title_tag',
								'value'       => array(
									''   => '',
									'h2' => 'h2',
									'h3' => 'h3',
									'h4' => 'h4',
									'h5' => 'h5',
									'h6' => 'h6',
								),
								'admin_label' => true,
								'description' => ''
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Image Proportions',
								'param_name'  => 'image_size',
								'value'       => array(
									'Original'  => 'full',
									'Square'    => 'square',
									'Landscape' => 'landscape',
									'Portrait'  => 'portrait'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => '',
								'dependency'  => array('element' => 'type', 'value' => array('standard', 'gallery'))
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Show Load More',
								'param_name'  => 'show_load_more',
								'value'       => array(
									'Yes' => 'yes',
									'No'  => 'no'
								),
								'save_always' => true,
								'admin_label' => true,
								'description' => 'Default value is Yes',
								'dependency'  => array('element' => 'type', 'value' => array('standard', 'gallery'))
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Order By',
								'param_name'  => 'order_by',
								'value'       => array(
									'Menu Order' => 'menu_order',
									'Title'      => 'title',
									'Date'       => 'date'
								),
								'admin_label' => true,
								'save_always' => true,
								'description' => '',
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Order',
								'param_name'  => 'order',
								'value'       => array(
									'ASC'  => 'ASC',
									'DESC' => 'DESC',
								),
								'admin_label' => true,
								'save_always' => true,
								'description' => '',
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'textfield',
								'heading'     => 'One-Category Portfolio List',
								'param_name'  => 'category',
								'value'       => '',
								'admin_label' => true,
								'description' => 'Enter one category slug (leave empty for showing all categories)',
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'textfield',
								'heading'     => 'Number of Portfolios Per Page',
								'param_name'  => 'number',
								'value'       => '-1',
								'admin_label' => true,
								'description' => '(enter -1 to show all)',
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Number of Columns',
								'param_name'  => 'columns',
								'value'       => array(
									''      => '',
									'One'   => 'one',
									'Two'   => 'two',
									'Three' => 'three',
									'Four'  => 'four',
									'Five'  => 'five',
									'Six'   => 'six'
								),
								'admin_label' => true,
								'description' => 'Default value is Three',
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Show Excerpt',
								'param_name'  => 'show_excerpt',
								'value'       => array(
									'Yes' => 'yes',
									'No'  => 'no'
								),
								'admin_label' => true,
								'save_always' => true,
								'dependency'  => array('element' => 'type', 'value' => array('standard')),
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Space Between Portfolio Items',
								'param_name'  => 'space_between_portfolio_items',
								'value'       => array(
									''    => '',
									'Yes' => 'yes',
									'No'  => 'no'
								),
								'admin_label' => true,
								'save_always' => true,
								'dependency'  => array('element' => 'type', 'value' => array('gallery')),
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'textfield',
								'heading'     => 'Show Only Projects with Listed IDs',
								'param_name'  => 'selected_projects',
								'value'       => '',
								'admin_label' => true,
								'description' => 'Delimit ID numbers by comma (leave empty for all)',
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Enable Category Filter',
								'param_name'  => 'filter',
								'value'       => array(
									'No'  => 'no',
									'Yes' => 'yes'
								),
								'admin_label' => true,
								'save_always' => true,
								'description' => 'Default value is No',
								'group'       => 'Query and Layout Options'
							),
							array(
								'type'        => 'dropdown',
								'heading'     => 'Filter Order By',
								'param_name'  => 'filter_order_by',
								'value'       => array(
									'Name'  => 'name',
									'Count' => 'count',
									'Id'    => 'id',
									'Slug'  => 'slug'
								),
								'admin_label' => true,
								'save_always' => true,
								'description' => 'Default value is Name',
								'dependency'  => array('element' => 'filter', 'value' => array('yes')),
								'group'       => 'Query and Layout Options'
							)
						)
					),
					$icons_array
				)
			);
		}
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
			'type'                          => 'standard',
			'extra_class_name'              => '',
			'columns'                       => 'three',
			'columns_standard'              => 'three',
			'grid_size'                     => 'three',
			'image_size'                    => 'full',
			'order_by'                      => 'date',
			'order'                         => 'ASC',
			'number'                        => '-1',
			'filter'                        => 'no',
			'filter_order_by'               => 'name',
			'category'                      => '',
			'show_excerpt'                  => 'yes',
			'selected_projects'             => '',
			'show_load_more'                => 'yes',
			'title_tag'                     => 'h4',
			'slider_datta_attr'             => '',
			'next_page'                     => '',
			'space_between_portfolio_items' => ''
		);

		$args   = array_merge($args, deploy_mikado_icon_collections()->getShortcodeParams());
		$params = shortcode_atts($args, $atts);
		extract($params);

		$query_array             = $this->getQueryArray($params);
		$query_results           = new \WP_Query($query_array);
		$params['query_results'] = $query_results;

		$classes = $this->getPortfolioClasses($params);

		$data_atts = $this->getDataAtts($params);
		$data_atts .= 'data-max-num-pages = '.$query_results->max_num_pages;

		$html = '';

		$html .= '<div class = "mkdf-portfolio-list-holder-outer '.$classes.'" '.$data_atts.'>';
		if($filter == 'yes') {
			$params['filter_categories'] = $this->getFilterCategories($params);
			$html .= mkd_core_get_shortcode_module_template_part('portfolio', 'portfolio-filter', '', $params);
		}
		$html .= '<div class = "mkdf-portfolio-list-holder clearfix" >';

		$params['thumb_size'] = $this->getImageSize($params);

		if($query_results->have_posts()):
			while($query_results->have_posts()) : $query_results->the_post();
				$params['current_id'] = get_the_ID();
				$params['icon_html']  = $this->getPortfolioIconsHtml($params);

				$params['categories'] = $this->getItemCategories($params);
				$params['item_link']  = $this->getItemLink($params);
				$params['item_target'] = $this->getItemExternalLink($params) !== '' ? '_blank' : '_self';

				$html .= mkd_core_get_shortcode_module_template_part('portfolio', $type, '', $params);

			endwhile;
		else:

			$html .= '<p>'._e('Sorry, no posts matched your criteria.', 'mkd_core').'</p>';

		endif;

		if($type == 'standard' || $params['space_between_portfolio_items'] == 'yes') {
			switch($columns) {
				case 'two':
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					break;
				case 'three':
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					break;
				case 'four':
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					break;
				case 'five':
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					break;
				case 'six':
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					$html .= '<div class="mkdf-gap"></div>';
					break;
				default:
					break;
			}
		}

		$html .= '</div>'; //close mkdf-portfolio-list-holder
		if($show_load_more == 'yes') {
			$html .= mkd_core_get_shortcode_module_template_part('portfolio', 'load-more-template', '', $params);
		}
		wp_reset_postdata();
		$html .= '</div>'; // close mkdf-portfolio-list-holder-outer
		return $html;
	}

	/**
	 * Generates portfolio list query attribute array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getQueryArray($params) {

		$query_array = array();

		$query_array = array(
			'post_type'      => 'portfolio-item',
			'orderby'        => $params['order_by'],
			'order'          => $params['order'],
			'posts_per_page' => $params['number']
		);

		if(!empty($params['category'])) {
			$query_array['portfolio-category'] = $params['category'];
		}

		$project_ids = null;
		if(!empty($params['selected_projects'])) {
			$project_ids             = explode(',', $params['selected_projects']);
			$query_array['post__in'] = $project_ids;
		}
		$paged = '';
		if(empty($params['next_page'])) {
			if(get_query_var('paged')) {
				$paged = get_query_var('paged');
			} elseif(get_query_var('page')) {
				$paged = get_query_var('page');
			}
		}
		if(!empty($params['next_page'])) {
			$query_array['paged'] = $params['next_page'];

		} else {
			$query_array['paged'] = 1;
		}

		return $query_array;
	}

	/**
	 * Generates portfolio icons html
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getPortfolioIconsHtml($params) {

		$html       = '';
		$id         = $params['current_id'];
		$slug_list_ = 'pretty_photo_gallery';

		$featured_image_array = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full'); //original size
		$large_image          = $featured_image_array[0];

		$html .= '<div class="mkdf-item-icons-holder">';

		$html .= '<a class="mkdf-portfolio-lightbox" title="'.get_the_title($id).'" href="'.$large_image.'" data-rel="prettyPhoto['.$slug_list_.']"></a>';


		if(function_exists('deploy_mikado_like_portfolio_list') && $params['type'] === 'standard') {
			$html .= deploy_mikado_like_portfolio_list($id);
		}

		$html .= '</div>';

		return $html;
	}

	/**
	 * Generates portfolio classes
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getPortfolioClasses($params) {
		$classes   = array();
		$type      = $params['type'];
		$columns   = $params['columns'];
		$grid_size = $params['grid_size'];
		switch($type):
			case 'standard':
				$classes[] = 'mkdf-ptf-standard';
				break;
			case 'gallery':
				$classes[] = 'mkdf-ptf-gallery';

				if($params['space_between_portfolio_items'] == 'yes') {
					$classes[] = 'mkdf-space-between-spaces';
				}
				break;
		endswitch;

		if($type == 'standard' || $type == 'gallery') {
			switch($columns):
				case 'one':
					$classes[] = 'mkdf-ptf-one-column';
					break;
				case 'two':
					$classes[] = 'mkdf-ptf-two-columns';
					break;
				case 'three':
					$classes[] = 'mkdf-ptf-three-columns';
					break;
				case 'four':
					$classes[] = 'mkdf-ptf-four-columns';
					break;
				case 'five':
					$classes[] = 'mkdf-ptf-five-columns';
					break;
				case 'six':
					$classes[] = 'mkdf-ptf-six-columns';
					break;
			endswitch;

			if($params['show_load_more'] == 'yes') {
				$classes[] = 'mkdf-ptf-load-more';
			}

			if($params['filter'] == 'yes') {
				$classes[] = 'mkdf-ptf-has-filter';
			}
		}

		if(!empty($params['extra_class_name'])) {
			$classes[] = $params['extra_class_name'];
		}

		return implode(' ', $classes);

	}

	/**
	 * Generates portfolio image size
	 *
	 * @param $params
	 *
	 * @return string
	 */
	public function getImageSize($params) {

		$thumb_size = 'full';
		$type       = $params['type'];

		if($type == 'standard' || $type == 'gallery') {
			if(!empty($params['image_size'])) {
				$image_size = $params['image_size'];

				switch($image_size) {
					case 'landscape':
						$thumb_size = 'deploy-portfolio-landscape';
						break;
					case 'portrait':
						$thumb_size = 'deploy-portfolio-portrait';
						break;
					case 'square':
						$thumb_size = 'deploy-portfolio-square';
						break;
					case 'full':
						$thumb_size = 'full';
						break;
				}
			}
		}

		return $thumb_size;
	}

	/**
	 * Generates portfolio item categories based on id
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getItemCategories($params) {
		$id                    = $params['current_id'];
		$category_return_array = array();
		$categories            = wp_get_post_terms($id, 'portfolio-category');

		foreach($categories as $cat) {
			$category_return_array[] = 'portfolio_category_'.$cat->term_id;
		}

		return implode(' ', $category_return_array);
	}

	/**
	 * Generates portfolio item categories html based on id
	 *
	 * @param $params
	 *
	 * @return html
	 */
	public function getItemCategoriesHtml($params) {
		$id = $params['current_id'];

		$categories    = wp_get_post_terms($id, 'portfolio-category');
		$category_html = '<div class="mkdf-ptf-category-holder">';
		$k             = 1;
		foreach($categories as $cat) {
			$category_html .= '<span>'.$cat->name.'</span>';
			if(count($categories) != $k) {
				$category_html .= '<span> / </span>';
			}
			$k++;
		}
		$category_html .= '</div>';

		return $category_html;
	}

	/**
	 * Generates filter categories array
	 *
	 * @param $params
	 *
	 *
	 *
	 *
	 * * @return array
	 */
	public function getFilterCategories($params) {

		$cat_id       = 0;
		$top_category = '';

		if(!empty($params['category'])) {

			$top_category = get_term_by('slug', $params['category'], 'portfolio-category');
			if(isset($top_category->term_id)) {
				$cat_id = $top_category->term_id;
			}

		}

		$args = array(
			'child_of' => $cat_id,
			'order_by' => $params['filter_order_by']
		);

		$filter_categories = get_terms('portfolio-category', $args);

		return $filter_categories;

	}

	/**
	 * Generates datta attributes array
	 *
	 * @param $params
	 *
	 * @return array
	 */
	public function getDataAtts($params) {

		$data_attr          = array();
		$data_return_string = '';

		if(get_query_var('paged')) {
			$paged = get_query_var('paged');
		} elseif(get_query_var('page')) {
			$paged = get_query_var('page');
		} else {
			$paged = 1;
		}

		if(!empty($paged)) {
			$data_attr['data-next-page'] = $paged + 1;
		}
		if(!empty($params['type'])) {
			$data_attr['data-type'] = $params['type'];
		}
		if(!empty($params['extra_class_name'])) {
			$data_attr['data-extra-class-name'] = $params['extra_class_name'];
		}
		if(!empty($params['columns'])) {
			$data_attr['data-columns'] = $params['columns'];
		}
		if(!empty($params['grid_size'])) {
			$data_attr['data-grid-size'] = $params['grid_size'];
		}
		if(!empty($params['order_by'])) {
			$data_attr['data-order-by'] = $params['order_by'];
		}
		if(!empty($params['order'])) {
			$data_attr['data-order'] = $params['order'];
		}
		if(!empty($params['number'])) {
			$data_attr['data-number'] = $params['number'];
		}
		if(!empty($params['filter'])) {
			$data_attr['data-filter'] = $params['filter'];
		}
		if(!empty($params['filter_order_by'])) {
			$data_attr['data-filter-order-by'] = $params['filter_order_by'];
		}
		if(!empty($params['category'])) {
			$data_attr['data-category'] = $params['category'];
		}
		if(!empty($params['selected_projectes'])) {
			$data_attr['data-selected-projects'] = $params['selected_projectes'];
		}
		if(!empty($params['show_load_more'])) {
			$data_attr['data-show-load-more'] = $params['show_load_more'];
		}
		if(!empty($params['title_tag'])) {
			$data_attr['data-title-tag'] = $params['title_tag'];
		}

		if(!empty($params['show_excerpt'])) {
			$data_attr['data-show-excerpt'] = $params['show_excerpt'];
		}

		if(!empty($params['image_size'])) {
			$data_attr['data-image-size'] = $params['image_size'];
		}

		foreach($data_attr as $key => $value) {
			if($key !== '') {
				$data_return_string .= $key.'= '.esc_attr($value).' ';
			}
		}

		return $data_return_string;
	}

	public function getItemLink($params) {
		$id             = $params['current_id'];
		$portfolio_link = get_permalink($id);
		if(get_post_meta($id, 'portfolio_external_link', true) !== '') {
			$portfolio_link = get_post_meta($id, 'portfolio_external_link', true);
		}

		return $portfolio_link;
	}

	public function getItemExternalLink($params) {
		$id             = $params['current_id'];

		return get_post_meta($id, 'portfolio_external_link', true);
	}
}