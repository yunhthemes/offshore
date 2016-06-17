<?php
namespace Deploy\MikadofModules\Shortcodes\IconSlider;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class IconSliderItem implements ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'mkdf_icon_slider_item';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        $iconCollections = deploy_mikado_icon_collections()->iconCollections;
        foreach($iconCollections as $collectionKey => $collection) {
            $iconsArray[] = array(
                'type'        => 'dropdown',
                'class'       => '',
                'heading'     => 'Slide Navigation Icon',
                'param_name'  => 'icon_'.$collection->param,
                'value'       => $collection->getIconsArray(),
                'save_always' => true,
                'dependency'  => Array('element' => 'icon_family', 'value' => array($collectionKey))
            );
        }

        vc_map(array(
            'name'                    => 'Icon Slider Item',
            'base'                    => $this->base,
            'category'                => 'by MIKADO',
            'icon'                    => 'icon-wpb-icon-slider-item extended-custom-icon',
            'as_parent'               => array('except' => 'vc_row'),
            'as_child'                => array('only' => 'mkdf_icon_slider'),
            'is_container'            => true,
            'show_settings_on_create' => true,
            'params'                  => array_merge(
                array(
                    array(
                        'type'        => 'dropdown',
                        'heading'     => 'Icon Pack',
                        'param_name'  => 'icon_family',
                        'value'       => deploy_mikado_icon_collections()->getIconCollectionsVC(),
                        'save_always' => true
                    ),
                ),
                $iconsArray,
                array(
                    array(
                        'type'        => 'attach_image',
                        'admin_label' => true,
                        'heading'     => 'Slide Image',
                        'param_name'  => 'slide_image',
                        'value'       => '',
                        'description' => ('Select image from media library.'),
                    ),
                    array(
                        'type'        => 'dropdown',
                        'heading'     => 'Image Position',
                        'param_name'  => 'image_position',
                        'value'       => array(
                            'Left'  => 'left',
                            'Right' => 'right',
                        ),
                        'save_always' => true,
                        'description' => '',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textfield',
                        'heading'     => 'Slide Title',
                        'param_name'  => 'slide_title',
                        'admin_label' => true
                    ),
                    array(
                        'type'        => 'textarea_html',
                        'holder'      => 'div',
                        'class'       => '',
                        'heading'     => 'Content',
                        'param_name'  => 'content',
                        'value'       => '',
                        'description' => '',
                    )
                )
            )
        ));
    }

    public function render($atts, $content = null) {
        $default_atts = array(
            'image_position' => '',
            'slide_image'    => '',
            'slide_title'    => ''
        );

        $params = shortcode_atts($default_atts, $atts);

        $params['content'] = $content;

        return deploy_mikado_get_shortcode_module_template_part('templates/icon-slider-item', 'icon-slider', '', $params);
    }
}