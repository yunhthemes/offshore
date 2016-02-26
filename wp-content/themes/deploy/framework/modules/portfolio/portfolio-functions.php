<?php

if(!function_exists('deploy_mikado_single_portfolio')) {
    function deploy_mikado_single_portfolio() {
        $portfolio_template = deploy_mikado_get_portfolio_single_type();

        $params = array(
            'portfolio_template' => $portfolio_template,
            'fullwidth'          => $portfolio_template == 'full-width-custom',
            'holder_class'       => array(
                $portfolio_template,
                'mkdf-portfolio-single-holder'
            )
        );

        if ($portfolio_template == 'gallery') {
            $params['holder_class'][] = 'mkdf-portfolio-gallery-' . deploy_mikado_options()->getOptionValue('portfolio_single_numb_columns');
        }

        deploy_mikado_get_module_template_part('templates/single/holder', 'portfolio', '', $params);
    }
}

if(!function_exists('deploy_mikado_get_portfolio_single_type')) {
    function deploy_mikado_get_portfolio_single_type() {
        return deploy_mikado_get_meta_field_intersect('portfolio_single_template');
    }
}

if(!function_exists('deploy_mikado_get_portfolio_single_media')) {
    function deploy_mikado_get_portfolio_single_media() {
        $image_ids       = get_post_meta(get_the_ID(), 'mkd_portfolio-image-gallery', true);
        $videos          = get_post_meta(get_the_ID(), 'mkd_portfolio_images', true);
        $portfolio_media = array();

        if($image_ids !== '') {
            $image_ids = explode(',', $image_ids);

            foreach($image_ids as $image_id) {
                $media                = array();
                $media['title']       = get_the_title($image_id);
                $media['type']        = 'image';
                $media['description'] = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                $media['image_src']   = wp_get_attachment_image_src($image_id, 'full');

                $portfolio_media[] = $media;
            }
        }

        if(is_array($videos) && count($videos)) {
            usort($videos, 'deploy_mikado_compare_portfolio_videos');
            foreach($videos as $video) {
                $media = array();

                if(!empty($video['portfoliovideotype'])) {
                    $media['title']       = $video['portfoliotitle'];
                    $media['type']        = $video['portfoliovideotype'];
                    $media['description'] = 'video';
                    $media['video_url']   = deploy_mikado_portfolio_get_video_url($video);

                    if($video['portfoliovideotype'] == 'self') {
                        $media['video_cover'] = !empty($video['portfoliovideoimage']) ? $video['portfoliovideoimage'] : '';
                    }

                    if($video['portfoliovideotype'] !== 'self') {
                        $media['video_id'] = $video['portfoliovideoid'];
                    }
                } elseif(!empty($video['portfolioimgtype'])) {
                    $media['title']     = $video['portfoliotitle'];
                    $media['type']      = $video['portfolioimgtype'];
                    $media['image_src'] = $video['portfolioimg'];
                }

                $portfolio_media[] = $media;
            }
        }

        return $portfolio_media;
    }
}

if(!function_exists('deploy_mikado_portfolio_get_video_url')) {
    function deploy_mikado_portfolio_get_video_url($video) {
        switch($video['portfoliovideotype']) {
            case 'youtube':
                return 'http://www.youtube.com/embed/'.$video['portfoliovideoid'].'?wmode=transparent';
                break;
            case 'vimeo';
                return 'http://player.vimeo.com/video/'.$video['portfoliovideoid'].'?title=0&amp;byline=0&amp;portrait=0';
                break;
            case 'self':
                $return_array = array();
                if(!empty($video['portfoliovideowebm'])) {
                    $return_array['webm'] = $video['portfoliovideowebm'];
                }

                if(!empty($video['portfoliovideomp4'])) {
                    $return_array['mp4'] = $video['portfoliovideomp4'];
                }

                if(!empty($video['portfoliovideoogv'])) {
                    $return_array['ogv'] = $video['portfoliovideoogv'];
                }

                return $return_array;

                break;
        }
    }
}

if(!function_exists('deploy_mikado_portfolio_get_media_html')) {
    function deploy_mikado_portfolio_get_media_html($media) {
        global $wp_filesystem;
        WP_Filesystem();

        $params = array();

        //For adding image overlay in gallery template type
        $params['gallery'] = (deploy_mikado_get_portfolio_single_type() == 'gallery') ? true : false;

        if($media['type'] == 'image') {
            $params['lightbox'] = deploy_mikado_options()->getOptionValue('portfolio_single_lightbox_images') == 'yes';

            $media['image_url'] = is_array($media['image_src']) ? $media['image_src'][0] : $media['image_src'];
            if(empty($media['description'])) {
                $media['description'] = $media['title'];
            }
        }

        if(in_array($media['type'], array('youtube', 'vimeo'))) {
            $params['lightbox'] = deploy_mikado_options()->getOptionValue('portfolio_single_lightbox_videos') == 'yes';

            if($params['lightbox']) {
                switch($media['type']) {
                    case 'vimeo':
                        $url      = 'http://vimeo.com/api/v2/video/'.$media['video_id'].'.php';
                        $response = unserialize($wp_filesystem->get_contents($url));

                        $params['video_title']    = $response[0]['title'];
                        $params['lightbox_thumb'] = $response[0]['thumbnail_large'];
                        break;
                    case 'youtube':
                        $url      = 'http://gdata.youtube.com/feeds/api/videos/'.trim($media['video_id']).'?alt=json';
                        $response = json_decode($wp_filesystem->get_contents($url), true);

                        $params['video_title'] = is_array($response['entry']['title']) ? array_shift($response['entry']['title']) : '';

                        $params['lightbox_thumb'] = 'http://img.youtube.com/vi/'.trim($media['video_id']).'/maxresdefault.jpg';
                        break;
                }
            }
        }

        $params['media'] = $media;

        deploy_mikado_get_module_template_part('templates/single/media/'.$media['type'], 'portfolio', '', $params);
    }
}

if(!function_exists('deploy_mikado_compare_portfolio_videos')) {
    /**
     * Function that compares two portfolio image for sorting
     *
     * @param $a int first image
     * @param $b int second image
     *
     * @return int result of comparison
     */
    function deploy_mikado_compare_portfolio_videos($a, $b) {
        if(isset($a['portfolioimgordernumber']) && isset($b['portfolioimgordernumber'])) {
            if($a['portfolioimgordernumber'] == $b['portfolioimgordernumber']) {
                return 0;
            }

            return ($a['portfolioimgordernumber'] < $b['portfolioimgordernumber']) ? -1 : 1;
        }

        return 0;
    }
}

if(!function_exists('deploy_mikado_compare_portfolio_options')) {
    /**
     * Function that compares two portfolio options for sorting
     *
     * @param $a int first option
     * @param $b int second option
     *
     * @return int result of comparison
     */
    function deploy_mikado_compare_portfolio_options($a, $b) {
        if(isset($a['optionlabelordernumber']) && isset($b['optionlabelordernumber'])) {
            if($a['optionlabelordernumber'] == $b['optionlabelordernumber']) {
                return 0;
            }

            return ($a['optionlabelordernumber'] < $b['optionlabelordernumber']) ? -1 : 1;
        }

        return 0;
    }
}

if(!function_exists('deploy_mikado_portfolio_get_info_part')) {
    function deploy_mikado_portfolio_get_info_part($part) {
        $portfolio_template = deploy_mikado_get_portfolio_single_type();

        deploy_mikado_get_module_template_part('templates/single/parts/'.$part, 'portfolio', $portfolio_template);
    }
}

if(!function_exists('deploy_mikado_set_portfolio_single_info_follow_body_class')) {
    /**
     * Function that adds follow portfolio info class to body if sticky sidebar is enabled on portfolio single small images or small slider
     *
     * @param $classes array of body classes
     *
     * @return array with follow portfolio info class body class added
     */

    function deploy_mikado_set_portfolio_single_info_follow_body_class($classes) {

        if(is_singular('portfolio-item')){
            if(deploy_mikado_options()->getOptionValue('portfolio_single_sticky_sidebar') == 'yes'){
                $classes[] = 'mkdf-follow-portfolio-info';
            }
        }

        return $classes;
    }

    add_filter('body_class', 'deploy_mikado_set_portfolio_single_info_follow_body_class');
}