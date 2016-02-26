<div class="mkdf-portfolio-single-social-holder">
	<div class="mkdf-portfolio-single-social-holder-inner clearfix">
		<div class="mkdf-portfolio-single-likes">
			<?php echo deploy_mikado_like_portfolio_single(); ?>
		</div>
		<?php if(deploy_mikado_options()->getOptionValue('portfolio_single_hide_date') !== 'yes') : ?>
			<div class="mkdf-portfolio-single-date">
				<span class="mkdf-ptf-single-date-icon">
					<?php echo deploy_mikado_icon_collections()->renderIcon('icon_table', 'font_elegant'); ?>
				</span>
				<?php the_time(get_option('date_format')); ?>
			</div>
		<?php endif; ?>
	</div>
	<div class="mkdf-portfolio-single-share mkdf-social-share-left-animation">
		<?php deploy_mikado_portfolio_get_info_part('social'); ?>
	</div>

</div>