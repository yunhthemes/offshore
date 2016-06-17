<?php
$tags = wp_get_post_terms(get_the_ID(), 'portfolio-tag');
$tag_names = array();

if(is_array($tags) && count($tags)) :
    foreach($tags as $tag) {
        $tag_names[] = $tag->name;
    }

    ?>
    <div class="mkdf-portfolio-info-item mkdf-portfolio-tags">
        <h6><?php esc_html_e('Tags', 'deploy'); ?>:</h6>
        <span>
            <?php echo esc_html(implode(', ', $tag_names)); ?>
        </span>
    </div>
<?php endif; ?>
