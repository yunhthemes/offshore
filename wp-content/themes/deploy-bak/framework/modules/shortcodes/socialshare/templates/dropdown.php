<div class="mkdf-social-share-holder mkdf-dropdown">
	<a href="javascript:void(0)" target="_self" class="mkdf-social-share-dropdown-opener">
		<?php echo deploy_mikado_icon_collections()->renderIcon('icon-share', 'simple_line_icons'); ?>
	</a>
	<div class="mkdf-social-share-dropdown">
		<ul class="clearfix">
			<?php foreach ($networks as $net) {
				print $net;
			} ?>
		</ul>
	</div>
</div>