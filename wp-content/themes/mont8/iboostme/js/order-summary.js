jQuery(document).ready(function ($) {

    $(".woocommerce form select").addClass('form-control');

    var required_inputs = {
        billing_country: $("#billing_country").val(),

    };

    var prev_num = 1;

    $("[data-step]").click(function () {
        var step_num = $(this).data('step');
        var target = "#step" + step_num;
        var title = $(".order-title");
        var titles = ['Order Summary', 'Shippping Information', 'Checkout'];


        $("html, body").animate({scrollTop: 0}, {duration: 500, queue: false});

        if (step_num == 3) {

            if(prev_num == 1){
                return;
            }

            $("form.checkout").validate({
                rules: {
                    billing_first_name: {required: true},
                    billing_last_name: {required: true},
                    billing_address_1: {required: true},
                    billing_city: {required: true},
                    billing_email: {required: true, email: true},
                    billing_phone: {required: true},
                    shipping_first_name: {required: true},
                    billing_postcode: {required: true}
                }
            });


            //$("[name=woocommerce_checkout_place_order]").click();
            if (!$("form.checkout").valid())
            return;
        }

        $('[data-step=' + step_num + ']').parent().addClass('active').siblings().removeClass('active');

        $(".step-item").removeClass('active');
        $(target).addClass('active');
        title.html(titles[step_num-1]);

        prev_num = step_num;

    });

});