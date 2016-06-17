<?php
/**
 * Pagination - Show numbered pagination for catalog pages.
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.2
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( $wp_query->max_num_pages <= 1 ) {
	return;
}

if(get_query_var('paged')) {
	$paged = get_query_var('paged');
} elseif(get_query_var('page')) {
	$paged = get_query_var('page');
} else {
	$paged = 1;
}

deploy_mikado_pagination($wp_query->max_num_pages, $wp_query->max_num_pages, $paged);

?>
