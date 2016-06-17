<?php ?>
<form action="<?php echo esc_url(home_url('/')); ?>" class="mkdf-search-dropdown-holder" method="get">
	<div class="form-inner">
		<input type="text" placeholder="<?php esc_attr_e('Search...', 'deploy'); ?>" name="s" class="mkdf-search-field" autocomplete="off"/>
	</div>
</form>