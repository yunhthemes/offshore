<?php
if(get_next_posts_page_link($blog_query->max_num_pages)) { ?>
	<div class="mkdf-blog-<?php echo esc_attr($pagination_type); ?>-button-holder">
		<span class="mkdf-blog-<?php echo esc_attr($pagination_type); ?>-button" data-rel="<?php echo esc_attr($blog_query->max_num_pages); ?>">
			<?php
			echo deploy_mikado_get_button_html(array(
				'link'      => get_next_posts_page_link($blog_query->max_num_pages),
				'text'      => esc_html__('Show more', 'deploy'),
				'icon_pack' => 'font_elegant',
				'fe_icon'   => 'arrow_right'
			));
			?>
		</span>
	</div>
<?php } ?>