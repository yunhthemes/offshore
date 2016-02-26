<li class="mkdf-blog-list-item clearfix">
	<div class="mkdf-blog-list-item-inner">
		<div class="mkdf-item-image clearfix">
			<a href="<?php echo esc_url(get_permalink()) ?>">
				<?php
					echo get_the_post_thumbnail(get_the_ID(), $thumb_image_size);
				?>				
			</a>
		</div>
		<div class="mkdf-item-text-holder">
			<<?php echo esc_html($title_tag)?> class="mkdf-item-title ">
				<a href="<?php echo esc_url(get_permalink()) ?>" >
					<?php echo esc_attr(get_the_title()) ?>
				</a>
			</<?php echo esc_html($title_tag) ?>>

			<?php if ($text_length != '0') {
				$excerpt = ($text_length > 0) ? substr(get_the_excerpt(), 0, intval($text_length)) : get_the_excerpt(); ?>
				<p class="mkdf-excerpt"><?php echo esc_html($excerpt)?>...</p>
			<?php } ?>
		<div class="mkdf-item-info-section">
			<i class="mkdff-icon-simple-line-icon icon-calender"></i>
			<span class="mkdf-blog-date"><?php the_time('M d, Y'); ?></span>
		</div>
		</div>
	</div>	
</li>
