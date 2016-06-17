(function($) {
    'use strict';

    $(document).ready(function () {
        mkdfInitQuantityButtons();
        mkdfInitSelect2();
        mkdfMiniCartButtons();
        mkdfpriceSlideButton();
    });

    function mkdfInitQuantityButtons() {

        $('.mkdf-quantity-minus, .mkdf-quantity-plus').click(function(e) {
            e.stopPropagation();

            var button = $(this),
                inputField = button.siblings('.mkdf-quantity-input'),
                step = parseFloat(inputField.attr('step')),
                max = parseFloat(inputField.attr('max')),
                minus = false,
                inputValue = parseFloat(inputField.val()),
                newInputValue;

            if (button.hasClass('mkdf-quantity-minus')) {
                minus = true;
            }

            if (minus) {
                newInputValue = inputValue - step;
                if (newInputValue >= 1) {
                    inputField.val(newInputValue);
                } else {
                    inputField.val(1);
                }
            } else {
                newInputValue = inputValue + step;
                if ( max === undefined ) {
                    inputField.val(newInputValue);
                } else {
                    if ( newInputValue >= max ) {
                        inputField.val(max);
                    } else {
                        inputField.val(newInputValue);
                    }
                }
            }

        });

    }

    function mkdfInitSelect2() {

        if ($('.woocommerce-ordering .orderby').length ||  $('#calc_shipping_country').length ) {

            $('.woocommerce-ordering .orderby').select2({
                minimumResultsForSearch: Infinity
            });

            $('#calc_shipping_country').select2();

        }

    }

    function mkdfMiniCartButtons() {
        var buttons = $('.widget_shopping_cart .buttons a');

        if(buttons.length) {
            buttons.addClass('mkdf-btn mkdf-btn-small mkdf-btn-outline');
        }
    }

    function mkdfpriceSlideButton() {
        var button = $('.price_slider_amount .button');

        if(button.length) {
            button.addClass('mkdf-btn mkdf-btn-medium mkdf-btn-solid');
        }
    }


})(jQuery);