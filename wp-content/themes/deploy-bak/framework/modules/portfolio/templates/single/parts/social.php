<?php if(deploy_mikado_options()->getOptionValue('enable_social_share') == 'yes') : ?>
    <div class="mkdf-portfolio-social">
        <?php echo deploy_mikado_get_social_share_html(array('type' => 'dropdown')); ?>
    </div>
<?php endif; ?>