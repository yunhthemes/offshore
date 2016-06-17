<form role="search" method="get" class="searchform" action="<?php echo esc_url( home_url( '/'  ) ); ?>">
	<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search Products&hellip;', 'placeholder', 'deploy'); ?>" value="<?php echo get_search_query(); ?>" name="s" title="<?php echo esc_attr_x( 'Search for:', 'label', 'deploy'); ?>" />
	<input type="submit" id="searchsubmit" value="&#xe090" />
	<input type="hidden" name="post_type" value="product" />
</form>
