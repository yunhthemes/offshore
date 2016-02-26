<div class="mkdf-blog-holder mkdf-blog-type-standard">
	<?php
		if($blog_query->have_posts()) : while ( $blog_query->have_posts() ) : $blog_query->the_post();
			deploy_mikado_get_post_format_html($blog_type);
		endwhile;
		else:
			deploy_mikado_get_module_template_part('templates/parts/no-posts', 'blog');
		endif;
	?>

	<?php if(deploy_mikado_options()->getOptionValue('pagination') == 'yes') {
		deploy_mikado_get_blog_pagination_template($blog_type, $blog_query, $blog_page_range, $paged);
	} ?>
</div>
