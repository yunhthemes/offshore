<?php
include_once get_template_directory().'/theme-includes.php';

if(!function_exists('deploy_mikado_styles')) {
	/**
	 * Function that includes theme's core styles
	 */
	function deploy_mikado_styles() {
		wp_register_style('deploy_mikado_blog', MIKADO_ASSETS_ROOT.'/css/blog.min.css');

		//include theme's core styles
		wp_enqueue_style('deploy_mikado_default_style', MIKADO_ROOT.'/style.css');
		wp_enqueue_style('deploy_mikado_modules_plugins', MIKADO_ASSETS_ROOT.'/css/plugins.min.css');

		if(deploy_mikado_load_blog_assets() || is_singular('portfolio-item')) {
			wp_enqueue_style('wp-mediaelement');
		}

		wp_enqueue_style('deploy_mikado_modules', MIKADO_ASSETS_ROOT.'/css/modules.min.css');

		deploy_mikado_icon_collections()->enqueueStyles();

		if(deploy_mikado_load_blog_assets()) {
			wp_enqueue_style('deploy_mikado_blog');
		}

		//define files afer which style dynamic needs to be included. It should be included last so it can override other files
		$style_dynamic_deps_array = array();
		if(deploy_mikado_load_woo_assets()) {
			$style_dynamic_deps_array = array('deploy_mikado_woocommerce', 'deploy_mikado_woocommerce_responsive');
		}

		if(deploy_mikado_is_wpml_installed()) {
			wp_enqueue_style('deploy_mikado_wpml', MIKADO_ASSETS_ROOT.'/css/wpml.min.css');
		}

		if(file_exists(dirname(__FILE__).'/assets/css/style_dynamic.css') && deploy_mikado_is_css_folder_writable() && !is_multisite()) {
			wp_enqueue_style('deploy_mikado_style_dynamic', MIKADO_ASSETS_ROOT.'/css/style_dynamic.css', $style_dynamic_deps_array, filemtime(dirname(__FILE__).'/assets/css/style_dynamic.css')); //it must be included after woocommerce styles so it can override it
		} else {
			wp_enqueue_style('deploy_mikado_style_dynamic', MIKADO_ASSETS_ROOT.'/css/style_dynamic.php', $style_dynamic_deps_array); //it must be included after woocommerce styles so it can override it
		}

		//is responsive option turned on?
		if(deploy_mikado_is_responsive_on()) {
			wp_enqueue_style('deploy_mikado_modules_responsive', MIKADO_ASSETS_ROOT.'/css/modules-responsive.min.css');
			wp_enqueue_style('deploy_mikado_blog_responsive', MIKADO_ASSETS_ROOT.'/css/blog-responsive.min.css');

			//include proper styles
			if(file_exists(dirname(__FILE__).'/assets/css/style_dynamic_responsive.css') && deploy_mikado_is_css_folder_writable() && !is_multisite()) {
				wp_enqueue_style('deploy_mikado_style_dynamic_responsive', MIKADO_ASSETS_ROOT.'/css/style_dynamic_responsive.css', array(), filemtime(dirname(__FILE__).'/assets/css/style_dynamic_responsive.css'));
			} else {
				wp_enqueue_style('deploy_mikado_style_dynamic_responsive', MIKADO_ASSETS_ROOT.'/css/style_dynamic_responsive.php');
			}
		}

		//include Visual Composer styles
		if(class_exists('WPBakeryVisualComposerAbstract')) {
			wp_enqueue_style('js_composer_front');
		}
	}

	add_action('wp_enqueue_scripts', 'deploy_mikado_styles');
}

if(!function_exists('deploy_mikado_google_fonts_styles')) {
	/**
	 * Function that includes google fonts defined anywhere in the theme
	 */
	function deploy_mikado_google_fonts_styles() {
		$font_simple_field_array = deploy_mikado_options()->getOptionsByType('fontsimple');
		if(!(is_array($font_simple_field_array) && count($font_simple_field_array) > 0)) {
			$font_simple_field_array = array();
		}

		$font_field_array = deploy_mikado_options()->getOptionsByType('font');
		if(!(is_array($font_field_array) && count($font_field_array) > 0)) {
			$font_field_array = array();
		}

		$available_font_options = array_merge($font_simple_field_array, $font_field_array);
		$font_weight_str        = '100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';

		//define available font options array
		$fonts_array = array();
		foreach($available_font_options as $font_option) {
			//is font set and not set to default and not empty?
			$font_option_value = deploy_mikado_options()->getOptionValue($font_option);
			if(deploy_mikado_is_font_option_valid($font_option_value) && !deploy_mikado_is_native_font($font_option_value)) {
				$font_option_string = $font_option_value.':'.$font_weight_str;
				if(!in_array($font_option_string, $fonts_array)) {
					$fonts_array[] = $font_option_string;
				}
			}
		}

		wp_reset_postdata();

		$fonts_array         = array_diff($fonts_array, array('-1:'.$font_weight_str));
		$google_fonts_string = implode('|', $fonts_array);

		//default fonts should be separated with %7C because of HTML validation
		$default_font_string = 'Open Sans:'.$font_weight_str.'|Montserrat:'.$font_weight_str;
		$protocol            = is_ssl() ? 'https:' : 'http:';

		//is google font option checked anywhere in theme?
		if(count($fonts_array) > 0) {
			//include all checked fonts
			$fonts_full_list      = $default_font_string.'|'.str_replace('+', ' ', $google_fonts_string);
			$fonts_full_list_args = array(
				'family' => urlencode($fonts_full_list),
				'subset' => urlencode('latin,latin-ext'),
			);

			$google_fonts_with_query_arg = add_query_arg($fonts_full_list_args, $protocol.'//fonts.googleapis.com/css');
			wp_enqueue_style('mkdf-deploy-google-fonts', esc_url_raw($google_fonts_with_query_arg), array(), '1.0.0');
		} else {
			$default_fonts_args = array(
				'family' => urlencode($default_font_string),
				'subset' => urlencode('latin,latin-ext'),
			);

			$google_fonts_with_query_arg = add_query_arg($default_fonts_args, $protocol.'//fonts.googleapis.com/css');
			wp_enqueue_style('deploy_mikado_google_fonts', esc_url_raw($google_fonts_with_query_arg), array(), '1.0.0');
		}

	}

	add_action('wp_enqueue_scripts', 'deploy_mikado_google_fonts_styles');
}

if(!function_exists('deploy_mikado_scripts')) {
	/**
	 * Function that includes all necessary scripts
	 */
	function deploy_mikado_scripts() {
		global $wp_scripts;

		//init theme core scripts
		wp_enqueue_script('jquery-ui-core');
		wp_enqueue_script('jquery-ui-tabs');
		wp_enqueue_script('jquery-ui-accordion');
		wp_enqueue_script('wp-mediaelement');

		wp_enqueue_script('deploy_mikado_third_party', MIKADO_ASSETS_ROOT.'/js/third-party.min.js', array('jquery'), false, true);
		wp_enqueue_script('isotope', MIKADO_ASSETS_ROOT.'/js/jquery.isotope.min.js', array('jquery'), false, true);

		//include google map api script
		wp_enqueue_script('deploy_mikado_google_map_api', '//maps.googleapis.com/maps/api/js', array(), false, true);

		wp_enqueue_script('deploy_mikado_modules', MIKADO_ASSETS_ROOT.'/js/modules.min.js', array('jquery'), false, true);

		if(deploy_mikado_load_blog_assets()) {
			wp_enqueue_script('deploy_mikado_blog', MIKADO_ASSETS_ROOT.'/js/blog.min.js', array('jquery'), false, true);
		}

		//deregister Visual Composer's flexslider
		wp_deregister_script('flexslider');

		//include comment reply script
		$wp_scripts->add_data('comment-reply', 'group', 1);
		if(is_singular()) {
			wp_enqueue_script('comment-reply');
		}

		//include Visual Composer script
		if(class_exists('WPBakeryVisualComposerAbstract')) {
			wp_enqueue_script('wpb_composer_front_js');
		}
	}

	add_action('wp_enqueue_scripts', 'deploy_mikado_scripts');
}

//defined content width variable
if(!isset($content_width)) {
	$content_width = 1060;
}

if(!function_exists('deploy_mikado_theme_setup')) {
	/**
	 * Function that adds various features to theme. Also defines image sizes that are used in a theme
	 */
	function deploy_mikado_theme_setup() {
		//add support for feed links
		add_theme_support('automatic-feed-links');

		//add support for post formats
		add_theme_support('post-formats', array('gallery', 'link', 'quote', 'video', 'audio'));

		//add theme support for post thumbnails
		add_theme_support('post-thumbnails');

		//add theme support for title tag
		if(function_exists('_wp_render_title_tag')) {
			add_theme_support('title-tag');
		}

		//define thumbnail sizes
		add_image_size('deploy-portfolio-square', 550, 550, true);
		add_image_size('deploy-portfolio-landscape', 800, 600, true);
		add_image_size('deploy-portfolio-portrait', 600, 800, true);

		add_filter('widget_text', 'do_shortcode');
		add_filter('call_to_action_widget', 'do_shortcode');

		load_theme_textdomain('deploy', get_template_directory().'/languages');
	}

	add_action('after_setup_theme', 'deploy_mikado_theme_setup');
}


if(!function_exists('deploy_mikado_rgba_color')) {
	/**
	 * Function that generates rgba part of css color property
	 *
	 * @param $color string hex color
	 * @param $transparency float transparency value between 0 and 1
	 *
	 * @return string generated rgba string
	 */
	function deploy_mikado_rgba_color($color, $transparency) {
		if($color !== '' && $transparency !== '') {
			$rgba_color = '';

			$rgb_color_array = deploy_mikado_hex2rgb($color);
			$rgba_color .= 'rgba('.implode(', ', $rgb_color_array).', '.$transparency.')';

			return $rgba_color;
		}
	}
}

if(!function_exists('deploy_mikado_wp_title_text')) {
	/**
	 * Function that sets page's title. Hooks to wp_title filter
	 *
	 * @param $title string current page title
	 * @param $sep string title separator
	 *
	 * @return string changed title text if SEO plugins aren't installed
	 */
	function deploy_mikado_wp_title_text($title, $sep) {
		//get current post id
		$id           = deploy_mikado_get_page_id();
		$sep          = ' | ';
		$title_prefix = get_bloginfo('name');
		$title_suffix = '';

		//is WooCommerce installed and is current page shop page?
		if(deploy_mikado_is_woocommerce_installed() && deploy_mikado_is_woocommerce_shop()) {
			//get shop page id
			$id = deploy_mikado_get_woo_shop_page_id();
		}

		//is WP 4.1 at least?
		if(function_exists('_wp_render_title_tag')) {
			//set unchanged title variable so we can use it later
			$title_array     = explode($sep, $title);
			$unchanged_title = array_shift($title_array);
		} //pre 4.1 version of WP
		else {
			//set unchanged title variable so we can use it later
			$unchanged_title = $title;
		}

		if(empty($title_suffix)) {
			//if current page is front page append site description, else take original title string
			$title_suffix = is_front_page() ? get_bloginfo('description') : $unchanged_title;
		}

		//concatenate title string
		$title = $title_prefix.$sep.$title_suffix;

		//return generated title string
		return $title;
	}

	add_filter('wp_title', 'deploy_mikado_wp_title_text', 10, 2);
}

if(!function_exists('deploy_mikado_wp_title')) {
	/**
	 * Function that outputs title tag. It checks if _wp_render_title_tag function exists
	 * and if it does'nt it generates output. Compatible with versions of WP prior to 4.1
	 */
	function deploy_mikado_wp_title() {
		if(!function_exists('_wp_render_title_tag')) { ?>
			<title><?php wp_title(''); ?></title>
		<?php }
	}
}

if(!function_exists('deploy_mikado_header_meta')) {
	/**
	 * Outputs some meta tags that are required
	 */
	function deploy_mikado_header_meta() { ?>

		<meta charset="<?php bloginfo('charset'); ?>"/>
		<link rel="profile" href="http://gmpg.org/xfn/11"/>
		<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>"/>

		<meta http-equiv="cache-control" content="max-age=0" />
		<meta http-equiv="cache-control" content="no-cache" />
		<meta http-equiv="expires" content="0" />
		<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
		<meta http-equiv="pragma" content="no-cache" />
	<?php }

	add_action('deploy_mikado_header_meta', 'deploy_mikado_header_meta');
}

if(!function_exists('deploy_mikado_user_scalable_meta')) {
	/**
	 * Function that outputs user scalable meta if responsiveness is turned on
	 * Hooked to deploy_mikado_header_meta action
	 */
	function deploy_mikado_user_scalable_meta() {
		//is responsiveness option is chosen?
		if(deploy_mikado_is_responsive_on()) { ?>
			<meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
		<?php } else { ?>
			<meta name="viewport" content="width=1200,user-scalable=no">
		<?php }
	}

	add_action('deploy_mikado_header_meta', 'deploy_mikado_user_scalable_meta');
}

if(!function_exists('deploy_mikado_get_page_id')) {
	/**
	 * Function that returns current page / post id.
	 * Checks if current page is woocommerce page and returns that id if it is.
	 * Checks if current page is any archive page (category, tag, date, author etc.) and returns -1 because that isn't
	 * page that is created in WP admin.
	 *
	 * @return int
	 *
	 * @version 0.1
	 *
	 * @see deploy_mikado_is_woocommerce_installed()
	 * @see deploy_mikado_is_woocommerce_shop()
	 */
	function deploy_mikado_get_page_id() {
		if(deploy_mikado_is_woocommerce_installed() && deploy_mikado_is_woocommerce_shop()) {
			return deploy_mikado_get_woo_shop_page_id();
		}

		if(is_archive() || is_search() || is_404() || (is_home() && is_front_page())) {
			return -1;
		}

		return get_queried_object_id();
	}
}


if(!function_exists('deploy_mikado_is_default_wp_template')) {
	/**
	 * Function that checks if current page archive page, search, 404 or default home blog page
	 * @return bool
	 *
	 * @see is_archive()
	 * @see is_search()
	 * @see is_404()
	 * @see is_front_page()
	 * @see is_home()
	 */
	function deploy_mikado_is_default_wp_template() {
		return is_archive() || is_search() || is_404() || (is_front_page() && is_home());
	}
}

if(!function_exists('deploy_mikado_get_page_template_name')) {
	/**
	 * Returns current template file name without extension
	 * @return string name of current template file
	 */
	function deploy_mikado_get_page_template_name() {
		$file_name = '';

		if(!deploy_mikado_is_default_wp_template()) {
			$file_name_without_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename(get_page_template()));

			if($file_name_without_ext !== '') {
				$file_name = $file_name_without_ext;
			}
		}

		return $file_name;
	}
}

if(!function_exists('deploy_mikado_has_shortcode')) {
	/**
	 * Function that checks whether shortcode exists on current page / post
	 *
	 * @param string shortcode to find
	 * @param string content to check. If isn't passed current post content will be used
	 *
	 * @return bool whether content has shortcode or not
	 */
	function deploy_mikado_has_shortcode($shortcode, $content = '') {
		$has_shortcode = false;

		if($shortcode) {
			//if content variable isn't past
			if($content == '') {
				//take content from current post
				$page_id = deploy_mikado_get_page_id();
				if(!empty($page_id)) {
					$current_post = get_post($page_id);

					if(is_object($current_post) && property_exists($current_post, 'post_content')) {
						$content = $current_post->post_content;
					}
				}
			}

			//does content has shortcode added?
			if(stripos($content, '['.$shortcode) !== false) {
				$has_shortcode = true;
			}
		}

		return $has_shortcode;
	}
}

if(!function_exists('deploy_mikado_rewrite_rules_on_theme_activation')) {
	/**
	 * Function that flushes rewrite rules on deactivation
	 */
	function deploy_mikado_rewrite_rules_on_theme_activation() {
		flush_rewrite_rules();
	}

	add_action('after_switch_theme', 'deploy_mikado_rewrite_rules_on_theme_activation');
}

if(!function_exists('deploy_mikado_get_dynamic_sidebar')) {
	/**
	 * Return Custom Widget Area content
	 *
	 * @return string
	 */
	function deploy_mikado_get_dynamic_sidebar($index = 1) {
		ob_start();
		dynamic_sidebar($index);
		$sidebar_contents = ob_get_clean();

		return $sidebar_contents;
	}
}

if(!function_exists('deploy_mikado_get_sidebar')) {
	/**
	 * Return Sidebar
	 *
	 * @return string
	 */
	function deploy_mikado_get_sidebar() {

		$id = deploy_mikado_get_page_id();

		$sidebar = "sidebar";

		if(get_post_meta($id, 'mkdf_custom_sidebar_meta', true) != '') {
			$sidebar = get_post_meta($id, 'mkdf_custom_sidebar_meta', true);
		} else {
			if(is_single() && deploy_mikado_options()->getOptionValue('blog_single_custom_sidebar') != '') {
				$sidebar = esc_attr(deploy_mikado_options()->getOptionValue('blog_single_custom_sidebar'));
			} elseif((is_archive() || is_search() || (is_home() && is_front_page())) && deploy_mikado_options()->getOptionValue('blog_custom_sidebar') != '') {
				$sidebar = esc_attr(deploy_mikado_options()->getOptionValue('blog_custom_sidebar'));
			} elseif(is_page() && deploy_mikado_options()->getOptionValue('page_custom_sidebar') != '') {
				$sidebar = esc_attr(deploy_mikado_options()->getOptionValue('page_custom_sidebar'));
			}
		}

		return $sidebar;
	}
}


if(!function_exists('deploy_mikado_sidebar_columns_class')) {

	/**
	 * Return classes for columns holder when sidebar is active
	 *
	 * @return array
	 */

	function deploy_mikado_sidebar_columns_class() {

		$sidebar_class  = array('mkdf-page-sidebar');
		$sidebar_layout = deploy_mikado_sidebar_layout();

		switch($sidebar_layout):
			case 'sidebar-33-right':
				$sidebar_class[] = 'mkdf-two-columns-66-33';
				break;
			case 'sidebar-25-right':
				$sidebar_class[] = 'mkdf-two-columns-75-25';
				break;
			case 'sidebar-33-left':
				$sidebar_class[] = 'mkdf-two-columns-33-66';
				break;
			case 'sidebar-25-left':
				$sidebar_class[] = 'mkdf-two-columns-25-75';
				break;

		endswitch;

		$sidebar_class[] = 'clearfix';

		return deploy_mikado_class_attribute($sidebar_class);

	}

}


if(!function_exists('deploy_mikado_sidebar_layout')) {

	/**
	 * Function that check is sidebar is enabled and return type of sidebar layout
	 */

	function deploy_mikado_sidebar_layout() {

		$sidebar_layout = '';
		$page_id        = deploy_mikado_get_page_id();

		$page_sidebar_meta = get_post_meta($page_id, 'mkdf_sidebar_meta', true);

		if($page_sidebar_meta !== '' && $page_id !== -1 && $page_sidebar_meta !== 'default') {
			$sidebar_layout = $page_sidebar_meta;
		} else {
			if(is_single() && deploy_mikado_options()->getOptionValue('blog_single_sidebar_layout')) {
				$sidebar_layout = esc_attr(deploy_mikado_options()->getOptionValue('blog_single_sidebar_layout'));
			} elseif((is_archive() || (is_home() && is_front_page())) && deploy_mikado_options()->getOptionValue('archive_sidebar_layout')) {
				$sidebar_layout = esc_attr(deploy_mikado_options()->getOptionValue('archive_sidebar_layout'));
			} elseif(is_page() && deploy_mikado_options()->getOptionValue('page_sidebar_layout')) {
				$sidebar_layout = esc_attr(deploy_mikado_options()->getOptionValue('page_sidebar_layout'));
			}
		}

		return $sidebar_layout;
	}
}


if(!function_exists('deploy_mikado_page_custom_style')) {

	/**
	 * Function that print custom page style
	 */

	function deploy_mikado_page_custom_style() {
		$style = '';
		$html  = '';
		$style = apply_filters('deploy_mikado_add_page_custom_style', $style);
		if($style !== '') {
			$html .= '<style type="text/css">';
			$html .= implode(' ', $style);
			$html .= '</style>';
		}
		print $html;
	}

	add_action('wp_head', 'deploy_mikado_page_custom_style');
}


if(!function_exists('deploy_mikado_container_style')) {

	/**
	 * Function that return container style
	 */

	function deploy_mikado_container_style($style) {
		$id = deploy_mikado_get_page_id();

		$class_prefix = deploy_mikado_get_unique_page_class();

		$container_selector = array(
			$class_prefix.' .mkdf-content .mkdf-content-inner > .mkdf-container',
			$class_prefix.' .mkdf-content .mkdf-content-inner > .mkdf-full-width',
		);

		$container_class = array();

		$page_backgorund_color = get_post_meta($id, 'mkdf_page_background_color_meta', true);

		if(!$page_backgorund_color && is_singular('portfolio-item')) {
			$page_backgorund_color = '#fff';
		}

		if($page_backgorund_color) {
			$container_class['background-color'] = $page_backgorund_color;
		}

		$style[] = deploy_mikado_dynamic_css($container_selector, $container_class);

		return $style;

	}

	add_filter('deploy_mikado_add_page_custom_style', 'deploy_mikado_container_style');
}

if(!function_exists('deploy_mikado_get_unique_page_class')) {
	/**
	 * Returns unique page class based on post type and page id
	 *
	 * @return string
	 */
	function deploy_mikado_get_unique_page_class() {
		$id         = deploy_mikado_get_page_id();
		$page_class = '';

		if(is_single()) {
			$page_class = '.postid-'.$id;
		} elseif($id === deploy_mikado_get_woo_shop_page_id()) {
			$page_class = '.archive';
		} else {
			$page_class .= '.page-id-'.$id;
		}

		return $page_class;
	}
}

if(!function_exists('deploy_mikado_content_padding_top')) {

	/**
	 * Function that return padding for content
	 */

	function deploy_mikado_content_padding_top($style) {
		$id = deploy_mikado_get_page_id();

		$class_prefix = deploy_mikado_get_unique_page_class();

		$content_selector = array(
			$class_prefix.' .mkdf-content .mkdf-content-inner > .mkdf-container > .mkdf-container-inner',
			$class_prefix.' .mkdf-content .mkdf-content-inner > .mkdf-full-width > .mkdf-full-width-inner',
		);

		$content_class = array();

		$page_padding_top = get_post_meta($id, 'mkdf_page_content_top_padding', true);

		if($page_padding_top !== '') {
			if(get_post_meta($id, 'mkdf_page_content_top_padding_mobile', true) == 'yes') {
				$content_class['padding-top'] = deploy_mikado_filter_px($page_padding_top).'px!important';
			} else {
				$content_class['padding-top'] = deploy_mikado_filter_px($page_padding_top).'px';
			}

			$style[] = deploy_mikado_dynamic_css($content_selector, $content_class);
		}

		return $style;

	}

	add_filter('deploy_mikado_add_page_custom_style', 'deploy_mikado_content_padding_top');
}

if(!function_exists('deploy_mikado_print_custom_css')) {
	/**
	 * Prints out custom css from theme options
	 */
	function deploy_mikado_print_custom_css() {
		$custom_css = deploy_mikado_options()->getOptionValue('custom_css');
		$output     = '';

		if($custom_css !== '') {
			$output .= '<style type="text/css" id="mkdf-custom-css">';
			$output .= $custom_css;
			$output .= '</style>';
		}

		print $output;
	}

	add_action('wp_head', 'deploy_mikado_print_custom_css', 1000);
}

if(!function_exists('deploy_mikado_print_custom_js')) {
	/**
	 * Prints out custom css from theme options
	 */
	function deploy_mikado_print_custom_js() {
		$custom_js = deploy_mikado_options()->getOptionValue('custom_js');
		$output    = '';

		if($custom_js !== '') {
			$output .= '<script type="text/javascript" id="mkdf-custom-css">';
			$output .= '(function($) {';
			$output .= $custom_js;
			$output .= '})(jQuery)';
			$output .= '</script>';
		}

		print $output;
	}

	add_action('wp_footer', 'deploy_mikado_print_custom_js', 1000);
}


if(!function_exists('deploy_mikado_get_global_variables')) {
	/**
	 * Function that generates global variables and put them in array so they could be used in the theme
	 */
	function deploy_mikado_get_global_variables() {

		$global_variables      = array();
		$element_appear_amount = -150;

		$global_variables['mkdfAddForAdminBar']      = is_admin_bar_showing() ? 32 : 0;
		$global_variables['mkdfElementAppearAmount'] = deploy_mikado_options()->getOptionValue('element_appear_amount') !== '' ? deploy_mikado_options()->getOptionValue('element_appear_amount') : $element_appear_amount;
		$global_variables['mkdfFinishedMessage']     = esc_html__('No more posts', 'deploy');
		$global_variables['mkdfMessage']             = esc_html__('Loading new posts...', 'deploy');

		$global_variables = apply_filters('deploy_mikado_js_global_variables', $global_variables);

		wp_localize_script('deploy_mikado_modules', 'mkdfGlobalVars', array(
			'vars' => $global_variables
		));

	}

	add_action('wp_enqueue_scripts', 'deploy_mikado_get_global_variables');
}

if(!function_exists('deploy_mikado_per_page_js_variables')) {
	/**
	 *
	 */
	function deploy_mikado_per_page_js_variables() {
		$per_page_js_vars = apply_filters('deploy_mikado_per_page_js_vars', array());

		wp_localize_script('deploy_mikado_modules', 'mkdfPerPageVars', array(
			'vars' => $per_page_js_vars
		));
	}

	add_action('wp_enqueue_scripts', 'deploy_mikado_per_page_js_variables');
}

if(!function_exists('deploy_mikado_content_elem_style_attr')) {
	/**
	 * Defines filter for adding custom styles to content HTML element
	 */
	function deploy_mikado_content_elem_style_attr() {
		$styles = apply_filters('deploy_mikado_content_elem_style_attr', array());

		deploy_mikado_inline_style($styles);
	}
}

if(!function_exists('deploy_mikado_is_woocommerce_installed')) {
	/**
	 * Function that checks if woocommerce is installed
	 * @return bool
	 */
	function deploy_mikado_is_woocommerce_installed() {
		return function_exists('is_woocommerce');
	}
}

if(!function_exists('deploy_mikado_visual_composer_installed')) {
	/**
	 * Function that checks if visual composer installed
	 * @return bool
	 */
	function deploy_mikado_visual_composer_installed() {
		//is Visual Composer installed?
		if(class_exists('WPBakeryVisualComposerAbstract')) {
			return true;
		}

		return false;
	}
}

if(!function_exists('deploy_mikado_contact_form_7_installed')) {
	/**
	 * Function that checks if contact form 7 installed
	 * @return bool
	 */
	function deploy_mikado_contact_form_7_installed() {
		//is Contact Form 7 installed?
		if(defined('WPCF7_VERSION')) {
			return true;
		}

		return false;
	}
}

if(!function_exists('deploy_mikado_is_wpml_installed')) {
	/**
	 * Function that checks if WPML plugin is installed
	 * @return bool
	 *
	 * @version 0.1
	 */
	function deploy_mikado_is_wpml_installed() {
		return defined('ICL_SITEPRESS_VERSION');
	}
}

if(!function_exists('deploy_mikado_get_first_main_color')) {
	/**
	 * Returns first main color from options if set, else returns default first main color
	 *
	 * @return bool|string|void
	 */
	function deploy_mikado_get_first_main_color() {
		return deploy_mikado_options()->getOptionValue('first_color') ? deploy_mikado_options()->getOptionValue('first_color') : '#0088cc';
	}
}

if(!function_exists('deploy_mikado_max_image_size')) {
	/**
	 * Set max width for srcset to 1920
	 *
	 * @return int
	 */
	function deploy_mikado_max_image_size() {
		return 1920;
	}

	add_filter('max_srcset_image_width', 'deploy_mikado_max_image_size');
}