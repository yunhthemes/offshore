(function($) {
    "use strict";


    var blog = {};
    mkdf.modules.blog = blog;

    blog.mkdfInitAudioPlayer = mkdfInitAudioPlayer;

    $(document).ready(function() {
        mkdfInitAudioPlayer();
        mkdfInitBlogMasonryLoadMore();
    });

    $(window).load(function() {
        mkdfInitBlogMasonry();
    });

    function mkdfInitAudioPlayer() {

        var players = $('audio.mkdf-blog-audio');

        players.mediaelementplayer({
            audioWidth: '100%'
        });
    }


    function mkdfInitBlogMasonry() {

        if($('.mkdf-blog-holder.mkdf-blog-type-masonry').length) {

            var container = $('.mkdf-blog-holder.mkdf-blog-type-masonry');

            container.isotope({
                itemSelector: 'article',
                resizable: false,
                masonry: {
                    columnWidth: '.mkdf-blog-masonry-grid-sizer',
                    gutter: '.mkdf-blog-masonry-grid-gutter'
                }
            });

            setTimeout(function() {
                container.animate({'opacity':1}, 400);
            }, 200);

            var filters = $('.mkdf-filter-blog-holder');
            $('.mkdf-filter').click(function() {
                var filter = $(this);
                var selector = filter.attr('data-filter');
                filters.find('.mkdf-active').removeClass('mkdf-active');
                filter.addClass('mkdf-active');
                container.isotope({filter: selector});
                return false;
            });
        }
    }

    function mkdfInitBlogMasonryLoadMore() {

        if($('.mkdf-blog-holder.mkdf-blog-type-masonry').length) {

            var container = $('.mkdf-blog-holder.mkdf-blog-type-masonry');

            if(container.hasClass('mkdf-masonry-pagination-infinite-scroll')) {
                container.infinitescroll({
                        navSelector: '.mkdf-blog-infinite-scroll-button',
                        nextSelector: '.mkdf-blog-infinite-scroll-button a',
                        itemSelector: 'article',
                        loading: {
                            finishedMsg: mkdfGlobalVars.vars.mkdfFinishedMessage,
                            msgText: mkdfGlobalVars.vars.mkdfMessage
                        }
                    },
                    function(newElements) {
                        container.append(newElements).isotope('appended', $(newElements));
                        mkdf.modules.blog.mkdfInitAudioPlayer();
                        mkdf.modules.common.mkdfOwlSlider();
                        mkdf.modules.common.mkdfFluidVideo();
                        setTimeout(function() {
                            container.isotope('layout');
                            mkdf.modules.common.mkdfInitSelfHostedVideoPlayer();
                        }, 400);
                    }
                );
            } else if(container.hasClass('mkdf-masonry-pagination-load-more')) {
                var i = 1;
                $('.mkdf-blog-load-more-button a').on('click', function(e) {
                    e.preventDefault();

                    var button = $(this);
                    var spinner = $('.mkdf-load-more-btn-holder .mkdf-pulse-loader-holder');

                    button.addClass('mkdf-load-more-btn-active');
                    spinner.addClass('mkdf-spinner-active');

                    var link = button.attr('href');
                    var content = '.mkdf-masonry-pagination-load-more';
                    var anchor = '.mkdf-blog-load-more-button a';
                    var nextHref = $(anchor).attr('href');
                    $.get(link + '', function(data) {
                        var newContent = $(content, data).wrapInner('').html();
                        //nextHref = $(anchor, data).attr('href');
                        container.append(newContent).isotope('reloadItems').isotope({sortBy: 'original-order'});
                        mkdf.modules.blog.mkdfInitAudioPlayer();
                        mkdf.modules.common.mkdfOwlSlider();
                        mkdf.modules.common.mkdfFluidVideo();
                        setTimeout(function() {
                            $('.mkdf-masonry-pagination-load-more').isotope('layout');
                        }, 400);
                        if(button.parent().data('rel') > i) {
                            button.attr('href', nextHref); // Change the next URL
                            button.removeClass('mkdf-load-more-btn-active');
                            spinner.removeClass('mkdf-spinner-active');
                        } else {
                            button.parent().remove();
                        }
                    });
                    i++;
                });
            }
        }
    }
})(jQuery);