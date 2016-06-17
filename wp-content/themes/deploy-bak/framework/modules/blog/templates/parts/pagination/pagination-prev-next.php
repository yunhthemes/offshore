<div class="mkdf-prev-next-pagination">
	<?php if(get_previous_posts_link('', $blog_query->max_num_pages)) : ?>
		<span class="mkdf-prev-posts-link">
			<?php previous_posts_link(deploy_mikado_icon_collections()->renderIcon('icon-arrow-left-circle', 'simple_line_icons').esc_html__('Previous', 'deploy'), $blog_query->max_num_pages); ?>
		</span>
	<?php endif; ?>

	<?php if(get_next_posts_link('', $blog_query->max_num_pages)) : ?>
		<span class="mkdf-next-posts-link">
			<?php next_posts_link(deploy_mikado_icon_collections()->renderIcon('icon-arrow-right-circle', 'simple_line_icons').esc_html__('Next', 'deploy'), $blog_query->max_num_pages); ?>
		</span>
	<?php endif; ?>
</div>