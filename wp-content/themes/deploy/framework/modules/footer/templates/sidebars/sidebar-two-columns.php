<div class="mkdf-two-columns-50-50 clearfix">
	<div class="mkdf-two-columns-50-50-inner">
		<div class="mkdf-column">
			<div class="mkdf-column-inner">
				<?php if(is_active_sidebar('footer_column_1')) {
					dynamic_sidebar( 'footer_column_1' );
				} ?>
			</div>
		</div>
		<div class="mkdf-column">
			<div class="mkdf-column-inner">
				<?php if(is_active_sidebar('footer_column_2')) {
					dynamic_sidebar( 'footer_column_2' );
				} ?>
			</div>
		</div>
	</div>
</div>