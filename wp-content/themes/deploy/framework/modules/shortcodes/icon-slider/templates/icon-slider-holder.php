<div class="mkdf-icon-slider-holder">
    <div class="mkdf-icon-slider-nav">
        <?php
        preg_match_all('/\[mkdf_icon_slider([^\]]*)\]/', $content, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as $icon_family) :
            preg_match('/icon_family="([^\"]+)/i', $icon_family[0], $icon_family_match, PREG_OFFSET_CAPTURE);
            preg_match('/slide_title="([^\"]+)/i', $icon_family[0], $slide_title_match, PREG_OFFSET_CAPTURE);
            $icon_collection_obj = deploy_mikado_icon_collections()->getIconCollection($icon_family_match[1][0]);
            preg_match('/icon_'.$icon_collection_obj->param.'\=\"([^\"]+)\"/i', $icon_family[0], $icon_match, PREG_OFFSET_CAPTURE);
        ?>
            <div class="mkdf-icon-slider-nav-item">
                <?php if(method_exists($icon_collection_obj, 'render')) : ?>
                    <span class="mkdf-icon-slider-nav-icon">
                    <?php print $icon_collection_obj->render($icon_match[1][0], array(
                        'icon_attributes' => array(
                            'class' => 'mkdf-icon-slider-icon'
                        )
                    )); ?>
                </span>
                <?php endif; ?>
                <?php if(is_array($slide_title_match) && count($slide_title_match)) : ?>
                    <h6 class="mkdf-icon-slider-nav-title"><?php echo esc_html($slide_title_match[1][0]); ?></h6>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="mkdf-icon-slider-container">
        <ul class="mkdf-icon-slider-container-inner">
            <?php echo do_shortcode($content); ?>
        </ul>
    </div>
</div>