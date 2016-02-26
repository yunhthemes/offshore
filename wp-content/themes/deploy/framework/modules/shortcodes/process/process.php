<?php
namespace Deploy\MikadofModules\Shortcodes\Process;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Button that represents button shortcode
 * @package Deploy\MikadofModules\Shortcodes\Button
 */
class Process implements ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    /**
     * Sets base attribute and registers shortcode with Visual Composer
     */
    public function __construct() {
        $this->base = 'mkdf_process';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base attribute
     * @return string
     */
    public function getBase() {
        return $this->base;
    }

    /**
     * Maps shortcode to Visual Composer
     */

    public function vcMap() {
        vc_map(array(
            'name'                      => 'Process',
            'base'                      => $this->base,
            'category'                  => 'by MIKADO',
            'icon'                      => 'icon-wpb-process extended-custom-icon',
            'allowed_container_element' => 'vc_row',
            'params'                    => array(
                array(
                    'type' => 'dropdown',
                    'heading' => 'Text Alignment',
                    'param_name' => 'position',
                    'value' => array(
                        'Left' => 'left',
                        'Right' => 'right',
                        'Center' => 'center'
                    ),
                    'save_always' => true,
                    'description' => '',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Digit',
                    'param_name'  => 'digit',
                    'admin_label' => true
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Title',
                    'param_name'  => 'title'
                ),
                array(
                    'type'        => 'textfield',
                    'heading'     => 'Subtitle',
                    'param_name'  => 'subtitle'
                ),

                array(
                    'type'        => 'textfield',
                    'heading'     => 'Text',
                    'param_name'  => 'text'
                ),
                )
            )
        );
    }

    /**
     * Renders HTML for button shortcode
     *
     * @param array $atts
     * @param null $content
     *
     * @return string
     */
    public function render($atts, $content = null) {
        $args = array(
            'position'  => 'left',
            'digit'     => '',
            'title'     => '',
            'subtitle'  => '',
            'text'      => ''
        );

        $params = shortcode_atts($args, $atts);

        $html = deploy_mikado_get_shortcode_module_template_part('templates/process-template', 'process', '', $params);

        return $html;

    }
}