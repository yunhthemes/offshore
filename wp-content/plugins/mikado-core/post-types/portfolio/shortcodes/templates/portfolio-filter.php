<div class="mkdf-portfolio-filter-holder">
	<div class="mkdf-portfolio-filter-holder-inner">
		<?php $rand_number = rand(); ?>
		<?php if(is_array($filter_categories) && count($filter_categories)) { ?>
			<ul>
				<li data-class="filter_<?php print $rand_number ?>" class="filter_<?php print $rand_number ?>" data-filter="all">
					<span><?php print __('All', 'mkd_core') ?></span></li>

				<?php foreach($filter_categories as $cat) { ?>
					<li data-class="filter_<?php print $rand_number ?>" class="filter_<?php print $rand_number ?>" data-filter=".portfolio_category_<?php print $cat->term_id ?>">
					<span>
						<?php print $cat->name ?>
					</span>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	</div>
</div>