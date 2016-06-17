<?php if($footer_top_border != '') {
	//Footer top border
	if($footer_top_border_in_grid !== '') { ?>
		<div class="mkdf-footer-ingrid-border-holder-outer">
	<?php } ?>
	<div class="mkdf-footer-top-border-holder <?php echo esc_attr($footer_top_border_in_grid); ?>" <?php deploy_mikado_inline_style($footer_top_border); ?>></div>
	<?php if($footer_top_border_in_grid !== '') { ?>
		</div>
	<?php }
} ?>

<div class="mkdf-footer-top-holder">
	<div class="mkdf-footer-top <?php esc_attr($footer_top_classes); ?>">
		<?php if($footer_in_grid) { ?>

		<div class="mkdf-container">
			<div class="mkdf-container-inner">

		<?php }

		switch ($footer_top_columns) {
			case 6:
				deploy_mikado_get_footer_sidebar_25_25_50();
				break;
			case 5:
				deploy_mikado_get_footer_sidebar_50_25_25();
				break;
			case 4:
				deploy_mikado_get_footer_sidebar_four_columns();
				break;
			case 3:
				deploy_mikado_get_footer_sidebar_three_columns();
				break;
			case 2:
				deploy_mikado_get_footer_sidebar_two_columns();
				break;
			case 1:
				deploy_mikado_get_footer_sidebar_one_column();
				break;
		}

		if($footer_in_grid) { ?>
			</div>
		</div>
	<?php } ?>
	</div>
</div>
