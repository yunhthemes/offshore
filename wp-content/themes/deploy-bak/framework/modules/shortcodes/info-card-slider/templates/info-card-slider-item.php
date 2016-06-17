<div class="mkdf-info-card-slider-item">
	<?php if($link !== '') : ?>
		<a target="<?php echo esc_attr($link_target); ?>" href="<?php echo ($link); ?>">
	<?php endif; ?>

	    <div class="mkdf-info-card-front-side">

	        <?php if($show_icon) : ?>
	            <div class="mkdf-info-card-icon-holder">
		            <?php if(isset($show_custom_icon) && $show_custom_icon) : ?>
						<?php echo wp_get_attachment_image($custom_icon); ?>
			        <?php else: ?>
			            <?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack, array(
					            'icon_attributes' => array(
						            'class' => 'mkdf-info-card-icon'
					            )
			            )); ?>
			        <?php endif; ?>
	            </div>
	        <?php endif; ?>
	        <div class="mkdf-info-card-front-side-content">
	            <p><?php echo esc_html($card_content); ?></p>
	        </div>

		    <?php if(!empty($link_text)) : ?>
		        <span class="mkdf-arrow-link">
					<span class="mkdf-al-icon">
						<span class="icon-arrow-right-circle"></span>
					</span>
					<span class="mkdf-al-text"><?php echo esc_html($link_text); ?></span>
				</span>
		    <?php endif; ?>
	    </div>

	<?php if($link !== '') : ?>
		</a>
	<?php endif; ?>
</div>