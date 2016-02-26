<div class="mkdf-testimonials-item-holder">
    <div <?php mkd_core_inline_style($content_styles); ?> id="mkdf-testimonials<?php echo esc_attr($current_id) ?>" <?php mkd_core_class_attribute($holder_classes); ?>>
        <div class="mkdf-testimonial-content-inner">
            <div class="mkdf-testimonial-text-holder">
                <div class="mkdf-testimonial-text-inner">
                    <p class="mkdf-testimonial-text"><?php echo trim($text) ?></p>
                </div>
            </div>
            <div class="mkdf-triangle"></div>
        </div>
        <?php if (has_post_thumbnail($current_id)) { ?>
            <div class="mkdf-testimonial-image-holder">
                <?php esc_html(the_post_thumbnail($current_id)) ?>
            </div>
        <?php } ?>
        <?php if ($show_author == "yes") { ?>
            <div class = "mkdf-testimonial-author" <?php mkd_core_inline_style($author_styles); ?>>
                <span class="mkdf-testimonial-author-text"><?php echo esc_html($author)?></span>
                <p class="mkdf-testimonial-carousel-job"><?php echo esc_html($job)?></p>
            </div>
        <?php } ?>
    </div>
</div>

