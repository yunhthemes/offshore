<?php
namespace Deploy\MikadofModules\Shortcodes\TextSliderItem;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Team
 */
class TextSliderItem implements ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'mkdf_text_slider_item';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base for shortcode
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     * Maps shortcode to Visual Composer. Hooked on vc_before_init
     *
     * @see mkd_core_get_carousel_slider_array_vc()
     */

    public function vcMap() {
        vc_map( array(
            "name" => "Text Slider Item",
            'base' => $this->base,
            "as_parent" => array('only' => 'vc_column_text, vc_separator, vc_empty_space, mkdf_custom_font, mkdf_icon, vc_text_separator'),
            "content_element" => true,
            "category" => 'by MIKADO',
            'as_child' => array('only' => 'mkdf_text_slider_holder'),
            "icon" => "icon-wpb-text-slider-item extended-custom-icon",
            "show_settings_on_create" => false,
            "js_view" => 'VcColumnView',
            "params" => array()
        ));
    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     * @return string
     */
    public function render($atts, $content = null) {
        $params = array();

        $params['content'] = $content;

        $html = deploy_mikado_get_shortcode_module_template_part('templates/text-slider-item-template', 'text-slider', '', $params);

        return $html;

    }


}