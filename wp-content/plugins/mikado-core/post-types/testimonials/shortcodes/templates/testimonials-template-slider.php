<div <?php mkd_core_inline_style($content_styles); ?> id="mkdf-testimonials<?php echo esc_attr($current_id) ?>" class="mkdf-testimonial-content">
    <?php if (has_post_thumbnail($current_id)) { ?>
    <?php } ?>
    <div class="mkdf-testimonial-content-inner">
        <div class="mkdf-testimonial-text-holder">
            <div class="mkdf-testimonial-text-inner">
                <p class="mkdf-testimonial-text"><?php echo trim($text) ?></p>

                <?php if($show_author == 'yes') : ?>
                    <div class = "mkdf-testimonial-author">
                        <p <?php mkd_core_inline_style($author_styles); ?> class="mkdf-testimonial-author-text"><?php echo esc_html($author)?></p>
                    </div>
                    <p class="mkdf-testimonial-slider-job"><?php echo esc_html($job)?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
