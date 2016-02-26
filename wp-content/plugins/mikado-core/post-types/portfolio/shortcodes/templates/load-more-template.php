<?php if($query_results->max_num_pages>1) { ?>
	<div class="mkdf-ptf-list-paging mkdf-load-more-btn-holder">
		<span class="mkdf-ptf-list-load-more">
			<?php if(mkd_core_theme_installed()) : ?>
				<?php echo deploy_mikado_get_button_html(array(
					'link' => '#',
					'text' => esc_html__('See More', 'mkd_core'),
					'type' => 'solid',
					'size' => 'large'
				)); ?>
			<?php else: ?>
				<a href="#"><?php esc_html_e('See More', 'mkd_core'); ?></a>
			<?php endif; ?>
		</span>
		<div class="mkdf-pulse-loader-holder">
			<div class="mkdf-pulse-loader"></div>
		</div>
	</div>
<?php }