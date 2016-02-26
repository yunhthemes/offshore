<div class="mkdf-carousel-item-holder <?php if($hover_image !== '') { echo esc_attr('mkdf-carousel-item-with-hover-image'); } ?>">
	<?php if ($link !== '') { ?>
	<a href="<?php echo esc_url($link)?>" target="<?php echo esc_attr($target)?>">
	<?php } ?>
		<?php if ($image !== '') { ?>
			<span class="mkdf-carousel-first-image-holder <?php echo esc_attr($hover_class); ?> <?php echo esc_attr($carousel_image_classes); ?>">
				<?php echo wp_get_attachment_image($image_id, 'full'); ?>
			</span>
		<?php } ?>
		<?php if ($hover_image !== '') { ?>
			<span class="mkdf-carousel-second-image-holder <?php echo esc_attr($hover_class); ?> <?php echo esc_attr($carousel_image_classes); ?>">
				<?php echo wp_get_attachment_image($hover_image_id, 'full'); ?>
			</span>
		<?php } ?>
	<?php if ($link !== '') { ?>
	</a>
	<?php } ?>
</div>