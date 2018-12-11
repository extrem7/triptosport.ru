function productCounter() {
    var min = 1;
    jQuery('body').on('click', '.input-number-box .input-number-more', function (e) {
        e.preventDefault();
        var input = jQuery(this).parent().find('input');
        var current = parseInt(jQuery(input).val());
        jQuery(input).val(current + 1).trigger("change");
        jQuery('.actions button[name=update_cart]').removeAttr('disabled');
        jQuery(".actions button[name=update_cart]").trigger("click");
    }).on('click', '.input-number-box .input-number-less', function (e) {
        e.preventDefault();
        var input = jQuery(this).parent().find('input');
        var current = parseInt(jQuery(input).val());
        if (current > min) {
            jQuery(input).val(current - 1).trigger("change");
            jQuery('.actions button[name=update_cart]').removeAttr('disabled');
        }
        jQuery(".actions button[name=update_cart]").trigger("click");
    });
}

function delivery() {
    $(document.body).on('update_checkout', function () {
        let checked = $('body').find('#shipping_method_0_local_pickup-2').prop('checked');
        setTimeout(() => {
            if (checked) {
                jQuery('body').find('#billing_company').removeAttr('disabled');
                jQuery('body').find('#billing_address_1').attr('disabled', 'disabled');
            } else {
                jQuery('body').find('#billing_company').attr('disabled', 'disabled');
                jQuery('body').find('#billing_address_1').removeAttr('disabled');
            }
        }, 2000);
    });
}

jQuery(document).ready(function ($) {


    $(function () {
        $('.sub-menu > div').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    });

    $(function ($) {
        var allGarmContent = $('.garm-content');
        var allGarmHeader = $('.garm-header');
        $('.garm-header.open').next().css('display', 'block');
        $('.garm-header').click(function () {
            if ($(this).hasClass('open')) {
                $(this).removeClass('open');
                $(this).next().slideUp("fast");
            }
            else {
                allGarmContent.slideUp("fast");
                allGarmHeader.removeClass('open');
                $(this).addClass('open');
                $(this).next().slideDown("fast");
                return false;
            }
        });
    });

    $('.slider-index').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        dots: true,
        arrows: false,
        autoplay: true,
        autoplaySpeed: 4000,
    });

    $(function () {
        $('.poptickets-box-inf > div').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    });

    $(function () {
        $('.index-double-box-inn').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    });

    $(function () {
        $('.index-preim-box-inn').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    });

    $(function () {
        $('.b-footer-item').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    });


    //$('.input-number').prop("disabled", true);


    $(function () {
        $('.b-cabinet-item').matchHeight({
            byRow: true,
            property: 'height',
            target: null,
            remove: false
        });
    });

    $('.show-shem').click(function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $('.b-tickets-box > .b-tickets-item:first-child').slideUp("slow");
        }
        else {
            $(this).addClass('open');
            $('.b-tickets-box > .b-tickets-item:first-child').slideDown("slow");
            return false;
        }
    });

    $.fn.select2.defaults.set("minimumResultsForSearch", -1);

    $('select').select2();

    $('body').on('updated_checkout', function () {
        $('select').select2();
    });

    $('input[type=tel]').mask('+7 999 999-99-99');

    $('[data-toggle="tooltip"]').tooltip();

    $('.fancy-modal').fancybox({
        padding: 0,
        touch: false
    });

    $('button[name=register]').click(function (e) {
        if (!$('.b-lk-sog')[0].reportValidity()) {
            e.preventDefault();
        } else {
            $('.woocommerce-form-register input[name="subscribe"]').val($('.b-lk-sog input[name=checkbox-subscribe]').prop('checked'));
        }
    });

    $('.subscribe-form button').click(function (e) {
        if (!$(this).closest('form').find('input[type=email]')[0].reportValidity()) {
            e.preventDefault();
        }
    });

    $('.main-form .wpcf7-submit').click(function (e) {
        if (!$(this).closest('.land-form').find('.personal-data')[0].reportValidity()) {
            e.preventDefault();
        }
    });

    $('.modal-wind .f_contact .wpcf7-submit').click(function (e) {
        if (!$(this).closest('form')[0].reportValidity()) {
            e.preventDefault();
        }
    });

    $(window).on('wpcf7:mailsent  ', function (e) {
        $.fancybox.close();
        if ($(e.target).find('form').hasClass('subscribe-form')) {
            $.fancybox.open($('#modal-thanks-subs'));
        } else {
            $.fancybox.open($('#modal-thanks'));
        }
        setTimeout(() => {
            $.fancybox.close();
        }, 5000);
    });


    productCounter();

    delivery();
});

window.onload = function () {
    jQuery('.actions button[name=update_cart]').removeAttr('disabled');
    jQuery(".actions button[name=update_cart]").trigger("click");
};
