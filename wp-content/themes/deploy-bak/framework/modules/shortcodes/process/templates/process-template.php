<div class="mkdf-process-holder <?php echo esc_attr($position); ?>">

    <span class="mkdf-digit">
        <?php echo esc_html($digit); ?>
    </span>

    <h4 class="mkdf-process-title">
        <?php echo esc_html($title); ?>
    </h4>

    <h5 class="mkdf-process-subtitle">
        <?php echo esc_html($subtitle); ?>
    </h5>

    <?php if ($text != "") { ?>
        <p class="mkdf-process-text"><?php echo esc_html($text); ?></p>
    <?php } ?>

</div>