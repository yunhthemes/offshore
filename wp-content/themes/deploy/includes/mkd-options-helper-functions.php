<?php

if(!function_exists('deploy_mikado_is_responsive_on')) {
    /**
     * Checks whether responsive mode is enabled in theme options
     * @return bool
     */
    function deploy_mikado_is_responsive_on() {
        return deploy_mikado_options()->getOptionValue('responsiveness') !== 'no';
    }
}

if(!function_exists('deploy_mikado_is_social_share_enabled')) {
    /**
     * Checks if social share is enabled
     *
     * @return bool
     */
    function deploy_mikado_is_social_share_enabled() {
        return deploy_mikado_options()->getOptionValue('enable_social_share') == 'yes';
    }
}

if(!function_exists('deploy_mikado_is_blog_like_enabled')) {
    /**
     * Checks if like is enabled on blog lists
     *
     * @return bool
     */
    function deploy_mikado_is_blog_like_enabled() {
        return deploy_mikado_options()->getOptionValue('enable_blog_like') == 'yes';
    }
}