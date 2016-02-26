<!--space for right ordering on the list- has to be here-->
<article class="mkdf-portfolio-item mix <?php echo esc_attr($categories) ?>">
	<a class="mkdf-portfolio-link" href="<?php echo esc_url($item_link); ?>" target="<?php echo esc_attr($item_target); ?>"></a>

	<div class="mkdf-item-image-holder">
		<?php
		echo get_the_post_thumbnail(get_the_ID(), $thumb_size);
		?>
	</div>
	<div class="mkdf-item-text-overlay">
		<div class="mkdf-item-text-overlay-inner">
			<div class="mkdf-item-text-holder">
				<<?php echo esc_attr($title_tag) ?> class="mkdf-item-title">
					<?php echo esc_attr(get_the_title()); ?>
				</<?php echo esc_attr($title_tag) ?>>

				<?php if(get_the_excerpt()) : ?>
					<div class="mkdf-item-excerpt"><?php the_excerpt(); ?></div>
				<?php endif; ?>
			<div class="mkdf-item-text-overlay-bg">
			</div>
			</div>
		</div>
	</div>
</article>
<!--space for right ordering on the list- has to be here-->
