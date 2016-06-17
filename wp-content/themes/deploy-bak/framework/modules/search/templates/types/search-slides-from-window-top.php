<?php ?>
<form role="search" action="<?php echo esc_url(home_url('/')); ?>" class="mkdf-search-slide-window-top" method="get">
	<?php if ( $search_in_grid ) { ?>
		<div class="mkdf-container">
			<div class="mkdf-container-inner clearfix">
				<?php } ?>
					<div class="form-inner">
						<i class="fa fa-search"></i>
						<input type="text" placeholder="<?php esc_attr_e('Search', 'deploy'); ?>" name="s" class="mkdf-search-field" autocomplete="off" />
						<input type="submit" value="Search" />
						<div class="mkdf-search-close">
							<a href="#">
								<i class="fa fa-times"></i>
							</a>
						</div>
					</div>
				<?php if ( $search_in_grid ) { ?>
			</div>
		</div>
	<?php } ?>
</form>