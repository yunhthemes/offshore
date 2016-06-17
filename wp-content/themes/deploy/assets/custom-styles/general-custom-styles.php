<?php
if(!function_exists('deploy_mikado_design_styles')) {
    /**
     * Generates general custom styles
     */
    function deploy_mikado_design_styles() {

        $preload_background_styles = array();

        if(deploy_mikado_options()->getOptionValue('preload_pattern_image') !== ""){
            $preload_background_styles['background-image'] = 'url('.deploy_mikado_options()->getOptionValue('preload_pattern_image').') !important';
        }else{
            $preload_background_styles['background-image'] = 'url('.esc_url(MIKADO_ASSETS_ROOT."/img/preload_pattern.png").') !important';
        }

        echo deploy_mikado_dynamic_css('.mkdf-preload-background', $preload_background_styles);

		if (deploy_mikado_options()->getOptionValue('google_fonts')){
			$font_family = deploy_mikado_options()->getOptionValue('google_fonts');
			if(deploy_mikado_is_font_option_valid($font_family)) {
				echo deploy_mikado_dynamic_css('body', array('font-family' => deploy_mikado_get_font_option_val($font_family)));
			}
		}

        if(deploy_mikado_options()->getOptionValue('first_color') !== '') {
            $color_selector = array(
                'h1 a:hover',
                'h2 a:hover',
                'h3 a:hover',
                'h4 a:hover',
                'h5 a:hover',
                'h6 a:hover',
                'a',
                'p a',
                '.mkdf-comment-holder .mkdf-comment-text .comment-reply-link:hover',
                '.mkdf-comment-holder .mkdf-comment-text .comment-edit-link:hover',
                '.mkdf-pagination li.active span',
                '.mkdf-pagination li a:hover',
                '.mkdf-prev-next-pagination a:hover',
                '.mejs-controls .mejs-button button:hover',
                'aside.mkdf-sidebar .widget.widget_nav_menu .current-menu-item > a',
                'aside.mkdf-sidebar .mkdf-latest-posts-widget .mkdf-blog-list-holder .mkdf-item-info-section span',
                'aside.mkdf-sidebar .widget.widget_recent_entries ul li a:hover',
                'aside.mkdf-sidebar .widget.widget_recent_comments ul li a:hover',
                'aside.mkdf-sidebar .widget.widget_archive ul li a:hover',
                'aside.mkdf-sidebar .widget.widget_categories ul li a:hover',
                'aside.mkdf-sidebar .widget.widget_meta ul li a:hover',
                'aside.mkdf-sidebar .widget.widget_tag_cloud ul li a:hover',
                'aside.mkdf-sidebar .widget.widget_pages ul li a:hover',
                'aside.mkdf-sidebar .widget_nav_menu ul li a:hover',
                '.mkdf-load-more-btn:hover, .mkdf-load-more-btn.mkdf-load-more-btn-active',
                '.mkdf-load-more-light .mkdf-load-more-btn:hover',
                '.mkdf-load-more-btn.mkdf-load-more-btn-active',
                '.mkdf-like.liked i',
                '.mkdf-main-menu ul li a .mkdf-menu-featured-icon',
                '.mkdf-main-menu ul li:hover a',
                '.mkdf-main-menu ul li.mkdf-active-item a',
                '.mkdf-light-header .mkdf-page-header > div:not(.mkdf-sticky-header) .mkdf-main-menu > ul > li:hover > a',
                '.mkdf-light-header.mkdf-header-style-on-scroll .mkdf-page-header .mkdf-main-menu > ul > li:hover > a',
                '.mkdf-dark-header .mkdf-page-header > div:not(.mkdf-sticky-header) .mkdf-main-menu > ul > li:hover > a',
                '.mkdf-dark-header.mkdf-header-style-on-scroll .mkdf-page-header .mkdf-main-menu > ul > li:hover > a',
                '.mkdf-drop-down .wide .second .inner ul li.sub .flexslider ul li a:hover',
                '.mkdf-drop-down .wide .second ul li .flexslider ul li a:hover',
                '.mkdf-drop-down .wide .second .inner ul li.sub .flexslider.widget_flexslider .menu_recent_post_text a:hover',
                '.mkdf-mobile-header .mkdf-mobile-nav a:hover',
                '.mkdf-mobile-header .mkdf-mobile-nav h4:hover',
                '.mkdf-mobile-header .mkdf-mobile-menu-opener a:hover',
                '.mkdf-page-header .mkdf-sticky-header .mkdf-main-menu > ul > li > a:hover',
                'body:not(.mkdf-menu-item-first-level-bg-color) .mkdf-page-header .mkdf-sticky-header .mkdf-main-menu > ul > li > a:hover',
                '.mkdf-page-header .mkdf-sticky-header .mkdf-side-menu-button-opener:hover',
                '.mkdf-page-header .mkdf-sticky-header .mkdf-main-menu > ul > li:hover > a',
                'body:not(.mkdf-menu-item-first-level-bg-color) .mkdf-page-header .mkdf-sticky-header .mkdf-main-menu > ul > li:hover > a',
                'footer .widget li a:hover',
                'footer .widget .mkdf-blog-list-holder.mkdf-image-in-box .mkdf-blog-list-item-inner .mkdf-item-title:hover a',
                'footer .widget.widget_tag_cloud .tagcloud a:hover',
                '.mkdf-title .mkdf-title-holder .mkdf-breadcrumbs .mkdf-current',
                '.mkdf-side-menu-button-opener:hover',
                '.mkdf-portfolio-single-holder .mkdf-portfolio-single-nav .mkdf-portfolio-prev a:hover',
                '.mkdf-portfolio-single-holder .mkdf-portfolio-single-nav .mkdf-portfolio-next a:hover',
                '.mkdf-portfolio-single-holder .mkdf-portfolio-single-nav .mkdf-portfolio-back-btn a:hover',
                '.mkdf-counter-holder .mkdf-counter-icon',
                '.mkdf-icon-shortcode .mkdf-icon-element:hover',
                '.mkdf-counter-holder .mkdf-counter-icon',
                '.mkdf-ordered-list ol > li:hover:before',
                '.mkdf-price-table .mkdf-price-table-inner .mkdf-table-content .mkdf-icon-element',
                '.mkdf-tabs .mkdf-tabs-nav li.ui-state-active a span.mkdf-icon-frame',
                '.mkdf-tabs .mkdf-tabs-nav li.ui-state-hover a span.mkdf-icon-frame',
                '.mkdf-tabs .mkdf-tabs-nav li.ui-state-default a span.mkdf-icon-frame',
                '.mkdf-btn.mkdf-btn-outline',
                '.post-password-form input.mkdf-btn-outline[type="submit"]',
                'input.mkdf-btn-outline.wpcf7-form-control.wpcf7-submit, .woocommerce .mkdf-btn-outline.button',
                '.mkdf-blog-list-holder.mkdf-minimal .mkdf-item-info-section',
                '.mkdf-btn.mkdf-btn-outline',
                '.post-password-form input.mkdf-btn-outline[type="submit"]',
                'input.mkdf-btn-outline.wpcf7-form-control.wpcf7-submit',
                'blockquote',
                '.mkdf-video-button-play .mkdf-video-button-wrapper:hover',
                '.mkdf-dropcaps',
                '.mkdf-portfolio-filter-holder .mkdf-portfolio-filter-holder-inner ul li.active span',
                '.mkdf-portfolio-filter-holder .mkdf-portfolio-filter-holder-inner ul li.current span',
                '.mkdf-portfolio-filter-holder .mkdf-portfolio-filter-holder-inner ul li:hover span',
                '.mkdf-portfolio-list-holder-outer.mkdf-ptf-gallery article .mkdf-item-text-holder .mkdf-item-title > a',
                '.mkdf-portfolio-list-holder-outer.mkdf-ptf-gallery article .mkdf-item-text-holder .mkdf-ptf-category-holder span',
                '.mkdf-portfolio-list-holder-outer.mkdf-ptf-gallery article .mkdf-item-icons-holder a',
                '.mkdf-portfolio-slider-holder .mkdf-portfolio-list-holder.owl-carousel .owl-buttons .mkdf-prev-icon i',
                '.mkdf-portfolio-slider-holder .mkdf-portfolio-list-holder.owl-carousel .owl-buttons .mkdf-next-icon i',
                '.mkdf-iwt .mkdf-icon-shortcode.normal',
                '.mkdf-blog-carousel-boxes .mkdf-social-share-holder.mkdf-dropdown .mkdf-social-share-dropdown-opener:hover',
                '.mkdf-twitter-slider .mkdf-twitter-slider-icon',
                '.mkdf-process-holder .mkdf-digit',
                '.mkdf-blog-carousel-standard .mkdf-blog-standard-item-holder-outer:hover .mkdf-blog-standard-category a',
                '.mkdf-blog-carousel-boxes .mkdf-blog-boxes-category',
                '.mkdf-info-card-slider .mkdf-info-card-front-side .mkdf-info-card-icon-holder',
                '.mkdf-icon-slider-holder .mkdf-icon-slider-nav .mkdf-icon-slider-nav-item:hover',
                '.mkdf-icon-slider-holder .mkdf-icon-slider-nav .mkdf-icon-slider-nav-item.flex-active',
                '.mkdf-icon-slider-holder .mkdf-icon-slider-nav .mkdf-icon-slider-nav-item:hover h6.mkdf-icon-slider-nav-title',
                '.mkdf-icon-slider-holder .mkdf-icon-slider-nav .mkdf-icon-slider-nav-item.flex-active h6.mkdf-icon-slider-nav-title',
                '.mkdf-process-carousel .mkdf-pc-item-holder:hover .mkdf-pc-item-title',
                '.mkdf-process-carousel .mkdf-pc-item-holder.slick-current .mkdf-pc-item-title',
                '.mkdf-tabbed-gallery .mkdf-tg-nav a:hover',
                '.mkdf-tabbed-gallery .mkdf-tg-nav .ui-state-active a',
                '.mkdf-info-box-holder .mkdf-ib-back-holder .mkdf-ib-icon-holder',
                '.mkdf-single-links-pages .mkdf-single-links-pages-inner > span, .mkdf-single-links-pages .mkdf-single-links-pages-inner > a:hover'
            );

            $color_woo_selector = array();
            if(deploy_mikado_is_woocommerce_installed()) {
                $color_woo_selector = array(
                    '.woocommerce .mkdf-btn-outline.button',
                    '.woocommerce-pagination .page-numbers li a:hover',
                    '.woocommerce-pagination .page-numbers li span.current',
                    '.woocommerce-pagination .page-numbers li span:hover',
                    '.woocommerce-pagination .page-numbers li span.current:hover',
                    '.mkdf-woocommerce-page .select2-results .select2-highlighted',
                    '.single-product .mkdf-single-product-summary .price',
                    '.single-product .mkdf-single-product-summary .price ins',
                    '.mkdf-woocommerce-with-sidebar aside.mkdf-sidebar .widget.widget_layered_nav a:hover',
                    '.mkdf-woocommerce-with-sidebar aside.mkdf-sidebar .widget .product-categories a:hover',
                    '.mkdf-shopping-cart-dropdown ul li a:hover',
                    '.mkdf-shopping-cart-dropdown .mkdf-item-info-holder .mkdf-item-left a:hover',
                    '.mkdf-shopping-cart-dropdown .mkdf-item-info-holder .mkdf-item-right .remove:hover',
                    '.mkdf-shopping-cart-dropdown span.mkdf-total span',
                    '.mkdf-shopping-cart-dropdown span.mkdf-quantity',
                    '.woocommerce-cart .woocommerce form:not(.woocommerce-shipping-calculator) .product-name a:hover',
                    '.woocommerce-cart .woocommerce .cart-collaterals .mkdf-shipping-calculator .woocommerce-shipping-calculator > p a:hover',
                );
            }

            $color_selector = array_merge($color_selector,$color_woo_selector);

            $color_important_selector = array(
                'footer .widget .mkdf-icon-list-item:hover p',
                '.mkdf-icon-list-item:hover .mkdf-icon-list-icon-holder-inner .mkdf-icon-list-item-icon-elem',
                '.mkdf-btn.mkdf-btn-solid:not(.mkdf-btn-custom-hover-color):hover',
                '.post-password-form input[type="submit"]:not(.mkdf-btn-custom-hover-color):hover',
                'input.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-hover-color):hover',
                '.mkdf-btn.mkdf-btn-solid:not(.mkdf-btn-custom-hover-color):hover',
                '.post-password-form input[type="submit"]:not(.mkdf-btn-custom-hover-color):hover',
                'input.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-hover-color):hover',
            );

            $color_important_woo_selector = array();
            if(deploy_mikado_is_woocommerce_installed()) {
                $color_important_woo_selector = array(
                    '.woocommerce .button:not(.mkdf-btn-custom-hover-color):hover',
                );
            };

            $color_important_selector = array_merge($color_important_selector,$color_important_woo_selector);

            $background_color_selector = array(
                '.mkdf-comment-holder .mkdf-comment-number h6:after',
                '.mkdf-carousel-navigation .owl-pagination .owl-page.active span',
                '.mejs-controls .mejs-time-rail .mejs-time-current',
                '.mejs-controls .mejs-horizontal-volume-slider .mejs-horizontal-volume-current',
                'aside.mkdf-sidebar .widget .mkdf-widget-title h4:after',
                'aside.mkdf-sidebar .widget.widget_tag_cloud .tagcloud a:hover',
                'aside.mkdf-sidebar .widget.widget_product_tag_cloud .tagcloud a:hover',
                '.mkdf-pulse-loader',
                'footer .widget.widget_tag_cloud .tagcloud a:hover',
                '.mkdf-icon-shortcode.circle',
                '.mkdf-icon-shortcode.square',
                '.countdown-amount:after',
                '.mkdf-progress-bar .mkdf-progress-content-outer .mkdf-progress-content',
                '.mkdf-price-table .mkdf-table-button a:hover',
                '.mkdf-price-table.mkdf-active-pricing-table .mkdf-table-button a',
                '.mkdf-pie-chart-doughnut-holder .mkdf-pie-legend ul li .mkdf-pie-color-holder',
                '.mkdf-pie-chart-pie-holder .mkdf-pie-legend ul li .mkdf-pie-color-holder',
                '.mkdf-btn.mkdf-btn-solid',
                '.post-password-form input[type="submit"]',
                'input.wpcf7-form-control.wpcf7-submit',
                '.mkdf-btn.mkdf-btn-solid',
                '.post-password-form input[type="submit"]',
                'input.wpcf7-form-control.wpcf7-submit',
                '.mkdf-dropcaps.mkdf-square',
                '.mkdf-dropcaps.mkdf-circle',
                '.mkdf-blog-carousel-standard .mkdf-blog-standard-item-holder-outer .mkdf-blog-standard-category a',
                '.mkdf-textslider-container .owl-controls .owl-buttons .owl-prev:hover',
                '.mkdf-textslider-container .owl-controls .owl-buttons .owl-next:hover',
                '.carousel-indicators:not(.thumbnails) .active',
            );

            $background_color_woo_selector = array();
            if(deploy_mikado_is_woocommerce_installed()) {
                $background_color_woo_selector = array(
                    '.woocommerce .button',
                    '.mkdf-woocommerce-page .mkdf-onsale',
                    '.mkdf-woocommerce-page .mkdf-out-of-stock',
                    '.woocommerce .mkdf-onsale',
                    '.woocommerce .mkdf-out-of-stock',
                    '.single-product .upsells.products h2:after',
                    '.single-product .related.products h2:after',
                    '.mkdf-woocommerce-with-sidebar aside.mkdf-sidebar .widget.widget_price_filter .price_slider_wrapper .ui-widget-content'
                );
            }

            $background_color_selector = array_merge($background_color_selector,$background_color_woo_selector);

            $background_color_important_selector = array(
                '.mkdf-btn.mkdf-btn-outline:not(.mkdf-btn-custom-hover-bg):hover',
                '.post-password-form input.mkdf-btn-outline[type="submit"]:not(.mkdf-btn-custom-hover-bg):hover',
                '.mkdf-btn.mkdf-btn-white:not(.mkdf-btn-custom-hover-bg):hover',
                '.post-password-form input.mkdf-btn-white[type="submit"]:not(.mkdf-btn-custom-hover-bg):hover',
                'input.mkdf-btn-white.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-hover-bg):hover',
                '.mkdf-btn.mkdf-btn-outline:not(.mkdf-btn-custom-hover-bg):hover',
                '.post-password-form input.mkdf-btn-outline[type="submit"]:not(.mkdf-btn-custom-hover-bg):hover',
                'input.mkdf-btn-outline.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-hover-bg):hover',
                '.mkdf-btn.mkdf-btn-white:not(.mkdf-btn-custom-hover-bg):hover',
                '.post-password-form input.mkdf-btn-white[type="submit"]:not(.mkdf-btn-custom-hover-bg):hover',
                'input.mkdf-btn-white.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-hover-bg):hover',
            );

            $background_color_woo_important_selector = array();
            if(deploy_mikado_is_woocommerce_installed()) {
                $background_color_woo_important_selector = array(
                    '.woocommerce .mkdf-btn-white.button:not(.mkdf-btn-custom-hover-bg):hover',
                    '.woocommerce .mkdf-btn-outline.button:not(.mkdf-btn-custom-hover-bg):hover',
                );
            }

            $background_color_important_selector = array_merge($background_color_important_selector,$background_color_woo_important_selector);

            $border_color_selector = array(
                '.mkdf-icon-shortcode',
                '.post-password-form input[type="submit"]',
                'input.wpcf7-form-control.wpcf7-submit',
                '.mkdf-accordion-holder .mkdf-title-holder.ui-state-active .mkdf-accordion-mark',
                '.mkdf-accordion-holder .mkdf-title-holder.ui-state-hover .mkdf-accordion-mark',
                '.mkdf-btn.mkdf-btn-solid',
                '.post-password-form input[type="submit"]',
                'input.wpcf7-form-control.wpcf7-submit',
                '.mkdf-portfolio-slider-holder .mkdf-portfolio-list-holder.owl-carousel .owl-buttons .mkdf-prev-icon',
                '.mkdf-portfolio-slider-holder .mkdf-portfolio-list-holder.owl-carousel .owl-buttons .mkdf-next-icon',
                '.carousel-indicators:not(.thumbnails) .active',
            );

            $border_bottom_color_selector = array(
                '.mkdf-title.mkdf-standard-type .mkdf-title-text-separator',
            );

            $border_bottom_color_woo_selector = array();
            if(deploy_mikado_is_woocommerce_installed()) {
                $border_bottom_color_woo_selector = array(
                    '.woocommerce-cart .woocommerce .cart-collaterals .mkdf-shipping-calculator .woocommerce-shipping-calculator > p:after',
                    '.woocommerce-cart .woocommerce .cart-collaterals .mkdf-cart-totals h2:after',
                    '.woocommerce-cart .woocommerce .cross-sells h2:after',
                    '.woocommerce-checkout form.checkout h3:after',
                    '.woocommerce-account .woocommerce h2:after',
                );
            }

            $border_top_color_selector = array(
                '.mkdf-progress-bar .mkdf-progress-number-wrapper.mkdf-floating .mkdf-down-arrow',
                '.mkdf-image-with-text-holder.box .mkdf-content-holder',
            );

            $background_color_hexa = array(
                '.mkdf-portfolio-list-holder-outer.mkdf-ptf-standard article .mkdf-item-image-holder .mkdf-item-image-overlay',
                '.mkdf-portfolio-list-holder-outer.mkdf-ptf-gallery article .mkdf-item-text-overlay-bg',
                '.mkdf-tabbed-gallery .mkdf-tg-gallery .mkdf-tg-image-overlay',
            );

            $border_color_hexa = array(
                '.mkdf-btn.mkdf-btn-outline',
                '.post-password-form input.mkdf-btn-outline[type="submit"]',
                'input.mkdf-btn-outline.wpcf7-form-control.wpcf7-submit',
                '.woocommerce .mkdf-btn-outline.button',
            );

            $border_color_woo_selector = array();
            if(deploy_mikado_is_woocommerce_installed()) {
                $border_color_woo_selector = array(
                    '.woocommerce .button',
                );
            }

            $border_color_selector = array_merge($border_color_selector,$border_color_woo_selector);

            $border_color_important_selector = array(
                '.mkdf-btn.mkdf-btn-solid:not(.mkdf-btn-custom-border-hover):hover',
                '.post-password-form input[type="submit"]:not(.mkdf-btn-custom-border-hover):hover',
                'input.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-border-hover):hover',
                '.mkdf-btn.mkdf-btn-outline:not(.mkdf-btn-custom-border-hover):hover',
                '.post-password-form input.mkdf-btn-outline[type="submit"]:not(.mkdf-btn-custom-border-hover):hover',
                'input.mkdf-btn-outline.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-border-hover):hover',
                '.mkdf-btn.mkdf-btn-white:not(.mkdf-btn-custom-border-hover):hover',
                '.post-password-form input.mkdf-btn-white[type="submit"]:not(.mkdf-btn-custom-border-hover):hover',
                'input.mkdf-btn-white.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-border-hover):hover',
                '.mkdf-btn.mkdf-btn-solid:not(.mkdf-btn-custom-border-hover):hover',
                '.post-password-form input[type="submit"]:not(.mkdf-btn-custom-border-hover):hover',
                'input.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-border-hover):hover',
                '.mkdf-btn.mkdf-btn-outline:not(.mkdf-btn-custom-border-hover):hover',
                '.post-password-form input.mkdf-btn-outline[type="submit"]:not(.mkdf-btn-custom-border-hover):hover',
                'input.mkdf-btn-outline.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-border-hover):hover',
                '.mkdf-btn.mkdf-btn-white:not(.mkdf-btn-custom-border-hover):hover',
                '.post-password-form input.mkdf-btn-white[type="submit"]:not(.mkdf-btn-custom-border-hover):hover',
                'input.mkdf-btn-white.wpcf7-form-control.wpcf7-submit:not(.mkdf-btn-custom-border-hover):hover',
            );

            $border_color_woo_important_selector = array();
            if(deploy_mikado_is_woocommerce_installed()) {
                $border_color_woo_important_selector = array(
                    '.woocommerce .button:not(.mkdf-btn-custom-border-hover):hover',
                    '.woocommerce .mkdf-btn-outline.button:not(.mkdf-btn-custom-border-hover):hover',
                    '.woocommerce .mkdf-btn-white.button:not(.mkdf-btn-custom-border-hover):hover',
                    '.woocommerce .button:not(.mkdf-btn-custom-border-hover):hover',
                    '.woocommerce .mkdf-btn-outline.button:not(.mkdf-btn-custom-border-hover):hover',
                    '.woocommerce .mkdf-btn-white.button:not(.mkdf-btn-custom-border-hover):hover',
                );
            }

            $border_color_important_selector = array_merge($border_color_important_selector,$border_color_woo_important_selector);

            echo deploy_mikado_dynamic_css($color_selector, array('color' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css($color_important_selector, array('color' => deploy_mikado_options()->getOptionValue('first_color').'!important'));
            echo deploy_mikado_dynamic_css($color_important_woo_selector, array('color' => deploy_mikado_options()->getOptionValue('first_color').'!important'));
            echo deploy_mikado_dynamic_css('::selection', array('background' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css('::-moz-selection', array('background' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css($background_color_selector, array('background-color' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css($background_color_important_selector, array('background-color' => deploy_mikado_options()->getOptionValue('first_color').'!important'));
            echo deploy_mikado_dynamic_css($border_color_selector, array('border-color' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css($border_bottom_color_selector, array('border-bottom' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css($border_bottom_color_woo_selector, array('border-bottom' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css($border_top_color_selector, array('border-top' => deploy_mikado_options()->getOptionValue('first_color')));
            echo deploy_mikado_dynamic_css($border_color_important_selector, array('border-color' => deploy_mikado_options()->getOptionValue('first_color').'!important'));
            echo deploy_mikado_dynamic_css($background_color_hexa, array('background-color' => deploy_mikado_options()->getOptionValue('first_color', 0.93)));
            echo deploy_mikado_dynamic_css($border_color_hexa, array('border-color' => deploy_mikado_options()->getOptionValue('first_color', 0.5)));
        }

		if (deploy_mikado_options()->getOptionValue('page_background_color')) {
			$background_color_selector = array(
				'.mkdf-wrapper-inner',
				'.mkdf-content'
			);
			echo deploy_mikado_dynamic_css($background_color_selector, array('background-color' => deploy_mikado_options()->getOptionValue('page_background_color')));
		}

		if (deploy_mikado_options()->getOptionValue('selection_color')) {
			echo deploy_mikado_dynamic_css('::selection', array('background' => deploy_mikado_options()->getOptionValue('selection_color')));
			echo deploy_mikado_dynamic_css('::-moz-selection', array('background' => deploy_mikado_options()->getOptionValue('selection_color')));
		}

		$boxed_background_style = array();
		if (deploy_mikado_options()->getOptionValue('page_background_color_in_box')) {
			$boxed_background_style['background-color'] = deploy_mikado_options()->getOptionValue('page_background_color_in_box');
		}

		if (deploy_mikado_options()->getOptionValue('boxed_background_image')) {
			$boxed_background_style['background-image'] = 'url('.esc_url(deploy_mikado_options()->getOptionValue('boxed_background_image')).')';
			$boxed_background_style['background-position'] = 'center 0px';
			$boxed_background_style['background-repeat'] = 'no-repeat';
		}

		if (deploy_mikado_options()->getOptionValue('boxed_pattern_background_image')) {
			$boxed_background_style['background-image'] = 'url('.esc_url(deploy_mikado_options()->getOptionValue('boxed_pattern_background_image')).')';
			$boxed_background_style['background-position'] = '0px 0px';
			$boxed_background_style['background-repeat'] = 'repeat';
		}

		if (deploy_mikado_options()->getOptionValue('boxed_background_image_attachment')) {
			$boxed_background_style['background-attachment'] = (deploy_mikado_options()->getOptionValue('boxed_background_image_attachment'));
		}

		echo deploy_mikado_dynamic_css('.mkdf-boxed .mkdf-wrapper', $boxed_background_style);
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_design_styles');
}

if(!function_exists('deploy_mikado_content_styles')) {
    /**
     * Generates content custom styles
     */
    function deploy_mikado_content_styles() {

        $content_style = array();
        if (deploy_mikado_options()->getOptionValue('content_top_padding')) {
            $padding_top = (deploy_mikado_options()->getOptionValue('content_top_padding'));
            $content_style['padding-top'] = deploy_mikado_filter_px($padding_top).'px';
        }

        $content_selector = array(
            '.mkdf-content .mkdf-content-inner > .mkdf-full-width > .mkdf-full-width-inner',
        );

        echo deploy_mikado_dynamic_css($content_selector, $content_style);

        $content_style_in_grid = array();
        if (deploy_mikado_options()->getOptionValue('content_top_padding_in_grid')) {
            $padding_top_in_grid = (deploy_mikado_options()->getOptionValue('content_top_padding_in_grid'));
            $content_style_in_grid['padding-top'] = deploy_mikado_filter_px($padding_top_in_grid).'px';

        }

        $content_selector_in_grid = array(
            '.mkdf-content .mkdf-content-inner > .mkdf-container > .mkdf-container-inner',
        );

        echo deploy_mikado_dynamic_css($content_selector_in_grid, $content_style_in_grid);

    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_content_styles');

}

if (!function_exists('deploy_mikado_h1_styles')) {

    function deploy_mikado_h1_styles() {

        $h1_styles = array();

        if( deploy_mikado_options()->getOptionValue('h1_color') !== '') {
            $h1_styles['color'] =  deploy_mikado_options()->getOptionValue('h1_color');
        }
        if( deploy_mikado_options()->getOptionValue('h1_google_fonts') !== '-1') {
            $h1_styles['font-family'] = deploy_mikado_get_formatted_font_family( deploy_mikado_options()->getOptionValue('h1_google_fonts'));
        }
        if( deploy_mikado_options()->getOptionValue('h1_fontsize') !== '') {
            $h1_styles['font-size'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h1_fontsize')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h1_lineheight') !== '') {
            $h1_styles['line-height'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h1_lineheight')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h1_texttransform') !== '') {
            $h1_styles['text-transform'] =  deploy_mikado_options()->getOptionValue('h1_texttransform');
        }
        if( deploy_mikado_options()->getOptionValue('h1_fontstyle') !== '') {
            $h1_styles['font-style'] =  deploy_mikado_options()->getOptionValue('h1_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('h1_fontweight') !== '') {
            $h1_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('h1_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('h1_letterspacing') !== '') {
            $h1_styles['letter-spacing'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h1_letterspacing')).'px';
        }

        $h1_selector = array(
            'h1'
        );

        if (!empty($h1_styles)) {
            echo deploy_mikado_dynamic_css($h1_selector, $h1_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_h1_styles');
}

if (!function_exists('deploy_mikado_h2_styles')) {

    function deploy_mikado_h2_styles() {

        $h2_styles = array();

        if( deploy_mikado_options()->getOptionValue('h2_color') !== '') {
            $h2_styles['color'] =  deploy_mikado_options()->getOptionValue('h2_color');
        }
        if( deploy_mikado_options()->getOptionValue('h2_google_fonts') !== '-1') {
            $h2_styles['font-family'] = deploy_mikado_get_formatted_font_family( deploy_mikado_options()->getOptionValue('h2_google_fonts'));
        }
        if( deploy_mikado_options()->getOptionValue('h2_fontsize') !== '') {
            $h2_styles['font-size'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h2_fontsize')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h2_lineheight') !== '') {
            $h2_styles['line-height'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h2_lineheight')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h2_texttransform') !== '') {
            $h2_styles['text-transform'] =  deploy_mikado_options()->getOptionValue('h2_texttransform');
        }
        if( deploy_mikado_options()->getOptionValue('h2_fontstyle') !== '') {
            $h2_styles['font-style'] =  deploy_mikado_options()->getOptionValue('h2_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('h2_fontweight') !== '') {
            $h2_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('h2_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('h2_letterspacing') !== '') {
            $h2_styles['letter-spacing'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h2_letterspacing')).'px';
        }

        $h2_selector = array(
            'h2'
        );

        if (!empty($h2_styles)) {
            echo deploy_mikado_dynamic_css($h2_selector, $h2_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_h2_styles');
}

if (!function_exists('deploy_mikado_h3_styles')) {

    function deploy_mikado_h3_styles() {

        $h3_styles = array();

        if( deploy_mikado_options()->getOptionValue('h3_color') !== '') {
            $h3_styles['color'] =  deploy_mikado_options()->getOptionValue('h3_color');
        }
        if( deploy_mikado_options()->getOptionValue('h3_google_fonts') !== '-1') {
            $h3_styles['font-family'] = deploy_mikado_get_formatted_font_family( deploy_mikado_options()->getOptionValue('h3_google_fonts'));
        }
        if( deploy_mikado_options()->getOptionValue('h3_fontsize') !== '') {
            $h3_styles['font-size'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h3_fontsize')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h3_lineheight') !== '') {
            $h3_styles['line-height'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h3_lineheight')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h3_texttransform') !== '') {
            $h3_styles['text-transform'] =  deploy_mikado_options()->getOptionValue('h3_texttransform');
        }
        if( deploy_mikado_options()->getOptionValue('h3_fontstyle') !== '') {
            $h3_styles['font-style'] =  deploy_mikado_options()->getOptionValue('h3_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('h3_fontweight') !== '') {
            $h3_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('h3_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('h3_letterspacing') !== '') {
            $h3_styles['letter-spacing'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h3_letterspacing')).'px';
        }

        $h3_selector = array(
            'h3'
        );

        if (!empty($h3_styles)) {
            echo deploy_mikado_dynamic_css($h3_selector, $h3_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_h3_styles');
}

if (!function_exists('deploy_mikado_h4_styles')) {

    function deploy_mikado_h4_styles() {

        $h4_styles = array();

        if( deploy_mikado_options()->getOptionValue('h4_color') !== '') {
            $h4_styles['color'] =  deploy_mikado_options()->getOptionValue('h4_color');
        }
        if( deploy_mikado_options()->getOptionValue('h4_google_fonts') !== '-1') {
            $h4_styles['font-family'] = deploy_mikado_get_formatted_font_family( deploy_mikado_options()->getOptionValue('h4_google_fonts'));
        }
        if( deploy_mikado_options()->getOptionValue('h4_fontsize') !== '') {
            $h4_styles['font-size'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h4_fontsize')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h4_lineheight') !== '') {
            $h4_styles['line-height'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h4_lineheight')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h4_texttransform') !== '') {
            $h4_styles['text-transform'] =  deploy_mikado_options()->getOptionValue('h4_texttransform');
        }
        if( deploy_mikado_options()->getOptionValue('h4_fontstyle') !== '') {
            $h4_styles['font-style'] =  deploy_mikado_options()->getOptionValue('h4_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('h4_fontweight') !== '') {
            $h4_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('h4_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('h4_letterspacing') !== '') {
            $h4_styles['letter-spacing'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h4_letterspacing')).'px';
        }

        $h4_selector = array(
            'h4'
        );

        if (!empty($h4_styles)) {
            echo deploy_mikado_dynamic_css($h4_selector, $h4_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_h4_styles');
}

if (!function_exists('deploy_mikado_h5_styles')) {

    function deploy_mikado_h5_styles() {

        $h5_styles = array();

        if( deploy_mikado_options()->getOptionValue('h5_color') !== '') {
            $h5_styles['color'] =  deploy_mikado_options()->getOptionValue('h5_color');
        }
        if( deploy_mikado_options()->getOptionValue('h5_google_fonts') !== '-1') {
            $h5_styles['font-family'] = deploy_mikado_get_formatted_font_family( deploy_mikado_options()->getOptionValue('h5_google_fonts'));
        }
        if( deploy_mikado_options()->getOptionValue('h5_fontsize') !== '') {
            $h5_styles['font-size'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h5_fontsize')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h5_lineheight') !== '') {
            $h5_styles['line-height'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h5_lineheight')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h5_texttransform') !== '') {
            $h5_styles['text-transform'] =  deploy_mikado_options()->getOptionValue('h5_texttransform');
        }
        if( deploy_mikado_options()->getOptionValue('h5_fontstyle') !== '') {
            $h5_styles['font-style'] =  deploy_mikado_options()->getOptionValue('h5_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('h5_fontweight') !== '') {
            $h5_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('h5_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('h5_letterspacing') !== '') {
            $h5_styles['letter-spacing'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h5_letterspacing')).'px';
        }

        $h5_selector = array(
            'h5'
        );

        if (!empty($h5_styles)) {
            echo deploy_mikado_dynamic_css($h5_selector, $h5_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_h5_styles');
}

if (!function_exists('deploy_mikado_h6_styles')) {

    function deploy_mikado_h6_styles() {

        $h6_styles = array();

        if( deploy_mikado_options()->getOptionValue('h6_color') !== '') {
            $h6_styles['color'] =  deploy_mikado_options()->getOptionValue('h6_color');
        }
        if( deploy_mikado_options()->getOptionValue('h6_google_fonts') !== '-1') {
            $h6_styles['font-family'] = deploy_mikado_get_formatted_font_family( deploy_mikado_options()->getOptionValue('h6_google_fonts'));
        }
        if( deploy_mikado_options()->getOptionValue('h6_fontsize') !== '') {
            $h6_styles['font-size'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h6_fontsize')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h6_lineheight') !== '') {
            $h6_styles['line-height'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h6_lineheight')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('h6_texttransform') !== '') {
            $h6_styles['text-transform'] =  deploy_mikado_options()->getOptionValue('h6_texttransform');
        }
        if( deploy_mikado_options()->getOptionValue('h6_fontstyle') !== '') {
            $h6_styles['font-style'] =  deploy_mikado_options()->getOptionValue('h6_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('h6_fontweight') !== '') {
            $h6_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('h6_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('h6_letterspacing') !== '') {
            $h6_styles['letter-spacing'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('h6_letterspacing')).'px';
        }

        $h6_selector = array(
            'h6'
        );

        if (!empty($h6_styles)) {
            echo deploy_mikado_dynamic_css($h6_selector, $h6_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_h6_styles');
}

if (!function_exists('deploy_mikado_text_styles')) {

    function deploy_mikado_text_styles() {

        $text_styles = array();

        if( deploy_mikado_options()->getOptionValue('text_color') !== '') {
            $text_styles['color'] =  deploy_mikado_options()->getOptionValue('text_color');
        }
        if( deploy_mikado_options()->getOptionValue('text_google_fonts') !== '-1') {
            $text_styles['font-family'] = deploy_mikado_get_formatted_font_family( deploy_mikado_options()->getOptionValue('text_google_fonts'));
        }
        if( deploy_mikado_options()->getOptionValue('text_fontsize') !== '') {
            $text_styles['font-size'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('text_fontsize')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('text_lineheight') !== '') {
            $text_styles['line-height'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('text_lineheight')).'px';
        }
        if( deploy_mikado_options()->getOptionValue('text_texttransform') !== '') {
            $text_styles['text-transform'] =  deploy_mikado_options()->getOptionValue('text_texttransform');
        }
        if( deploy_mikado_options()->getOptionValue('text_fontstyle') !== '') {
            $text_styles['font-style'] =  deploy_mikado_options()->getOptionValue('text_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('text_fontweight') !== '') {
            $text_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('text_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('text_letterspacing') !== '') {
            $text_styles['letter-spacing'] = deploy_mikado_filter_px( deploy_mikado_options()->getOptionValue('text_letterspacing')).'px';
        }

        $text_selector = array(
            'p'
        );

        if (!empty($text_styles)) {
            echo deploy_mikado_dynamic_css($text_selector, $text_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_text_styles');
}

if (!function_exists('deploy_mikado_link_styles')) {

    function deploy_mikado_link_styles() {

        $link_styles = array();

        if( deploy_mikado_options()->getOptionValue('link_color') !== '') {
            $link_styles['color'] =  deploy_mikado_options()->getOptionValue('link_color');
        }
        if( deploy_mikado_options()->getOptionValue('link_fontstyle') !== '') {
            $link_styles['font-style'] =  deploy_mikado_options()->getOptionValue('link_fontstyle');
        }
        if( deploy_mikado_options()->getOptionValue('link_fontweight') !== '') {
            $link_styles['font-weight'] =  deploy_mikado_options()->getOptionValue('link_fontweight');
        }
        if( deploy_mikado_options()->getOptionValue('link_fontdecoration') !== '') {
            $link_styles['text-decoration'] =  deploy_mikado_options()->getOptionValue('link_fontdecoration');
        }

        $link_selector = array(
            'a',
            'p a'
        );

        if (!empty($link_styles)) {
            echo deploy_mikado_dynamic_css($link_selector, $link_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_link_styles');
}

if (!function_exists('deploy_mikado_link_hover_styles')) {

    function deploy_mikado_link_hover_styles() {

        $link_hover_styles = array();

        if( deploy_mikado_options()->getOptionValue('link_hovercolor') !== '') {
            $link_hover_styles['color'] =  deploy_mikado_options()->getOptionValue('link_hovercolor');
        }
        if( deploy_mikado_options()->getOptionValue('link_hover_fontdecoration') !== '') {
            $link_hover_styles['text-decoration'] =  deploy_mikado_options()->getOptionValue('link_hover_fontdecoration');
        }

        $link_hover_selector = array(
            'a:hover',
            'p a:hover'
        );

        if (!empty($link_hover_styles)) {
            echo deploy_mikado_dynamic_css($link_hover_selector, $link_hover_styles);
        }

        $link_heading_hover_styles = array();

        if( deploy_mikado_options()->getOptionValue('link_hovercolor') !== '') {
            $link_heading_hover_styles['color'] =  deploy_mikado_options()->getOptionValue('link_hovercolor');
        }

        $link_heading_hover_selector = array(
            'h1 a:hover',
            'h2 a:hover',
            'h3 a:hover',
            'h4 a:hover',
            'h5 a:hover',
            'h6 a:hover'
        );

        if (!empty($link_heading_hover_styles)) {
            echo deploy_mikado_dynamic_css($link_heading_hover_selector, $link_heading_hover_styles);
        }
    }

    add_action('deploy_mikado_style_dynamic', 'deploy_mikado_link_hover_styles');
}

if (!function_exists('deploy_mikado_smooth_page_transition_styles')) {

	function deploy_mikado_smooth_page_transition_styles() {

		$loader_style = array();

		if(deploy_mikado_options()->getOptionValue('smooth_pt_bgnd_color') !== '') {
			$loader_style['background-color'] = deploy_mikado_options()->getOptionValue('smooth_pt_bgnd_color');
		}

		$loader_selector = array('.mkdf-smooth-transition-loader');

		if (!empty($loader_style)) {
			echo deploy_mikado_dynamic_css($loader_selector, $loader_style);
		}
	}

	add_action('deploy_mikado_style_dynamic', 'deploy_mikado_smooth_page_transition_styles');
}