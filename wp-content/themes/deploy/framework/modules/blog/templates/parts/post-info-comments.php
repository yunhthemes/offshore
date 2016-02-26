<div class="mkdf-post-info-comments-holder mkdf-post-info-item">
    <a class="mkdf-post-info-comments" href="<?php comments_link(); ?>" target="_self">
        <span class="mkdf-blog-comments-icon">
            <?php echo deploy_mikado_icon_collections()->renderIcon('icon-bubble', 'simple_line_icons'); ?>
        </span>

        <?php if(in_array($blog_type, array('masonry', 'masonry-full-width'))) {
            comments_number('0', '1', '%');
        } else {
            comments_number('0 ' . esc_html__('Comments','deploy'), '1 '.esc_html__('Comment', 'deploy'), '% '.esc_html__('Comments', 'deploy') );
        } ?>
    </a>
</div>