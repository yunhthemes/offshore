<?php
namespace Deploy\MikadofModules\Shortcodes\TextSliderHolder;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Team
 */
class TextSliderHolder implements ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'mkdf_text_slider_holder';

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
            "name" => "Text Slider Holder",
            'base' => $this->base,
            'icon' => 'icon-wpb-text-slider-holder extended-custom-icon',
            'category' => 'by MIKADO',
            'as_parent' => array('only' => 'mkdf_text_slider_item'),
            'content_element' => true,
            'js_view' => 'VcColumnView',
            'params' => array(
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "class" => "",
                    "heading" => "Show Navigation",
                    "param_name" => "show_navigation",
                    "value" => array(
                        "Yes" => 'yes',
                        "No" => 'no'
                    ),
                    "save_always" => true
                ),
                array(
                    "type" => "dropdown",
                    "holder" => "div",
                    "class" => "",
                    "heading" => "Navigation Position",
                    "param_name" => "navigation_position",
                    "value" => array(
                        "Left" => 'nav-left',
                        "Center" => 'nav-center',
                        "Right" => 'nav-right'
                    ),
                    "save_always" => true,
                    "dependency" => Array('element' => "show_navigation", 'value' => array('yes')),
                )
            ),
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
        $args = array(
            'show_navigation'	  => 'yes',
            'navigation_position' => 'nav-left'
        );

        $params       = shortcode_atts($args, $atts);

        extract($params);
        $params['text_slider_classes'] = $this->getTextSliderClasses($params);
        $params['text_slider_navigation'] = $this->getTextSliderPosition($params);

        $params['content'] = $content;

        $html = deploy_mikado_get_shortcode_module_template_part('templates/text-slider-holder-template', 'text-slider', '', $params);

        return $html;

    }

    private function getTextSliderClasses($params) {

        $classes = array('mkdf-textslider-container');

        if($params['show_navigation'] == 'no') {
            $classes[] = "no-navigation";
        }
        return $classes;
    }

    private function getTextSliderPosition($params) {

        $position_classes = array('mkdf-text-slider-container-inner');

        if($params['navigation_position'] == 'nav-center') {
            $position_classes[] = "mkdf-navigation-center";
        }

        elseif($params['navigation_position'] == 'nav-right') {
            $position_classes[] = "mkdf-navigation-right";
        }

        else {
            $position_classes[] = "mkdf-navigation-left";
        }

        return $position_classes;
    }


}