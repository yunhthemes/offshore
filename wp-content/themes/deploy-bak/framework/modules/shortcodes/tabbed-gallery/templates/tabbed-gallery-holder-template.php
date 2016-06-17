<div class="mkdf-tabbed-gallery">
	<div class="mkdf-tabbed-gallery-inner clearfix">
		<?php if($title !== '') : ?>
			<div class="mkdf-tg-title">
				<span><?php echo esc_html($title); ?></span>
			</div>
		<?php endif; ?>

		<?php if(is_array($tabs_titles) && count($tabs_titles)) : ?>
			<ul class="mkdf-tg-nav clearfix">
				<?php  foreach($tabs_titles as $tab_title) { ?>
					<li>
						<a href="#tab-<?php echo sanitize_title($tab_title)?>">
							<?php echo esc_attr($tab_title); ?>
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php endif; ?>

		<?php if(is_array($button_params) && count($button_params)) : ?>
			<div class="mkdf-tg-btn-holder">
				<?php echo deploy_mikado_get_button_html($button_params); ?>
			</div>
		<?php endif; ?>
	</div>

	<?php echo do_shortcode($content); ?>
</div>