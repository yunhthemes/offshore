<?php if($icon_animation_holder) : ?>
    <span class="mkdf-icon-animation-holder" <?php deploy_mikado_inline_style($icon_animation_holder_styles); ?>>
<?php endif; ?>

    <span <?php deploy_mikado_class_attribute($icon_holder_classes); ?> <?php deploy_mikado_inline_style($icon_holder_styles); ?> <?php echo deploy_mikado_get_inline_attrs($icon_holder_data); ?>>
        <?php if($link !== '') : ?>
            <a href="<?php echo esc_url($link); ?>" target="<?php echo esc_attr($target); ?>">
        <?php endif; ?>

                <?php if($has_icon) : ?>
                    <span class="mkdf-image-icon">
						<?php if($show_image) : ?>
                            <?php echo wp_get_attachment_image($image); ?>
                        <?php else: ?>
                            <?php echo deploy_mikado_icon_collections()->renderIcon($icon, $icon_pack, $icon_params); ?>
                        <?php endif; ?>
                    </span>
                <?php endif; ?>

        <?php if($link !== '') : ?>
            </a>
        <?php endif; ?>
    </span>

<?php if($icon_animation_holder) : ?>
    </span>
<?php endif; ?>
