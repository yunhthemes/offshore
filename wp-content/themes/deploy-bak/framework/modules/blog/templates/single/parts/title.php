<?php
	if(isset($title_tag)){
		$title_tag = $title_tag;
	}else{
		$title_tag = 'h3';
	}
?>
<<?php echo esc_attr($title_tag);?> class="mkdf-post-title">
	<?php the_title(); ?>
</<?php echo esc_attr($title_tag);?>>