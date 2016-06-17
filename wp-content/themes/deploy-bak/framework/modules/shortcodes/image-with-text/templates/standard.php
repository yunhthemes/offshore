<div class="mkdf-image-with-text-holder <?php echo esc_attr($image_with_text_type); ?>">

    <?php if ($image !== '') { ?>
        <div class="mkdf-imt-image">
            <?php echo wp_get_attachment_image($image, 'full'); ?>

            <?php if(!empty($link)) : ?>
                <a href="<?php echo esc_url($link); ?>">
            <?php endif; ?>

            <div class="mkdf-imt-overlay">
                <div class="mkdf-imt-icon-holder">
                    <?php if ($icon !== '') {?>
                    <?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack); ?>
                    <?php } ?>
                </div>
            </div>

            <?php if(!empty($link)) : ?>
                </a>
            <?php endif; ?>
        </div>
    <?php } ?>


    <div class="mkdf-content-holder">
        <h4 class="mkdf-image-with-text-title">
            <?php echo esc_html($title); ?>
        </h4>
        <?php if ($text != "") { ?>
            <p class="mkdf-image-with-text"><?php echo esc_html($text); ?></p>
        <?php } ?>

        <div class="mkdf-imt-link-holder">
	        <a class="mkdf-arrow-link" href="<?php echo esc_url($link); ?>" <?php deploy_mikado_inline_attr($target, 'target'); ?>>
	            <span class="mkdf-al-icon">
					<span class="icon-arrow-right-circle"></span>
				</span>
		        <span class="mkdf-al-text"><?php echo esc_html($link_text); ?></span>
	        </a>
        </div>
    </div>
</div>

