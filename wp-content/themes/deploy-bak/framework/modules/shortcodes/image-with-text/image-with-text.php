<?php
namespace Deploy\MikadofModules\Shortcodes\ImageWithText;

use Deploy\MikadofModules\Shortcodes\Lib\ShortcodeInterface;

/**
 * Class Button that represents button shortcode
 * @package Deploy\MikadofModules\Shortcodes\Button
 */
class ImageWithText implements ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    /**
     * Sets base attribute and registers shortcode with Visual Composer
     */
    public function __construct() {
        $this->base = 'mkdf_image_with_text';

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
                'name'                      => 'Image With Text',
                'base'                      => $this->base,
                'category'                  => 'by MIKADO',
                'icon'                      => 'icon-wpb-image-with-text extended-custom-icon',
                'allowed_container_element' => 'vc_row',
                'params'                    => array_merge(
                    deploy_mikado_icon_collections()->getVCParamsArray(array(), '', true),
                    array(
                        array(
                            'type' => 'dropdown',
                            'admin_label' => true,
                            'heading' => 'Type',
                            'param_name' => 'image_with_text_type',
                            'value' => array(
                                'Box'      => 'box',
                                'Standard' => 'standard'
                            ),
                            'save_always' => true
                        ),
                        array(
                            'type' => 'attach_image',
                            'heading' => 'Image',
                            'param_name' => 'image'
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => 'Title',
                            'param_name'  => 'title'
                        ),
                        array(
                            'type'        => 'textarea',
                            'heading'     => 'Text',
                            'param_name'  => 'text'
                        ),
                        array(
                            'type'        => 'textfield',
                            'heading'     => 'Link',
                            'param_name'  => 'link',
                            'value'       => '',
                            'admin_label' => true
                        ),
                        array(
                            'type'       => 'textfield',
                            'heading'    => 'Link Text',
                            'param_name' => 'link_text',
                            'dependency' => array('element' => 'link', 'not_empty' => true)
                        ),
                        array(
                            'type'       => 'dropdown',
                            'heading'    => 'Target',
                            'param_name' => 'target',
                            'value'      => array(
                                ''      => '',
                                'Self'  => '_self',
                                'Blank' => '_blank'
                            ),
                            'dependency' => array('element' => 'link', 'not_empty' => true),
                        ),
                    )
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
            'image_with_text_type' => 'box',
            'image'                => '',
            'title'                => '',
            'text'                 => '',
            'link'                 => '',
            'link_text'            => '',
            'target'               => '_self'
        );

        $args = array_merge($args, deploy_mikado_icon_collections()->getShortcodeParams());
        $params = shortcode_atts($args, $atts);

        $iconPackName = deploy_mikado_icon_collections()->getIconCollectionParamNameByKey($params['icon_pack']);
        $params['icon'] = $iconPackName ? $params[$iconPackName] : '';


        $html = deploy_mikado_get_shortcode_module_template_part('templates/' . $params['image_with_text_type'], 'image-with-text', '', $params);

        return $html;

    }

}
