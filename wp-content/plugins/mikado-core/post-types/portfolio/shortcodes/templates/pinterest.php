<article class="mkdf-portfolio-item <?php echo esc_attr($categories)?>" >
	<a class ="mkdf-portfolio-link" href="<?php echo esc_url(get_permalink()) ?>"></a>
	<div class = "mkdf-item-image-holder">
	<?php
		echo get_the_post_thumbnail(get_the_ID(),$thumb_size);
	?>				
	</div>
	<div class="mkdf-item-text-overlay">
		<div class="mkdf-item-text-overlay-inner">
			<div class="mkdf-item-text-holder">
				<?php print $icon_html; ?>
				<<?php echo esc_attr($title_tag) ?> class="mkdf-item-title">
				<?php echo esc_attr(get_the_title()); ?>
			</<?php echo esc_attr($title_tag) ?>>
			<?php print $category_html; ?>
			<div class="mkdf-item-text-overlay-bg">
			</div>
			</div>
		</div>	
	</div>
</article>
