<div class="mkdf-two-columns-66-33 clearfix">
	<div class="mkdf-column1">
		<div class="mkdf-column-inner">
			<?php
			$media = deploy_mikado_get_portfolio_single_media();

			if(is_array($media) && count($media)) : ?>
				<div class="mkdf-portfolio-media mkdf-owl-slider">
					<?php foreach($media as $single_media) : ?>
						<div class="mkdf-portfolio-single-media">
							<?php deploy_mikado_portfolio_get_media_html($single_media); ?>
						</div>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>
			<?php
			deploy_mikado_portfolio_get_info_part('social-and-likes');
			deploy_mikado_get_module_template_part('templates/single/parts/navigation', 'portfolio');
			?>
		</div>
	</div>
	<div class="mkdf-column2">
		<div class="mkdf-column-inner">
			<div class="mkdf-portfolio-info-holder mkdf-follow-portfolio-info">
				<?php
				//get portfolio content section
				deploy_mikado_portfolio_get_info_part('content');

				deploy_mikado_portfolio_get_info_part('author');

				//get portfolio custom fields section
				deploy_mikado_portfolio_get_info_part('custom-fields');

				//get portfolio tags section
				deploy_mikado_portfolio_get_info_part('tags');
				?>
			</div>
		</div>
	</div>
</div>