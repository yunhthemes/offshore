<?php

if ( ! function_exists('deploy_mikado_like') ) {
	/**
	 * Returns MikadofDeployLike instance
	 *
	 * @return MikadofDeployLike
	 */
	function deploy_mikado_like() {
		return MikadofDeployLike::get_instance();
	}

}

function deploy_mikado_get_like() {

	echo wp_kses(deploy_mikado_like()->add_like(), array(
		'span' => array(
			'class' => true,
			'aria-hidden' => true,
			'style' => true,
			'id' => true
		),
		'i' => array(
			'class' => true,
			'style' => true,
			'id' => true
		),
		'a' => array(
			'href' => true,
			'class' => true,
			'id' => true,
			'title' => true,
			'style' => true
		)
	));
}

if ( ! function_exists('deploy_mikado_like_latest_posts') ) {
	/**
	 * Add like to latest post
	 *
	 * @return string
	 */
	function deploy_mikado_like_latest_posts() {
		return deploy_mikado_like()->add_like();
	}

}

if ( ! function_exists('deploy_mikado_like_portfolio_list') ) {
	/**
	 * Add like to portfolio project
	 *
	 * @param $portfolio_project_id
	 * @return string
	 */
	function deploy_mikado_like_portfolio_list($portfolio_project_id) {
		return deploy_mikado_like()->add_like_portfolio_list($portfolio_project_id);
	}
}

if ( ! function_exists('deploy_mikado_like_portfolio_single') ) {
	/**
	 * Add like to portfolio project
	 *
	 * @param $portfolio_project_id
	 * @return string
	 */
	function deploy_mikado_like_portfolio_single() {
		return deploy_mikado_like()->add_like_portfolio_single();
	}
}