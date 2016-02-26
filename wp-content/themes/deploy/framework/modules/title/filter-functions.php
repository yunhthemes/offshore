<?php

if(!function_exists('deploy_mikado_title_classes')) {
    /**
     * Function that adds classes to title div.
     * All other functions are tied to it with add_filter function
     * @param array $classes array of classes
     */
    function deploy_mikado_title_classes($classes = array()) {
        $classes = array();
        $classes = apply_filters('deploy_mikado_title_classes', $classes);

        if(is_array($classes) && count($classes)) {
            echo implode(' ', $classes);
        }
    }
}

if(!function_exists('deploy_mikado_title_type_class')) {
    /**
     * Function that adds class on title based on title type option
     * @param $classes original array of classes
     * @return array changed array of classes
     */
    function deploy_mikado_title_type_class($classes) {
        $id = deploy_mikado_get_page_id();

        if(get_post_meta($id, "mkdf_title_area_type_meta", true) !== ""){
            $title_type = get_post_meta($id, "mkdf_title_area_type_meta", true);
        }else {
            $title_type = deploy_mikado_options()->getOptionValue('title_area_type');
        }

        $classes[] = 'mkdf-'.$title_type.'-type';

        return $classes;

    }

    add_filter('deploy_mikado_title_classes', 'deploy_mikado_title_type_class');
}

if(!function_exists('deploy_mikado_title_background_image_classes')) {
	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_title_background_image_classes($classes) {
        //init variables
        $id                         = deploy_mikado_get_page_id();
        $is_img_responsive 		    = '';
        $is_image_parallax		    = '';
        $is_image_parallax_array    = array('yes', 'yes_zoom');
        $show_title_img			    = true;
        $title_img				    = '';

        //is responsive image is set for current page?
        if(get_post_meta($id, "mkdf_title_area_background_image_responsive_meta", true) != "") {
            $is_img_responsive = get_post_meta($id, "mkdf_title_area_background_image_responsive_meta", true);
        } else {
            //take value from theme options
            $is_img_responsive = deploy_mikado_options()->getOptionValue('title_area_background_image_responsive');
        }

        //is title image chosen for current page?
        if(get_post_meta($id, "mkdf_title_area_background_image_meta", true) != ""){
            $title_img = get_post_meta($id, "mkdf_title_area_background_image_meta", true);
        }else{
            //take image that is set in theme options
            $title_img = deploy_mikado_options()->getOptionValue('title_area_background_image');
        }

        //is image set to be fixed for current page?
        if(get_post_meta($id, "mkdf_title_area_background_image_parallax_meta", true) != ""){
            $is_image_parallax = get_post_meta($id, "mkdf_title_area_background_image_parallax_meta", true);
        }else{
            //take setting from theme options
            $is_image_parallax = deploy_mikado_options()->getOptionValue('title_area_background_image_parallax');
        }

        //is title image hidden for current page?
        if(get_post_meta($id, "mkdf_hide_background_image_meta", true) == "yes") {
            $show_title_img = false;
        }

        //is title image set and visible?
        if($title_img !== '' && $show_title_img == true) {
            //is image not responsive and parallax title is set?
            $classes[] = 'mkdf-preload-background';
            $classes[] = 'mkdf-has-background';

            if($is_img_responsive == 'no' && in_array($is_image_parallax, $is_image_parallax_array)) {
                $classes[] = 'mkdf-has-parallax-background';

                if($is_image_parallax == 'yes_zoom') {
                    $classes[] = 'mkdf-zoom-out';
                }
            }

            //is image not responsive
            elseif($is_img_responsive == 'yes'){
                $classes[] = 'mkdf-has-responsive-background';
            }
        }

        return $classes;
    }

    add_filter('deploy_mikado_title_classes', 'deploy_mikado_title_background_image_classes');
}

if(!function_exists('deploy_mikado_title_content_alignment_class')) {
    /**
     * Function that adds class on title based on title content alignmnt option
     * Could be left, centered or right
     * @param $classes original array of classes
     * @return array changed array of classes
     */
    function deploy_mikado_title_content_alignment_class($classes) {

        //init variables
        $id                      = deploy_mikado_get_page_id();
        $title_content_alignment = 'left';

        if(get_post_meta($id, "mkdf_title_area_content_alignment_meta", true) != "") {
            $title_content_alignment = get_post_meta($id, "mkdf_title_area_content_alignment_meta", true);

        } else {
            $title_content_alignment = deploy_mikado_options()->getOptionValue('title_area_content_alignment');
        }

        $classes[] = 'mkdf-content-'.$title_content_alignment.'-alignment';

        return $classes;

    }

    add_filter('deploy_mikado_title_classes', 'deploy_mikado_title_content_alignment_class');
}

if(!function_exists('deploy_mikado_title_animation_class')) {
    /**
     * Function that adds class on title based on title animation option
     * @param $classes original array of classes
     * @return array changed array of classes
     */
    function deploy_mikado_title_animation_class($classes) {

        //init variables
        $id                      = deploy_mikado_get_page_id();
        $title_animation = 'no';

        if(get_post_meta($id, "mkdf_title_area_animation_meta", true) !== "") {
            $title_animation = get_post_meta($id, "mkdf_title_area_animation_meta", true);

        } else {
            $title_animation = deploy_mikado_options()->getOptionValue('title_area_animation');
        }

        $classes[] = 'mkdf-animation-'.$title_animation;

        return $classes;

    }

    add_filter('deploy_mikado_title_classes', 'deploy_mikado_title_animation_class');
}

if(!function_exists('deploy_mikado_title_background_image_div_classes')) {
	/**
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_title_background_image_div_classes($classes) {

        //init variables
        $id                         = deploy_mikado_get_page_id();
        $is_img_responsive 		    = '';
        $show_title_img			    = true;
        $title_img				    = '';

        //is responsive image is set for current page?
        if(get_post_meta($id, "mkdf_title_area_background_image_responsive_meta", true) != "") {
            $is_img_responsive = get_post_meta($id, "mkdf_title_area_background_image_responsive_meta", true);
        } else {
            //take value from theme options
            $is_img_responsive = deploy_mikado_options()->getOptionValue('title_area_background_image_responsive');
        }

        //is title image chosen for current page?
        if(get_post_meta($id, "mkdf_title_area_background_image_meta", true) != ""){
            $title_img = get_post_meta($id, "mkdf_title_area_background_image_meta", true);
        }else{
            //take image that is set in theme options
            $title_img = deploy_mikado_options()->getOptionValue('title_area_background_image');
        }

        //is title image hidden for current page?
        if(get_post_meta($id, "mkdf_hide_background_image_meta", true) == "yes") {
            $show_title_img = false;
        }

        //is title image set, visible and responsive?
        if($title_img !== '' && $show_title_img == true) {

            //is image responsive?
            if($is_img_responsive == 'yes') {
                $classes[] = 'mkdf-title-image-responsive';
            }
            //is image not responsive?
            elseif($is_img_responsive == 'no') {
                $classes[] = 'mkdf-title-image-not-responsive';
            }
        }

        return $classes;
    }

    add_filter('deploy_mikado_title_classes', 'deploy_mikado_title_background_image_div_classes');
}

if(!function_exists('mkdf_title_area_disable_shadow_class')) {
	/**
	 * Adds class to title area holder for disabling box shadow
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function mkdf_title_area_disable_shadow_class($classes) {
        $id = deploy_mikado_get_page_id();

        $disable_shadow = get_post_meta($id, 'mkdf_disable_title_box_shadow_meta', true);

        if($disable_shadow === 'yes') {
            $classes[] = 'mkdf-title-area-no-shadow';
        }

        return $classes;
    }

    add_filter('deploy_mikado_title_classes', 'mkdf_title_area_disable_shadow_class');
}

if(!function_exists('deploy_mikado_subtitle_type_class')) {
	/**
	 * Adds class to title element for subtitle type
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	function deploy_mikado_subtitle_type_class($classes) {
        $id = deploy_mikado_get_page_id();

	    $subtitle_type = get_post_meta($id, 'mkdf_title_area_subtitle_type_meta', true);

	    if(!empty($subtitle_type)) {
		    $classes[] = 'mkdf-subtitle-'.$subtitle_type;
	    }

	    return $classes;
    }

	add_filter('deploy_mikado_title_classes', 'deploy_mikado_subtitle_type_class');
}