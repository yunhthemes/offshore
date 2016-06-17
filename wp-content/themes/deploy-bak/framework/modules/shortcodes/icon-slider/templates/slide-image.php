<?php if($slide_image) : ?>
    <div class="mkdf-icon-slide-image">
        <?php echo wp_get_attachment_image($slide_image, 'full'); ?>
    </div>
<?php endif; ?>