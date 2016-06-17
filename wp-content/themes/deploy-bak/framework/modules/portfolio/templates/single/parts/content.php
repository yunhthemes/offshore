<div class="mkdf-portfolio-info-item mkdf-portfolio-content-holder">
    <h2 class="mkdf-portfolio-single-title"><?php the_title(); ?></h2>
	<div class="mkdf-portfolio-category-holder">
		<?php deploy_mikado_portfolio_get_info_part('categories'); ?>
	</div>
    <div class="mkdf-portfolio-content">
        <?php the_content(); ?>
    </div>
</div>