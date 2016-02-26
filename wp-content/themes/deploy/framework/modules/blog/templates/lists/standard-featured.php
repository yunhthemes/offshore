<?php
$chars_array = deploy_mikado_blog_lists_number_of_chars();
$chars_num = '';
$chars_num_half = '';
if(is_array($chars_array) && array_key_exists('standard-featured', $chars_array)) {
	$chars_num = $chars_array['standard-featured'];
	$chars_num_half = intval($chars_num / 2);
}

?>

<div class="mkdf-blog-holder mkdf-blog-type-standard mkdf-blog-type-standard-featured clearfix">
	<?php
	$count = 0;
	if($blog_query->have_posts()) : while($blog_query->have_posts()) : $blog_query->the_post();
		if($count == 0) : ?>
			<div class="mkdf-blog-sf-full">
				<?php deploy_mikado_get_post_format_html($blog_type); ?>
			</div>
		<div class="mkdf-blog-sf-cols-holder clearfix">
		<?php else: ?>
			<div class="mkdf-blog-sf-col">
				<?php deploy_mikado_get_post_format_html($blog_type, $chars_num_half); ?>
			</div>
		<?php endif; ?>
		<?php $count++;
	endwhile; ?>
		</div>
	<?php else:
		deploy_mikado_get_module_template_part('templates/parts/no-posts', 'blog');
	endif;
	?>

	<?php if(deploy_mikado_options()->getOptionValue('pagination') == 'yes') {
		deploy_mikado_get_blog_pagination_template($blog_type, $blog_query, $blog_page_range, $paged);
	} ?>
</div>
