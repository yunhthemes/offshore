<?php
namespace Deploy\MikadofModules\Shortcodes\TwitterSlider;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class TwitterSlider implements ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'mkdf_twitter_slider';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     *
     */
    public function vcMap() {
        vc_map(array(
            'name'                      => 'Twitter slider',
            'base'                      => $this->base,
            'icon'                      => 'icon-wpb-video extended-custom-icon',
            'category'                  => 'by MIKADO',
            'allowed_container_element' => 'vc_row',
            'params'                    => array(
                array(
                    'type'        => 'textfield',
                    'heading'     => 'User ID',
                    'param_name'  => 'user_id',
                    'value'       => '',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Number of tweets',
                    'param_name'  => 'count',
                    'value'       => '',
                    'description' => 'Default Number is 4',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => 'Tweets Color',
                    'param_name'  => 'tweets_color',
                    'value'       => '',
                    'description' => '',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'textfield',
                    'class'       => '',
                    'heading'     => 'Tweet Cache Time',
                    'param_name'  => 'transient_time',
                    'value'       => '',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => 'Auto rotate slides',
                    'param_name'  => 'auto_rotate_slides',
                    'value'       => array(
                        '3'       => '3',
                        '5'       => '5',
                        '10'      => '10',
                        '15'      => '15',
                        'Disable' => '0'
                    ),
                    'save_always' => true,
                    'admin_label' => true
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Animation speed',
                    'param_name'  => 'animation_speed',
                    'value'       => '',
                    'description' => esc_html__('Speed of slide animation in miliseconds', 'deploy'),
                    'admin_label' => true
                )
            )
        ));
    }


    /**
     * @param array $atts
     * @param null $content
     *
     * @return string
     */
    public function render($atts, $content = null) {
        $params = array(
            'user_id'            => '',
            'count'              => '4',
            'tweets_color'       => '',
            'transient_time'     => '0',
            'animation_speed'    => '',
            'auto_rotate_slides' => ''
        );

        $params = shortcode_atts($params, $atts);

        $html = '';

        $twitter_api = \MikadofTwitterApi::getInstance();

        if($twitter_api->hasUserConnected()) {
            $response = $twitter_api->fetchTweets($params['user_id'], $params['count'], array(
                'transient_time' => $params['transient_time'],
                'transient_id'   => 'mkd_twitter_slider_cache'
            ));

            $params['response']     = $response;
            $params['twitter_api']  = $twitter_api;
            $params['tweet_styles'] = $this->getTweetStyles($params);
            $params['slider_data']  = $this->getSliderData($params);

            $html .= deploy_mikado_get_shortcode_module_template_part('templates/twitter-slider', 'twitter-slider', '', $params);
        } else {
            $html .= esc_html__('It seams that you haven\'t connected with your Twitter account', 'deploy');
        }

        return $html;
    }

    /**
     * @param $params
     *
     * @return array
     */
    private function getTweetStyles($params) {
        $styles = array();

        if(!empty($params['tweets_color'])) {
            $styles[] = 'color: '.$params['tweets_color'];
        }

        return $styles;
    }

    /**
     * @param $params
     * @return array
     */
    private function getSliderData($params) {
        $data = array();

        if(!empty($params['animation_speed'])) {
            $data['data-animation-speed'] = $params['animation_speed'];
        }

        if(!empty($params['auto_rotate_slides'])) {
            $data['data-auto-rotate-slides'] = $params['auto_rotate_slides'];
        }

        return $data;
    }
}