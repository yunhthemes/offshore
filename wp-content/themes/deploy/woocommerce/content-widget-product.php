<?php global $product; ?>
<li>
	<a class="mkdf-woo-product-widget-image" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>" title="<?php echo esc_attr( $product->get_title() ); ?>">
		<?php echo deploy_mikado_kses_img($product->get_image()); ?>
	</a>
	<div class="mkdf-woo-product-widget-content">
		<a class="mkdf-woo-product-widget-title" href="<?php echo esc_url( get_permalink( $product->id ) ); ?>">
			<span class="product-title"><?php echo esc_html($product->get_title()); ?></span>
		</a>
		<?php print $product->get_price_html(); ?>
	</div>

</li>