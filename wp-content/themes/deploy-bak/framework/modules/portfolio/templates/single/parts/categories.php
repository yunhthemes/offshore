<?php if(deploy_mikado_options()->getOptionValue('portfolio_single_hide_categories') !== 'yes') : ?>

    <?php
    $categories   = wp_get_post_terms(get_the_ID(), 'portfolio-category');
    $categy_names = array();

    if(is_array($categories) && count($categories)) :
        foreach($categories as $category) {
            $categy_names[] = $category->name;
        }

        ?>
        <div class="mkdf-portfolio-categories">
            <span>
                <?php echo esc_html(implode(', ', $categy_names)); ?>
            </span>
        </div>
    <?php endif; ?>

<?php endif; ?>