<?php do_action('deploy_mikado_before_mobile_logo'); ?>

<div class="mkdf-mobile-logo-wrapper">
    <a href="<?php echo esc_url(home_url('/')); ?>" <?php deploy_mikado_inline_style($logo_styles); ?>>
        <img src="<?php echo esc_url($logo_image); ?>" alt="<?php esc_attr_e('mobile-logo', 'deploy') ?>"/>
    </a>
</div>

<?php do_action('deploy_mikado_after_mobile_logo'); ?>