(function($) {
    "use strict";

    var title = {};
    mkdf.modules.title = title;

    title.mkdfParallaxTitle = mkdfParallaxTitle;

    $(document).ready(function() {
        mkdfParallaxTitle();
    });

    $(window).load(function() {


    });

    $(window).resize(function() {

    });

    /*
     **	Title image with parallax effect
     */
    function mkdfParallaxTitle(){
        if($('.mkdf-title.mkdf-has-parallax-background').length > 0 && $('.touch').length === 0){

            var parallaxBackground = $('.mkdf-title.mkdf-has-parallax-background');
            var parallaxBackgroundWithZoomOut = $('.mkdf-title.mkdf-has-parallax-background.mkdf-zoom-out');

            var backgroundSizeWidth = parseInt(parallaxBackground.data('background-width').match(/\d+/));
            var titleHolderHeight = parallaxBackground.data('height');
            var titleRate = (titleHolderHeight / 10000) * 7;
            var titleYPos = -(mkdf.scroll * titleRate);

            //set position of background on doc ready
            parallaxBackground.css({'background-position': 'center '+ (titleYPos+mkdfGlobalVars.vars.mkdfAddForAdminBar) +'px' });
            parallaxBackgroundWithZoomOut.css({'background-size': backgroundSizeWidth-mkdf.scroll + 'px auto'});

            //set position of background on window scroll
            $(window).scroll(function() {
                titleYPos = -(mkdf.scroll * titleRate);
                parallaxBackground.css({'background-position': 'center ' + (titleYPos+mkdfGlobalVars.vars.mkdfAddForAdminBar) + 'px' });
                parallaxBackgroundWithZoomOut.css({'background-size': backgroundSizeWidth-mkdf.scroll + 'px auto'});
            });

        }
    }

})(jQuery);
