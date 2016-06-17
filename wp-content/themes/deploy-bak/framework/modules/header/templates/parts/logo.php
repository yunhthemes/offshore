<?php do_action('deploy_mikado_before_site_logo'); ?>

<div class="mkdf-logo-wrapper">
    <a href="<?php echo esc_url(home_url('/')); ?>" <?php deploy_mikado_inline_style($logo_styles); ?>>
        <img class="mkdf-normal-logo" src="<?php echo esc_url($logo_image); ?>" alt="<?php esc_attr_e('logo', 'deploy') ?>"/>
        <?php if(!empty($logo_image_dark)){ ?><img class="mkdf-dark-logo" src="<?php echo esc_url($logo_image_dark); ?>" alt="<?php esc_attr_e('dark logo', 'deploy'); ?>"/><?php } ?>
        <?php if(!empty($logo_image_light)){ ?><img class="mkdf-light-logo" src="<?php echo esc_url($logo_image_light); ?>" alt="<?php esc_attr_e('light logo', 'deploy') ?>"/><?php } ?>
    </a>
</div>

<?php do_action('deploy_mikado_after_site_logo'); ?>