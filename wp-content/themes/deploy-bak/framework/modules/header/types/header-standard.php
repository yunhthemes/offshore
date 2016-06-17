<?php
namespace Deploy\MikadofModules\Header\Types;

use Deploy\MikadofModules\Header\Lib\HeaderType;

/**
 * Class that represents Header Standard layout and option
 *
 * Class HeaderStandard
 */
class HeaderStandard extends HeaderType {
    protected $heightOfTransparency;
    protected $heightOfCompleteTransparency;
    protected $headerHeight;
    protected $mobileHeaderHeight;

    /**
     * Sets slug property which is the same as value of option in DB
     */
    public function __construct() {
        $this->slug = 'header-standard';

        if(!is_admin()) {

            $menuAreaHeight       = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('menu_area_height_header_standard'));
            $this->menuAreaHeight = $menuAreaHeight !== '' ? $menuAreaHeight : 95;

            $mobileHeaderHeight       = deploy_mikado_filter_px(deploy_mikado_options()->getOptionValue('mobile_header_height'));
            $this->mobileHeaderHeight = $mobileHeaderHeight !== '' ? $mobileHeaderHeight : 100;

            add_action('wp', array($this, 'setHeaderHeightProps'));

            add_filter('deploy_mikado_js_global_variables', array($this, 'getGlobalJSVariables'));
            add_filter('deploy_mikado_per_page_js_vars', array($this, 'getPerPageJSVariables'));

        }
    }

    /**
     * Loads template file for this header type
     *
     * @param array $parameters associative array of variables that needs to passed to template
     */
    public function loadTemplate($parameters = array()) {

        $parameters['menu_area_in_grid'] = deploy_mikado_options()->getOptionValue('menu_area_in_grid_header_standard') == 'yes' ? true : false;
        $parameters['menu_area_styles']  = $this->getMenuAreaStyles();

        $parameters = apply_filters('deploy_mikado_header_standard_parameters', $parameters);

        deploy_mikado_get_module_template_part('templates/types/'.$this->slug, $this->moduleName, '', $parameters);
    }

    /**
     * Returns total height of mobile header
     *
     * @return int|string
     */
    public function calculateMobileHeaderHeight() {
        $mobileHeaderHeight = $this->mobileHeaderHeight;

        return $mobileHeaderHeight;
    }

    /**
     * Sets header height properties after WP object is set up
     */
    public function setHeaderHeightProps() {
        $this->heightOfTransparency         = $this->calculateHeightOfTransparency();
        $this->heightOfCompleteTransparency = $this->calculateHeightOfCompleteTransparency();
        $this->headerHeight                 = $this->calculateHeaderHeight();
        $this->mobileHeaderHeight           = $this->calculateMobileHeaderHeight();
    }

    /**
     * Returns total height of transparent parts of header
     *
     * @return int
     */
    public function calculateHeightOfTransparency() {
        $id                 = deploy_mikado_get_page_id();
        $transparencyHeight = 0;

        if(get_post_meta($id, 'mkdf_menu_area_background_color_header_standard_meta', true) !== '') {
            $menuAreaTransparent = get_post_meta($id, 'mkdf_menu_area_background_color_header_standard_meta', true) !== '' &&
                                   get_post_meta($id, 'mkdf_menu_area_background_transparency_header_standard_meta', true) !== '1';
        } elseif(deploy_mikado_options()->getOptionValue('menu_area_background_color_header_standard') === '') {
            $menuAreaTransparent = deploy_mikado_options()->getOptionValue('menu_area_grid_background_color_header_standard') !== '' &&
                                   deploy_mikado_options()->getOptionValue('menu_area_grid_background_transparency_header_standard') !== '1';
        } else {
            $menuAreaTransparent = deploy_mikado_options()->getOptionValue('menu_area_background_color_header_standard') !== '' &&
                                   deploy_mikado_options()->getOptionValue('menu_area_background_transparency_header_standard') !== '1';
        }

	    $contentBehindHeader = get_post_meta($id, 'mkdf_page_content_behind_header_meta', true) === 'yes';
	    if($contentBehindHeader) {
		    $menuAreaTransparent = true;
	    }

        if($menuAreaTransparent) {
            $transparencyHeight = $this->menuAreaHeight;

            if(($contentBehindHeader && deploy_mikado_is_top_bar_enabled())
                || deploy_mikado_is_top_bar_enabled() && deploy_mikado_is_top_bar_transparent()) {
                $transparencyHeight += deploy_mikado_get_top_bar_height();
            }
        }

        return $transparencyHeight;
    }

    /**
     * Returns height of completely transparent header parts
     *
     * @return int
     */
    public function calculateHeightOfCompleteTransparency() {
        $id                 = deploy_mikado_get_page_id();
        $transparencyHeight = 0;

        if(get_post_meta($id, 'mkdf_menu_area_background_color_header_standard_meta', true) !== '') {
            $menuAreaTransparent = get_post_meta($id, 'mkdf_menu_area_background_color_header_standard_meta', true) !== '' &&
                                   get_post_meta($id, 'mkdf_menu_area_background_transparency_header_standard_meta', true) === '0';
        } elseif(deploy_mikado_options()->getOptionValue('mkdf_menu_area_background_color_header_standard') == '') {
            $menuAreaTransparent = deploy_mikado_options()->getOptionValue('mkdf_menu_area_grid_background_color_header_standard') !== '' &&
                                   deploy_mikado_options()->getOptionValue('mkdf_menu_area_grid_background_transparency_header_standard') === '0';
        } else {
            $menuAreaTransparent = deploy_mikado_options()->getOptionValue('mkdf_menu_area_background_color_header_standard') !== '' &&
                                   deploy_mikado_options()->getOptionValue('mkdf_menu_area_background_transparency_header_standard') === '0';
        }

        if($menuAreaTransparent) {
            $transparencyHeight = $this->menuAreaHeight;

            if(deploy_mikado_is_top_bar_enabled() && deploy_mikado_is_top_bar_completely_transparent()) {
                $transparencyHeight += deploy_mikado_get_top_bar_height();
            }
        }

        return $transparencyHeight;
    }


    /**
     * Returns total height of header
     *
     * @return int|string
     */
    public function calculateHeaderHeight() {
        $headerHeight = $this->menuAreaHeight;
        if(deploy_mikado_is_top_bar_enabled()) {
            $headerHeight += deploy_mikado_get_top_bar_height();
        }

        return $headerHeight;
    }

    /**
     * Returns global js variables of header
     *
     * @param $globalVariables
     *
     * @return int|string
     */
    public function getGlobalJSVariables($globalVariables) {
        $globalVariables['mkdfLogoAreaHeight'] = 0;
        $globalVariables['mkdfMenuAreaHeight'] = $this->headerHeight;
        $globalVariables['mkdfMobileHeaderHeight'] = $this->mobileHeaderHeight;

        return $globalVariables;
    }

    /**
     * Returns per page js variables of header
     *
     * @param $perPageVars
     *
     * @return int|string
     */
    public function getPerPageJSVariables($perPageVars) {
        //calculate transparency height only if header has no sticky behaviour
        if(!in_array(deploy_mikado_options()->getOptionValue('header_behaviour'), array(
            'sticky-header-on-scroll-up',
            'sticky-header-on-scroll-down-up'
        ))
        ) {
            $perPageVars['mkdfHeaderTransparencyHeight'] = $this->headerHeight - (deploy_mikado_get_top_bar_height() + $this->heightOfCompleteTransparency);
        } else {
            $perPageVars['mkdfHeaderTransparencyHeight'] = 0;
        }

        return $perPageVars;
    }

    /**
     * Returns array of styles that will be applied to main menu area
     */
    private function getMenuAreaStyles() {
        $id     = deploy_mikado_get_page_id();
        $styles = array();

        if($id !== -1) {
            $bg_color = get_post_meta($id, 'mkdf_menu_area_background_color_header_standard_meta', true);
            $bg_color_transparency = get_post_meta($id, 'mkdf_menu_area_background_transparency_header_standard_meta', true);

            if($bg_color !== '') {
                $bg_color_transparency = $bg_color_transparency !== '' ? $bg_color_transparency : 1;
                $styles[] = 'background-color: '.deploy_mikado_rgba_color($bg_color, $bg_color_transparency);
            }

            $enable_border = get_post_meta($id, 'mkdf_menu_area_bottom_border_enable_header_standard_meta', true) == 'yes';

            if($enable_border) {
                $border_color = get_post_meta($id, 'mkdf_menu_area_bottom_border_color_meta', true);

                if($border_color !== '') {
                    $styles[] = 'border-bottom-color: '.$border_color;
                }
            }
        }

        return $styles;
    }
}