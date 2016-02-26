<?php
namespace Deploy\MikadofModules\Shortcodes\IconSlider;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class IconSlider implements ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'mkdf_icon_slider';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        vc_map(array(
            'name'                    => 'Icon Slider',
            'base'                    => $this->base,
            'as_parent'               => array('only' => 'mkdf_icon_slider_item'),
            'content_element'         => true,
            'show_settings_on_create' => true,
            'category'                => 'by MIKADO',
            'icon'                    => 'icon-wpb-icon-slider extended-custom-icon',
            'js_view'                 => 'VcColumnView',
            'params'                  => array()
        ));
    }

    public function render($atts, $content = null) {
        $default_atts = array();

        $params = array('content' => $content);

        return deploy_mikado_get_shortcode_module_template_part('templates/icon-slider-holder', 'icon-slider', '', $params);
    }

}