<?php
namespace Deploy\MikadofModules\Shortcodes\ShapeSeparator;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

class ShapeSeparator implements ShortcodeInterface {
    private $base;

    public function __construct() {
        $this->base = 'mkdf_shape_separator';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function getBase() {
        return $this->base;
    }

    public function vcMap() {
        vc_map(array(
            'name'                      => 'Shape Separator',
            'base'                      => $this->base,
            'category'                  => 'by MIKADO',
            'icon'                      => 'icon-wpb-shape-separator extended-custom-icon',
            'allowed_container_element' => 'vc_row',
            'params'                    => array(
                array(
                    'type'        => 'dropdown',
                    'heading'     => 'Shape Position',
                    'param_name'  => 'shape_position',
                    'value'       => array(
                        'Left'   => 'left',
                        'Center' => 'center',
                        'Right'  => 'right'
                    ),
                    'admin_label' => true,
                    'save_always' => true
                ),
                array(
                    'type'        => 'dropdown',
                    'heading'     => 'Animate Lines',
                    'param_name'  => 'animate_lines',
                    'value'       => array(
                        'Yes'   => 'yes',
                        'No' => 'no',
                    ),
                    'admin_label' => true,
                    'save_always' => true,
                    'description' => 'Choose whether to animate separator lines when the element enters the view-port.'
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Top Margin (px)',
                    'param_name'  => 'top_margin',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Bottom Margin (px)',
                    'param_name'  => 'bottom_margin',
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => 'Line Color',
                    'param_name'  => 'line_color',
                    'admin_label' => true,
                ),
                array(
                    'type'        => 'colorpicker',
                    'heading'     => 'Shape Color',
                    'param_name'  => 'shape_color',
                    'admin_label' => true,
                )
            )
        ));
    }

    public function render($atts, $content = null) {
        $default_atts = array(
            'shape_position' => '',
            'animate_lines'  => 'yes',
            'top_margin'     => '',
            'bottom_margin'  => '',
            'line_color'     => '',
            'shape_color'    => ''
        );

        $params = shortcode_atts($default_atts, $atts);

        $params['holder_classes'] = $this->getHolderClasses($params);
        $params['holder_styles']  = $this->getHolderStyles($params);
        $params['line_styles']    = $this->getLineStyles($params);
        $params['shape_styles']    = $this->getShapeStyles($params);

        return deploy_mikado_get_shortcode_module_template_part('templates/shape-separator-template', 'shape-separator', '', $params);
    }

    private function getHolderClasses($params) {
        $classes   = array('mkdf-shape-separator');
        $classes[] = 'mkdf-shape-separator-'.$params['shape_position'];

        if ($params['animate_lines'] == 'yes') {
            $classes[] = 'appear';
        }

        return $classes;
    }

    private function getHolderStyles($params) {
        $styles = array();

        if(!empty($params['top_margin'])) {
            $styles[] = 'margin-top: '.deploy_mikado_filter_px($params['top_margin']).'px';
        }

        if(!empty($params['bottom_margin'])) {
            $styles[] = 'margin-bottom: '.deploy_mikado_filter_px($params['bottom_margin']).'px';
        }

        return $styles;
    }

    private function getLineStyles($params) {
        $styles = array();

        if(!empty($params['line_color'])) {
            $styles[] = 'border-color: '.$params['line_color'];
        }

        return $styles;
    }

    private function getShapeStyles($params) {
        $styles = array();

        if(!empty($params['shape_color'])) {
            $styles[] = 'border-color: '.$params['shape_color'];
        }

        return $styles;
    }

}