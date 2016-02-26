<?php if($response->status) : ?>
    <?php if(is_array($response->data) && count($response->data)) : ?>
        <div class="mkdf-twitter-slider clearfix">
            <div class="mkdf-twitter-slider-icon">
                <?php echo deploy_mikado_icon_collections()->renderIcon('social_twitter', 'font_elegant'); ?>
            </div>
            <div class="mkdf-twitter-slider-inner" <?php echo deploy_mikado_get_inline_attrs($slider_data); ?>>
                <?php foreach($response->data as $tweet) : ?>
                    <div <?php deploy_mikado_inline_style($tweet_styles); ?> class="item mkdf-twitter-slider-item">
                        <?php echo MikadofTwitterApi::getInstance()->getHelper()->getTweetText($tweet); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

<?php else: ?>
    <?php echo esc_html($response->message); ?>
<?php endif; ?>
