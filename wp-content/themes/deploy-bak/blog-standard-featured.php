<?php
/*
	Template Name: Blog: Standard With Featured Post
*/
?>
<?php get_header(); ?>
<?php deploy_mikado_get_title(); ?>
<?php get_template_part('slider'); ?>
	<div class="mkdf-container">
		<?php do_action('deploy_mikado_after_container_open'); ?>
		<div class="mkdf-container-inner" >
			<?php deploy_mikado_get_blog('standard-featured'); ?>
		</div>
		<?php do_action('deploy_mikado_before_container_close'); ?>
	</div>
<?php get_footer(); ?>