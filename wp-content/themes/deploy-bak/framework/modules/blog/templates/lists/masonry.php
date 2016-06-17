<?php  deploy_mikado_get_module_template_part('templates/lists/parts/filter', 'blog'); ?>
<div class="mkdf-blog-holder mkdf-blog-type-masonry mkdf-masonry-pagination-<?php echo deploy_mikado_options()->getOptionValue('masonry_pagination'); ?>">
	<div class="mkdf-blog-masonry-grid-sizer"></div>
	<div class="mkdf-blog-masonry-grid-gutter"></div>
	<?php
	if($blog_query->have_posts()) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
		deploy_mikado_get_post_format_html($blog_type);
	endwhile;
	else:
		deploy_mikado_get_module_template_part('templates/parts/no-posts', 'blog');
	endif;
	?>
</div>

<?php if(deploy_mikado_options()->getOptionValue('pagination') == 'yes') {
	deploy_mikado_get_blog_pagination_template($blog_type, $blog_query, $blog_page_range, $paged);
} ?>

