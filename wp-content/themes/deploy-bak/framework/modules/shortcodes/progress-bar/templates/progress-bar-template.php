<div class="mkdf-progress-bar">
	<div class="mkdf-progress-title-holder clearfix">
		<span class="mkdf-progress-title"><?php echo esc_attr($title)?></span>
			<span class="mkdf-progress-number-wrapper" >
				<span class="mkdf-progress-number">
					<span class="mkdf-percent">0</span>
				</span>
		</span>
	</div>
<div class="mkdf-progress-content-outer" <?php deploy_mikado_inline_style($inactive_bar_style); ?>>
	<div data-percentage=<?php echo esc_attr($percent)?> class="mkdf-progress-content" <?php deploy_mikado_inline_style($bar_styles); ?>></div>
</div>
</div>	