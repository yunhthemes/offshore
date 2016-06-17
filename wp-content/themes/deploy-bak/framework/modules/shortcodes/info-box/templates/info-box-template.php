<div <?php deploy_mikado_class_attribute($holder_classes); ?>>

	<div class="mkdf-info-box-inner">
		<div class="mkdf-ib-back-holder">
			<?php if($show_icon) : ?>
				<div class="mkdf-ib-icon-holder">
					<?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack, array(
						'icon_attributes' => array(
							'style' => $icon_styles
						)
					)); ?>
				</div>
			<?php endif; ?>

			<?php if(!empty($back_side_content)) : ?>
				<div class="mkdf-ib-back-content-holder">
					<p><?php echo esc_html($back_side_content); ?></p>
				</div>
			<?php endif; ?>

			<?php if(is_array($button_params) && count($button_params)) : ?>
				<div class="mkdf-ib-btn-holder">
					<?php echo deploy_mikado_get_button_html($button_params); ?>
				</div>
			<?php endif; ?>
		</div>
		<div class="mkdf-ib-front-holder">
			<div class="mkdf-ib-front-holder-inner">
				<?php if(!empty($title)) : ?>
					<div class="mkdf-ib-title-holder">
						<h2 class="mkdf-ib-title"><?php echo esc_html($title); ?></h2>
					</div>
				<?php endif; ?>

				<?php if(!empty($subtitle)) : ?>
					<div class="mkdf-ib-subtitle-holder">
						<h4 class="mkdf-ib-subtitle"><?php echo esc_html($subtitle); ?></h4>
					</div>
				<?php endif; ?>

				<?php if(!empty($front_side_content)) : ?>
					<div class="mkdf-ib-front-side-content-holder">
						<p><?php echo esc_html($front_side_content); ?></p>
					</div>
				<?php endif; ?>
			</div>

		</div>



		<div class="mkdf-ib-overlay" <?php deploy_mikado_inline_style($holder_styles); ?>></div>
	</div>
</div>