<?php
?>
<div class="mkdf-icon-list-item" <?php deploy_mikado_inline_style($list_item_style);?>>
	<div class="mkdf-icon-list-icon-holder">
        <div class="mkdf-icon-list-icon-holder-inner clearfix">
			<?php 
			echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack, $params);
			?>
		</div>
	</div>
	<<?php echo esc_attr($title_tag);?> <?php echo deploy_mikado_get_inline_style($title_style)?>> <?php echo esc_attr($title)?></<?php echo esc_attr($title_tag);?>>
</div>
