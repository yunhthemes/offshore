<?php
/**
 * Woocommerce configuration file
 */

// Adds theme support for woocommerce
add_theme_support('woocommerce');

//Disable the default WooCommerce stylesheet.
if(version_compare(WOOCOMMERCE_VERSION, "2.1") >= 0) {
	add_filter('woocommerce_enqueue_styles', '__return_false');
} else {
	define('WOOCOMMERCE_USE_CSS', false);
}

if(!function_exists('deploy_mikado_woocommerce_content')) {
	/**
	 * Output WooCommerce content.
	 *
	 * This function is only used in the optional 'woocommerce.php' template
	 * which people can add to their themes to add basic woocommerce support
	 * without hooks or modifying core templates.
	 *
	 * @access public
	 * @return void
	 */
	function deploy_mikado_woocommerce_content() {

		if(is_singular('product')) {

			while(have_posts()) : the_post();

				wc_get_template_part('content', 'single-product');

			endwhile;

		} else {

			if(have_posts()) :

				do_action('woocommerce_before_shop_loop');

				woocommerce_product_loop_start();

				woocommerce_product_subcategories();

				while(have_posts()) : the_post();

					wc_get_template_part('content', 'product');

				endwhile; // end of the loop.

				woocommerce_product_loop_end();

				do_action('woocommerce_after_shop_loop');

			elseif(!woocommerce_product_subcategories(array(
				'before' => woocommerce_product_loop_start(false),
				'after'  => woocommerce_product_loop_end(false)
			))
			) :

				wc_get_template('loop/no-products-found.php');

			endif;

		}
	}
}

//Define number of products per page
add_filter('loop_shop_per_page', 'deploy_mikado_woocommerce_products_per_page', 20);

//Set number of related products
add_filter('woocommerce_output_related_products_args', 'deploy_mikado_woocommerce_related_products_args');

//Overide Product List Loop Title
remove_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10);
add_action('woocommerce_shop_loop_item_title', 'deploy_mikado_woocommerce_template_loop_product_title', 10);

//Change order of rating and title in product list
remove_action('woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);
add_action('woocommerce_shop_loop_item_title', 'woocommerce_template_loop_rating', 5);

//Override Product List Loop Add To Cart
add_filter('woocommerce_loop_add_to_cart_link', 'deploy_mikado_woocommerce_loop_add_to_cart_link');

//Single Product override tabs position
remove_action('woocommerce_after_single_product_summary', 'woocommerce_output_product_data_tabs', 10);
add_action('woocommerce_single_product_summary', 'woocommerce_output_product_data_tabs', 60);

//Sale flash template override
add_filter('woocommerce_sale_flash', 'deploy_mikado_woocommerce_sale_flash');

//Override Checkout Fields
add_filter('woocommerce_checkout_fields', 'deploy_mikado_custom_override_checkout_fields');

//Set Woocommerce button style
//Simple and grouped products
add_action('deploy_mikado_woocommerce_add_to_cart_button', 'deploy_mikado_get_woocommerce_add_to_cart_button');

//External product
add_action('deploy_mikado_woocommerce_add_to_cart_button_external', 'deploy_mikado_get_woocommerce_add_to_cart_button_external');

//Variable product
remove_action('woocommerce_single_variation', 'woocommerce_single_variation_add_to_cart_button', 20);
add_action('woocommerce_single_variation', 'deploy_mikado_woocommerce_single_variation_add_to_cart_button', 20);

//Apply Coupon Button
add_action('deploy_mikado_woocommerce_apply_coupon_button', 'deploy_mikado_get_woocommerce_apply_coupon_button');

//Update Cart
add_action('deploy_mikado_woocommerce_update_cart_button', 'deploy_mikado_get_woocommerce_update_cart_button');

//Proceed To Checkout Button
remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20);
add_action('woocommerce_proceed_to_checkout', 'deploy_mikado_woocommerce_button_proceed_to_checkout', 20);

//Update Totals Button, Shipping Calculator
add_action('deploy_mikado_woocommerce_update_totals_button', 'deploy_mikado_get_woocommerce_update_totals_button');

//Pay For Order Button, Checkout page
add_filter('woocommerce_pay_order_button_html', 'deploy_mikado_woocommerce_pay_order_button_html');

//Place Order Button, Checkout page
add_filter('woocommerce_order_button_html', 'deploy_mikado_woocommerce_order_button_html');

//Add div before shop list item
add_action('woocommerce_before_shop_loop_item', 'deploy_mikado_woo_before_product_list_item', 1);
add_action('woocommerce_after_shop_loop_item', 'deploy_mikado_woo_after_product_list_item', 1000);

//Add out of stock notice to products loop
add_action('woocommerce_before_shop_loop_item_title', 'deploy_mikado_woocommerce_loop_out_of_stock');

//Single Product Title template override
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10);
add_action('deploy_mikado_woocommerce_single_product_title', 'deploy_mikado_woocommerce_template_single_title', 5);
add_action('deploy_mikado_woocommerce_single_product_title', 'woocommerce_template_single_rating');
add_action('deploy_mikado_woocommerce_after_single_product_title', 'deploy_mikado_woocommerce_single_product_category');

//remove excerpt from single product page
remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);

//remove upsell products from single product page
remove_action('woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15);

remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
add_action('woocommerce_before_product_thumbnails', 'woocommerce_show_product_sale_flash');

//change order of cross-sells and cart totals
remove_action('woocommerce_cart_collaterals', 'woocommerce_cross_sell_display');
add_action('woocommerce_after_cart', 'woocommerce_cross_sell_display', 10);

//change place of payment options on checkout page
remove_action('woocommerce_checkout_order_review', 'woocommerce_checkout_payment', 20);
add_action('woocommerce_checkout_after_order_review', 'woocommerce_checkout_payment');