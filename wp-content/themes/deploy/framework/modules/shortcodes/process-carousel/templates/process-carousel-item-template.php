<div data-image="<?php echo esc_url(wp_get_attachment_url($image)); ?>" class="mkdf-pc-item-holder cleafix">
	<?php if(!empty($digit)) : ?>
		<div class="mkdf-pc-item-digit-holder">
			<span class="mkdf-pc-item-digit"><?php echo esc_html($digit); ?></span>
		</div>
	<?php endif; ?>
	<div class="mkdf-pc-item-content-holder">
		<?php if(!empty($title)) : ?>
			<h4 class="mkdf-pc-item-title"><?php echo esc_html($title); ?></h4>
		<?php endif; ?>
		<p class="mkdf-pc-item-content"><?php echo esc_html($text); ?></p>
	</div>
</div>