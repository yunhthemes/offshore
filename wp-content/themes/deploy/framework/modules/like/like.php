<?php

class MikadofDeployLike {

	private static $instance;

	private function __construct() {
		add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
		add_action('wp_ajax_mkdf_like', array($this, 'ajax'));
		add_action('wp_ajax_nopriv_mkdf_like', array($this, 'ajax'));
	}

	public static function get_instance() {

		if(null == self::$instance) {
			self::$instance = new self;
		}

		return self::$instance;

	}

	function enqueue_scripts() {

		wp_enqueue_script('deploy_mikado_like', MIKADO_ASSETS_ROOT.'/js/like.min.js', 'jquery', '1.0', true);

		wp_localize_script('deploy_mikado_like', 'mkdfLike', array(
			'ajaxurl' => admin_url('admin-ajax.php')
		));
	}

	function ajax() {

		//update
		if(isset($_POST['likes_id'])) {

			$post_id = str_replace('mkdf-like-', '', $_POST['likes_id']);
			$type    = isset($_POST['type']) ? $_POST['type'] : '';

			echo wp_kses($this->like_post($post_id, 'update', $type), array(
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'i'    => array(
					'class' => true,
					'style' => true,
					'id'    => true
				)
			));
		} //get
		else {
			$post_id = str_replace('mkdf-like-', '', $_POST['likes_id']);
			echo wp_kses($this->like_post($post_id, 'get'), array(
				'span' => array(
					'class'       => true,
					'aria-hidden' => true,
					'style'       => true,
					'id'          => true
				),
				'i'    => array(
					'class' => true,
					'style' => true,
					'id'    => true
				)
			));
		}
		exit;
	}

	public function like_post($post_id, $action = 'get', $type = '') {
		if(!is_numeric($post_id)) {
			return;
		}

		switch($action) {

			case 'get':
				$like_count = get_post_meta($post_id, '_mkd-like', true);

				if($type == 'portfolio-single' && $like_count !== '') {
					switch($like_count) {
						case '0':
							$like_count .= ' '.esc_html__('Likes', 'deploy');
							break;
						case '1':
							$like_count .= ' '.esc_html__('Like', 'deploy');
							break;
						default:
							$like_count .= ' '.esc_html__('Likes', 'deploy');
					}
				}

				if(isset($_COOKIE['mkdf-like_'.$post_id])) {
					if($type == 'portfolio-single') {
						$icon = deploy_mikado_icon_collections()->renderIcon('icon_heart', 'font_elegant');
					} else {
						$icon = deploy_mikado_icon_collections()->renderIcon('icon-like', 'simple_line_icons');
					}


				} else {
					if($type == 'portfolio-single') {
						$icon = deploy_mikado_icon_collections()->renderIcon('icon_heart_alt', 'font_elegant');
					} else {
						$icon = deploy_mikado_icon_collections()->renderIcon('icon-like', 'simple_line_icons');
					}
				}
				if(!$like_count) {
					$like_count = 0;

					add_post_meta($post_id, '_mkd-like', $like_count, true);

					$icon = deploy_mikado_icon_collections()->renderIcon('icon-like', 'simple_line_icons');

					if($type == 'portfolio-single') {
						$like_count .= ' '.esc_html__('Likes', 'deploy');

						$icon = deploy_mikado_icon_collections()->renderIcon('icon_heart_alt', 'font_elegant');
					}

				}
				$return_value = $icon."<span>".$like_count."</span>";

				return $return_value;
				break;

			case 'update':
				$like_count = get_post_meta($post_id, '_mkd-like', true);

				if($type != 'portfolio_list' && isset($_COOKIE['mkdf-like_'.$post_id])) {
					return $like_count;
				}

				$like_count++;

				update_post_meta($post_id, '_mkd-like', $like_count);
				setcookie('mkdf-like_'.$post_id, $post_id, time() * 20, '/');

				if($type == 'portfolio-single' && $like_count !== '') {
					switch($like_count) {
						case '0':
							$like_count .= ' '.esc_html__('Likes', 'deploy');
							break;
						case '1':
							$like_count .= ' '.esc_html__('Like', 'deploy');
							break;
						default:
							$like_count .= ' '.esc_html__('Likes', 'deploy');
					}
				}

				if($type != 'portfolio_list') {

					if($type == 'portfolio-single') {
						$icon = deploy_mikado_icon_collections()->renderIcon('icon_heart', 'font_elegant');
					} else {
						$icon = deploy_mikado_icon_collections()->renderIcon('icon-like', 'simple_line_icons');
					}

					$return_value = $icon."<span>".$like_count."</span>";

					$return_value .= '</span>';

					return $return_value;
				}

				return '';
				break;
			default:
				return '';
				break;
		}
	}

	public function add_like() {
		global $post;

		$output = $this->like_post($post->ID);

		$class = 'mkdf-like';
		$title = esc_html__('Like this', 'deploy');
		if(isset($_COOKIE['mkdf-like_'.$post->ID])) {
			$class = 'mkdf-like liked';
			$title = esc_html__('You already liked this!', 'deploy');
		}

		return '<a href="#" class="'.$class.'" id="mkdf-like-'.$post->ID.'" title="'.$title.'">'.$output.'</a>';
	}

	public function add_like_portfolio_list($portfolio_project_id) {

		$class = 'mkdf-like';
		$title = esc_html__('Like this', 'deploy');
		if(isset($_COOKIE['mkdf-like_'.$portfolio_project_id])) {
			$class = 'mkdf-like liked';
			$title = esc_html__('You already liked this!', 'deploy');
		}

		return '<a class="'.$class.'" data-type="portfolio_list" id="mkdf-like-'.$portfolio_project_id.'" title="'.$title.'"></a>';
	}

	public function add_like_portfolio_single() {
		global $post;

		$output = $this->like_post($post->ID, 'get', 'portfolio-single');

		$class = 'mkdf-like';
		$title = esc_html__('Like this', 'deploy');
		if(isset($_COOKIE['mkdf-like_'.$post->ID])) {
			$class = 'mkdf-like liked';
			$title = esc_html__('You already liked this!', 'deploy');
		}

		return '<a href="#" data-type="portfolio-single" class="'.$class.'" id="mkdf-like-'.$post->ID.'" title="'.$title.'">'.$output.'</a>';
	}

	public function add_like_blog_list($blog_id) {

		$class = 'mkdf-like';
		$title = esc_html__('Like this', 'deploy');
		if(isset($_COOKIE['mkdf-like_'.$blog_id])) {
			$class = 'mkdf-like liked';
			$title = esc_html__('You already liked this!', 'deploy');
		}

		return '<a class="hover_icon '.$class.'" data-type="portfolio_list" id="mkdf-like-'.$blog_id.'" title="'.$title.'"></a>';
	}

}

global $deploy_mikado_like;
$deploy_mikado_like = MikadofDeployLike::get_instance();


function deploy_mikado_like_latest_posts() {
	global $deploy_mikado_like;

	return $deploy_mikado_like->add_like();
}