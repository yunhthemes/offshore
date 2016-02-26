<a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>" <?php deploy_mikado_inline_style($button_styles); ?> <?php deploy_mikado_class_attribute($button_classes); ?> <?php echo deploy_mikado_get_inline_attrs($button_data); ?> <?php echo deploy_mikado_get_inline_attrs($button_custom_attrs); ?>>
    <?php if($show_icon) : ?>
        <span class="mkdf-btn-icon-holder">
            <?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack, array(
                'icon_attributes' => array(
                    'class' => 'mkdf-btn-icon-elem'
                )
            )); ?>
            <?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack, array(
                'icon_attributes' => array(
                    'class' => 'mkdf-btn-icon-elem hover'
                )
            )); ?>
        </span>
    <?php endif; ?>
    <span class="mkdf-btn-text"><?php echo esc_html($text); ?></span>
</a>