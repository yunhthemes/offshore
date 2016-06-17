<?php if(deploy_mikado_options()->getOptionValue('portfolio_single_hide_pagination') !== 'yes') : ?>

    <?php
    $back_to_link = get_post_meta(get_the_ID(), 'mkdf_portfolio_single_back_to_link', true);
    $nav_same_category = deploy_mikado_options()->getOptionValue('portfolio_single_nav_same_category') == 'yes';
    ?>

    <div class="mkdf-portfolio-single-nav">
        <?php if(get_previous_post() !== '') : ?>
            <div class="mkdf-portfolio-prev">
                <?php if($nav_same_category) {
                    previous_post_link('%link', deploy_mikado_icon_collections()->renderIcon('icon-arrow-left-circle', 'simple_line_icons').'<span class="mkdf-portfolio-nav-title">'.esc_html__('Previous', 'deploy').'</span>', true, '', 'portfolio_category');
                } else {
                    previous_post_link('%link', deploy_mikado_icon_collections()->renderIcon('icon-arrow-left-circle', 'simple_line_icons').'<span class="mkdf-portfolio-nav-title">'.esc_html__('Previous', 'deploy').'</span>');
                } ?>
            </div>
        <?php endif; ?>

        <?php if($back_to_link !== '') : ?>
            <div class="mkdf-portfolio-back-btn">
                <a href="<?php echo esc_url(get_permalink($back_to_link)); ?>">
                    <?php echo deploy_mikado_icon_collections()->renderIcon('icon_grid-2x2', 'font_elegant'); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if(get_next_post() !== '') : ?>
            <div class="mkdf-portfolio-next">
                <?php if($nav_same_category) {
                    next_post_link('%link', '<span class="mkdf-portfolio-nav-title">'.esc_html__('Next', 'deploy').'</span>'.deploy_mikado_icon_collections()->renderIcon('icon-arrow-right-circle', 'simple_line_icons'), true, '', 'portfolio_category');
                } else {
                    next_post_link('%link', '<span class="mkdf-portfolio-nav-title">'.esc_html__('Next', 'deploy').'</span>'.deploy_mikado_icon_collections()->renderIcon('icon-arrow-right-circle', 'simple_line_icons'));
                } ?>
            </div>
        <?php endif; ?>
    </div>

<?php endif; ?>