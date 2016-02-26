<?php

if(!function_exists('mkd_core_version_class')) {
	/**
	 * Adds plugins version class to body
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function mkd_core_version_class($classes) {
		$classes[] = 'mkd-core-'.MIKADO_CORE_VERSION;

		return $classes;
	}

	add_filter('body_class', 'mkd_core_version_class');
}

if(!function_exists('mkd_core_theme_installed')) {
	/**
	 * Checks whether theme is installed or not
	 * @return bool
	 */
	function mkd_core_theme_installed() {
		return defined('MIKADO_ROOT');
	}
}

if(!function_exists('mkd_core_get_carousel_slider_array')) {
	/**
	 * Function that returns associative array of carousels,
	 * where key is term slug and value is term name
	 * @return array
	 */
	function mkd_core_get_carousel_slider_array() {
		$carousels_array = array();
		$terms           = get_terms('carousels_category');

		if(is_array($terms) && count($terms)) {
			$carousels_array[''] = '';
			foreach($terms as $term) {
				$carousels_array[$term->slug] = $term->name;
			}
		}

		return $carousels_array;
	}
}

if(!function_exists('mkd_core_get_carousel_slider_array_vc')) {
	/**
	 * Function that returns array of carousels formatted for Visual Composer
	 *
	 * @return array array of carousels where key is term title and value is term slug
	 *
	 * @see mkd_core_get_carousel_slider_array
	 */
	function mkd_core_get_carousel_slider_array_vc() {
		return array_flip(mkd_core_get_carousel_slider_array());
	}
}

if(!function_exists('mkd_core_get_shortcode_module_template_part')) {
	/**
	 * Loads module template part.
	 *
	 * @param string $shortcode name of the shortcode folder
	 * @param string $template name of the template to load
	 * @param string $slug
	 * @param array $params array of parameters to pass to template
	 *
	 * @see deploy_mikado_get_template_part()
	 */
	function mkd_core_get_shortcode_module_template_part($shortcode, $template, $slug = '', $params = array()) {

		//HTML Content from template
		$html          = '';
		$template_path = MIKADO_CORE_CPT_PATH.'/'.$shortcode.'/shortcodes/templates';

		$temp = $template_path.'/'.$template;
		if(is_array($params) && count($params)) {
			extract($params);
		}

		$template = '';

		if($temp !== '') {
			$template = $temp.'.php';

			if($slug !== '') {
				$template = "{$temp}-{$slug}.php";
			}
		}
		if($template) {
			ob_start();
			include($template);
			$html = ob_get_clean();
		}

		return $html;
	}
}

if(!function_exists('mkd_core_set_portfolio_ajax_url')) {
	/**
	 * load themes ajax functionality
	 *
	 */
	function mkd_core_set_portfolio_ajax_url() {
		echo '<script type="application/javascript">var mkdCoreAjaxUrl = "'.admin_url('admin-ajax.php').'"</script>';
	}

	add_action('wp_enqueue_scripts', 'mkd_core_set_portfolio_ajax_url');

}
/**
 * Loads more function for portfolio.
 *
 */
if(!function_exists('mkd_core_portfolio_ajax_load_more')) {

	function mkd_core_portfolio_ajax_load_more() {

		$return_obj       = array();
		$shortcode_params = array();
		if(!empty($_POST['type'])) {
			$shortcode_params['type'] = $_POST['type'];
		}
		if(!empty($_POST['extraClassName'])) {
			$shortcode_params['extra_class_name'] = $_POST['extraClassName'];
		}
		if(!empty($_POST['columns'])) {
			$shortcode_params['columns'] = $_POST['columns'];
		}
		if(!empty($_POST['gridSize'])) {
			$shortcode_params['gridSize'] = $_POST['gridSize'];
		}
		if(!empty($_POST['orderBy'])) {
			$shortcode_params['order_by'] = $_POST['orderBy'];
		}
		if(!empty($_POST['order'])) {
			$shortcode_params['order'] = $_POST['order'];
		}
		if(!empty($_POST['number'])) {
			$shortcode_params['number'] = $_POST['number'];
		}
		if(!empty($_POST['filter'])) {
			$shortcode_params['filter'] = $_POST['filter'];
		}
		if(!empty($_POST['filterOrderBy'])) {
			$shortcode_params['filter_order_by'] = $_POST['filterOrderBy'];
		}
		if(!empty($_POST['category'])) {
			$shortcode_params['category'] = $_POST['category'];
		}
		if(!empty($_POST['selectedProjectes'])) {
			$shortcode_params['selected_projectes'] = $_POST['selectedProjectes'];
		}
		if(!empty($_POST['showLoadMore'])) {
			$shortcode_params['show_load_more'] = $_POST['showLoadMore'];
		}
		if(!empty($_POST['titleTag'])) {
			$shortcode_params['title_tag'] = $_POST['titleTag'];
		}

		if(!empty($_POST['showExcerpt'])) {
			$shortcode_params['show_excerpt'] = $_POST['showExcerpt'];
		}

		if(!empty($_POST['showCategories'])) {
			$shortcode_params['show_categories'] = $_POST['showCategories'];
		}

		if(!empty($_POST['imageSize'])) {
			$shortcode_params['image_size'] = $_POST['imageSize'];
		}

		if(!empty($_POST['nextPage'])) {
			$shortcode_params['next_page'] = $_POST['nextPage'];
		}

		$html = '';

		$port_list     = new \MikadoCore\CPT\Portfolio\Shortcodes\PortfolioList();
		$query_array   = $port_list->getQueryArray($shortcode_params);
		$query_results = new \WP_Query($query_array);

		if($query_results->have_posts()):
			while($query_results->have_posts()) : $query_results->the_post();

				$shortcode_params['current_id']    = get_the_ID();
				$shortcode_params['thumb_size']    = $port_list->getImageSize($shortcode_params);
				$shortcode_params['icon_html']     = $port_list->getPortfolioIconsHtml($shortcode_params);
				$shortcode_params['category_html'] = $port_list->getItemCategoriesHtml($shortcode_params);
				$shortcode_params['categories']    = $port_list->getItemCategories($shortcode_params);
				$shortcode_params['item_link']     = $port_list->getItemLink($shortcode_params);
				$shortcode_params['item_target']   = $port_list->getItemExternalLink($shortcode_params) !== '' ? '_blank' : '_self';

				$html .= mkd_core_get_shortcode_module_template_part('portfolio', $shortcode_params['type'], '', $shortcode_params);

			endwhile;
		else:
			$html .= '<p>'._e('Sorry, no posts matched your criteria.', 'mkd_core').'</p>';
		endif;

		$return_obj = array(
			'html' => $html,
		);


		echo json_encode($return_obj);
		exit;
	}
}


add_action('wp_ajax_nopriv_mkd_core_portfolio_ajax_load_more', 'mkd_core_portfolio_ajax_load_more');
add_action('wp_ajax_mkd_core_portfolio_ajax_load_more', 'mkd_core_portfolio_ajax_load_more');

if(!function_exists('mkd_core_inline_style')) {
	/**
	 * Function that echoes generated style attribute
	 *
	 * @param $value string | array attribute value
	 *
	 */
	function mkd_core_inline_style($value) {
		echo mkd_core_get_inline_style($value);
	}
}

if(!function_exists('mkd_core_get_inline_style')) {
	/**
	 * Function that generates style attribute and returns generated string
	 *
	 * @param $value string | array value of style attribute
	 *
	 * @return string generated style attribute
	 *
	 */
	function mkd_core_get_inline_style($value) {
		return deploy_mikado_get_inline_attr($value, 'style', ';');
	}
}

if(!function_exists('mkd_core_class_attribute')) {
	/**
	 * Function that echoes class attribute
	 *
	 * @param $value string value of class attribute
	 *
	 * @see deploy_mikado_get_class_attribute()
	 */
	function mkd_core_class_attribute($value) {
		echo mkd_core_get_class_attribute($value);
	}
}

if(!function_exists('mkd_core_get_class_attribute')) {
	/**
	 * Function that returns generated class attribute
	 *
	 * @param $value string value of class attribute
	 *
	 * @return string generated class attribute
	 *
	 * @see deploy_mikado_get_inline_attr()
	 */
	function mkd_core_get_class_attribute($value) {
		return mkd_core_get_inline_attr($value, 'class', ' ');
	}
}

if(!function_exists('mkd_core_get_inline_attr')) {
	/**
	 * Function that generates html attribute
	 *
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 *
	 * @return string generated html attribute
	 */
	function mkd_core_get_inline_attr($value, $attr, $glue = '') {
		if(!empty($value)) {

			if(is_array($value) && count($value)) {
				$properties = implode($glue, $value);
			} elseif($value !== '') {
				$properties = $value;
			}

			return $attr.'="'.esc_attr($properties).'"';
		}

		return '';
	}
}

if(!function_exists('mkd_core_inline_attr')) {
	/**
	 * Function that generates html attribute
	 *
	 * @param $value string | array value of html attribute
	 * @param $attr string name of html attribute to generate
	 * @param $glue string glue with which to implode $attr. Used only when $attr is array
	 *
	 * @return string generated html attribute
	 */
	function mkd_core_inline_attr($value, $attr, $glue = '') {
		echo mkd_core_get_inline_attr($value, $attr, $glue);
	}
}

if(!function_exists('mkd_core_get_inline_attrs')) {
	/**
	 * Generate multiple inline attributes
	 *
	 * @param $attrs
	 *
	 * @return string
	 */
	function mkd_core_get_inline_attrs($attrs) {
		$output = '';

		if(is_array($attrs) && count($attrs)) {
			foreach($attrs as $attr => $value) {
				$output .= ' '.mkd_core_get_inline_attr($value, $attr);
			}
		}

		ltrim($output);

		return $output;
	}
}

if(!function_exists('mkd_core_get_attachment_id_from_url')) {
	/**
	 * Function that retrieves attachment id for passed attachment url
	 *
	 * @param $attachment_url
	 *
	 * @return null|string
	 */
	function mkd_core_get_attachment_id_from_url($attachment_url) {
		global $wpdb;
		$attachment_id = '';

		//is attachment url set?
		if($attachment_url !== '') {
			//prepare query

			$query = $wpdb->prepare("SELECT ID FROM {$wpdb->posts} WHERE guid=%s", $attachment_url);

			//get attachment id
			$attachment_id = $wpdb->get_var($query);
		}

		//return id
		return $attachment_id;
	}
}