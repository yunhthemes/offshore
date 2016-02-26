<?php

if(!function_exists('deploy_mikado_get_social_share_html')) {
	/**
	 * Calls button shortcode with given parameters and returns it's output
	 * @param $params
	 *
	 * @return mixed|string
	 */
	function deploy_mikado_get_social_share_html($params = array()) {
		return deploy_mikado_execute_shortcode('mkdf_social_share', $params);
	}
}

if (!function_exists('deploy_mikado_the_excerpt_max_charlength')) {
	/**
	 * Function that sets character length for social share shortcode
	 * @param $charlength string original text
	 * @return string shortened text
	 */
	function deploy_mikado_the_excerpt_max_charlength($charlength) {

		if (deploy_mikado_options()->getOptionValue('twitter_via')) {
			$via = ' via ' . esc_attr(deploy_mikado_options()->getOptionValue('twitter_via'));
		} else {
			$via = '';
		}

		$excerpt = urlencode(get_the_excerpt());
		$charlength = 140 - (mb_strlen($via) + $charlength);

		if ( mb_strlen( $excerpt ) > $charlength ) {
			$subex = mb_substr( $excerpt, 0, $charlength);
			$exwords = explode( ' ', $subex );
			$excut = - ( mb_strlen( $exwords[ count( $exwords ) - 1 ] ) );
			if ( $excut < 0 ) {
				return mb_substr( $subex, 0, $excut );
			} else {
				return $subex;
			}
		} else {
			return $excerpt;
		}
	}
}