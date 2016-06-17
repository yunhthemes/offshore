<li class="mkdf-blog-list-item mkdf-blog-list-masonry-item">
	<div class="mkdf-blog-list-item-inner">
		<div class="mkdf-item-image clearfix">
			<a href="<?php echo esc_url(get_permalink()) ?>">
				<?php
					echo get_the_post_thumbnail(get_the_ID(), $thumb_image_size);
				?>				
			</a>
		</div>	
		<div class="mkdf-item-text-holder">
			<<?php echo esc_html( $title_tag)?> class="mkdf-item-title ">
				<a href="<?php echo esc_url(get_permalink()) ?>" >
					<?php echo esc_attr(get_the_title()) ?>
				</a>
			</<?php echo esc_html($title_tag) ?>>
			
			<div class="mkdf-item-info-section">
				<?php deploy_mikado_post_info(array(
					'date' => 'yes',
					'category' => 'yes',
					'author' => 'yes',
					'comments' => 'yes',
					'like' => 'yes'
				)) ?>
			</div>
			<?php if ($text_length != '0') {
				$excerpt = ($text_length > 0) ? substr(get_the_excerpt(), 0, intval($text_length)) : get_the_excerpt(); ?>
				<p class="mkdf-excerpt"><?php echo esc_html($excerpt)?>...</p>
			<?php } ?>
		</div>	
	</div>	
</li>