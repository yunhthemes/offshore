<?php if(deploy_mikado_options()->getOptionValue('portfolio_single_hide_date') !== 'yes') : ?>

    <div class="mkdf-portfolio-info-item mkdf-portfolio-date">
        <h6><?php esc_html_e('Date', 'deploy'); ?>:</h6>

        <span><?php the_time(get_option('date_format')); ?></span>
    </div>

<?php endif; ?>