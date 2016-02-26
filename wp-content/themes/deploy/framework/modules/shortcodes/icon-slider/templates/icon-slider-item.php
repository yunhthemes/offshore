<li class="mkdf-icon-slider-item">
    <div class="mkdf-icon-slide-holder">
        <?php if($image_position === 'left') : ?>
            <?php echo deploy_mikado_get_shortcode_module_template_part('templates/slide-image', 'icon-slider', '', array('slide_image' => $slide_image)); ?>
            <?php echo deploy_mikado_get_shortcode_module_template_part('templates/slide-content', 'icon-slider', '', array('content' => $content)); ?>
        <?php elseif($image_position === 'right') : ?>
            <?php echo deploy_mikado_get_shortcode_module_template_part('templates/slide-content', 'icon-slider', '', array('content' => $content)); ?>
            <?php echo deploy_mikado_get_shortcode_module_template_part('templates/slide-image', 'icon-slider', '', array('slide_image' => $slide_image)); ?>
        <?php endif; ?>

    </div>
</li>