<?php if(($sidebar == "default")||($sidebar == "")) : ?>
	<div class="mkdf-blog-holder mkdf-blog-single">
		<?php deploy_mikado_get_single_html(); ?>
	</div>
<?php elseif($sidebar == 'sidebar-33-right' || $sidebar == 'sidebar-25-right'): ?>
	<div <?php echo deploy_mikado_sidebar_columns_class(); ?>>
		<div class="mkdf-column1 mkdf-content-left-from-sidebar">
			<div class="mkdf-column-inner">
				<div class="mkdf-blog-holder mkdf-blog-single">
					<?php deploy_mikado_get_single_html(); ?>
				</div>
			</div>
		</div>
		<div class="mkdf-column2">
			<?php get_sidebar(); ?>
		</div>
	</div>
<?php elseif($sidebar == 'sidebar-33-left' || $sidebar == 'sidebar-25-left'): ?>
	<div <?php echo deploy_mikado_sidebar_columns_class(); ?>>
		<div class="mkdf-column1">
			<?php get_sidebar(); ?>
		</div>
		<div class="mkdf-column2 mkdf-content-right-from-sidebar">
			<div class="mkdf-column-inner">
				<div class="mkdf-blog-holder mkdf-blog-single">
					<?php deploy_mikado_get_single_html(); ?>
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>
