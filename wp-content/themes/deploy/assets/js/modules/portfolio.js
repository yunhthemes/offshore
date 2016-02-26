(function($) {
    'use strict';

    mkdf.modules.portfolio = {};

	mkdf.modules.portfolio.portfolioGalleryDirectionHover = mkdfPortfolioGalleryDirectionHover;

    $(window).load(function() {
        mkdfPortfolioSingleFollow().init();
        mkdfPortfolioGalleryDirectionHover();
    });

    var mkdfPortfolioSingleFollow = function() {

        var info = $('.mkdf-follow-portfolio-info .small-images.mkdf-portfolio-single-holder .mkdf-portfolio-info-holder, ' +
            '.mkdf-follow-portfolio-info .small-slider.mkdf-portfolio-single-holder .mkdf-portfolio-info-holder');

        if(info.length) {
            var infoHolder = info.parent(),
                infoHolderOffset = infoHolder.offset().top,
                infoHolderHeight = infoHolder.height(),
                mediaHolder = $('.mkdf-portfolio-media'),
                mediaHolderHeight = mediaHolder.height(),
                header = $('.header-appear, .mkdf-fixed-wrapper'),
                headerHeight = (header.length) ? header.height() : 0;
        }

        var infoHolderPosition = function() {

            if(info.length) {

                if(mediaHolderHeight > infoHolderHeight) {
                    if(mkdf.scroll > infoHolderOffset) {
                        info.animate({
                            marginTop: (mkdf.scroll - (infoHolderOffset) + mkdfGlobalVars.vars.mkdfAddForAdminBar + headerHeight + 20) //20 px is for styling, spacing between header and info holder
                        });
                    }
                }

            }
        };

        var recalculateInfoHolderPosition = function() {

            if(info.length) {
                if(mediaHolderHeight > infoHolderHeight) {
                    if(mkdf.scroll > infoHolderOffset) {

                        if(mkdf.scroll + headerHeight + mkdfGlobalVars.vars.mkdfAddForAdminBar + infoHolderHeight + 20 < infoHolderOffset + mediaHolderHeight) {    //20 px is for styling, spacing between header and info holder

                            //Calculate header height if header appears
                            if($('.header-appear, .mkdf-fixed-wrapper').length) {
                                headerHeight = $('.header-appear, .mkdf-fixed-wrapper').height();
                            }
                            info.stop().animate({
                                marginTop: (mkdf.scroll - (infoHolderOffset) + mkdfGlobalVars.vars.mkdfAddForAdminBar + headerHeight + 20) //20 px is for styling, spacing between header and info holder
                            });
                            //Reset header height
                            headerHeight = 0;
                        }
                        else {
                            info.stop().animate({
                                marginTop: mediaHolderHeight - infoHolderHeight
                            });
                        }
                    } else {
                        info.stop().animate({
                            marginTop: 0
                        });
                    }
                }
            }
        };

        return {

            init: function() {

                infoHolderPosition();
                $(window).scroll(function() {
                    recalculateInfoHolderPosition();
                });

            }

        };

    };

    function mkdfPortfolioGalleryDirectionHover() {
        var portfolioGalleries = $('.mkdf-portfolio-list-holder-outer.mkdf-ptf-gallery'),
			portfolioItems;

		if(portfolioGalleries.length) {
			portfolioGalleries.each(function() {
				portfolioItems = $(this).find('.mkdf-portfolio-item');

				if(portfolioItems.length) {
					portfolioItems.each(function() {
						$(this).hoverdir({
							element: '.mkdf-item-text-overlay'
						});
					});
				}
			});
		}
    }

})(jQuery);