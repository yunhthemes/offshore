<div class="mkdf-tabs <?php echo esc_attr($tab_class) ?> clearfix">
	<div class="mkdf-tabs-nav-holder">
		<ul class="mkdf-tabs-nav">
			<?php  foreach ($tabs_titles as $tab_title) {?>
				<li>
					<a href="#tab-<?php echo sanitize_title($tab_title)?>">
						<?php echo esc_attr($tab_title)?>
					</a>
					<span class="mkdf-tabs-shadow"></span>
				</li>
			<?php } ?>
		</ul>
	</div>
	<?php echo do_shortcode($content) ?>
</div>

