<?php
if(get_next_posts_page_link($blog_query->max_num_pages)) { ?>
	<div class="mkdf-blog-<?php echo esc_attr($pagination_type); ?>-button-holder mkdf-load-more-btn-holder">
		<span class="mkdf-blog-<?php echo esc_attr($pagination_type); ?>-button" data-rel="<?php echo esc_attr($blog_query->max_num_pages); ?>">
			<?php echo deploy_mikado_get_button_html(array(
				'link' => '#',
				'text' => esc_html__('See More', 'deploy'),
				'type' => 'solid'
			)); ?>
		</span>
		<div class="mkdf-pulse-loader-holder">
			<div class="mkdf-pulse-loader"></div>
		</div>

	</div>
<?php } ?>