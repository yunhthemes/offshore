<?php
/**
 * Product quantity inputs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<div class="mkdf-quantity-label">
	<h6><?php esc_html_e('Quantity', 'deploy'); ?></h6>
</div>
<div class="quantity mkdf-quantity-buttons">
	<span class="mkdf-quantity-minus"><span aria-hidden="true" class="arrow_carrot-up"></span></span>
	<input type="text" step="<?php echo esc_attr( $step ); ?>" <?php if ( is_numeric( $min_value ) ) : ?> min="<?php echo esc_attr( $min_value ); ?>"<?php endif; ?><?php if ( is_numeric( $max_value ) ) : ?>max="<?php echo esc_attr( $max_value ); ?>"<?php endif; ?> name="<?php echo esc_attr( $input_name ); ?>" value="<?php echo esc_attr( $input_value ); ?>" title="<?php echo esc_attr_x( 'Qty', 'Product quantity input tooltip', 'deploy') ?>" class="input-text qty text mkdf-quantity-input" size="4" />
	<span class="mkdf-quantity-plus"><span aria-hidden="true" class="arrow_carrot-up"></span></span>
</div>
