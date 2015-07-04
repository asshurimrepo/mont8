(function ($) {

    /* var el = {
     // Preview on the wall
     preview_wall_btn: $(".preview-wall-btn"),
     preview_wall: $("#modal-product"),
     preview_wall_form: $("#modal-product .modal-cart-form"),
     preview_close_btn: $(".modal-close-wrapper"),
     product_image: $(".woocommerce-main-image")

     };*/

    // Preview On the Wall
    var preview_on_wall = {

        init: function () {
            // Show Wall
            el.preview_wall_btn.click(this.show_wall);
            // Hide Wall
            el.preview_close_btn.click(this.hide_wall);
            // Generate Artwork Type

            el.size_input.change(this.clone_main_frame);

            $(".overlay-preloader").hide();

            el.framing_check_input.change(function () {

                var is_checked = $(this).prop('checked');
                preview_on_wall.clone_main_frame();

                preview_on_wall.wallOptionsUdpate();

                if (is_checked) {
                    el.frame_this_div.hide();
                    return;
                }

                el.frame_this_div.show();
            });


            this.clone_artwork_type();


        },

        show_wall: function () {


            preview_on_wall.clone_main_frame();
            preview_on_wall.wallOptionsUdpate();
            el.preview_wall.stop().fadeIn(500);


        },

        hide_wall: function () {
            el.preview_wall.stop().fadeOut(500);

        },

        clone_artwork_type: function () {

            var item = $("li.staging-products-item");
            $(".staging-products").html('');


            $(".artwork-style-div .tm-per-row").each(function () {
                var li = item.clone();

                li.find('label')
                    .html($(this).find('.checkbox_image_label').text())
                    .attr('data-target', '#' + $(this).find('input').prop('id'));

                li.click(preview_on_wall.update_frame);

                $(".staging-products").append(li);
            });
        },

        update_frame: function () {

            preview_on_wall.wallOptionsUdpate();

            $(this).addClass('active').siblings().removeClass('active');
            var target = $(this).find('label').data('target');
            $(target).click();

            if (target == '#tmcp_choice_0_0_1') {
                $(".frame-this-print-btn").click();
            }

            preview_on_wall.clone_main_frame();
        },

        clone_main_frame: function () {
            // Update Frame
            el.preview_wall.find('.modal-body .images').html(el.product_image.clone());


        },


        wallOptionsUdpate: function () {


            setTimeout(function () {

                preview_on_wall.updateOptons(
                    "div.select-image-size[style='display: block;'] select, div.select-image-size-div[style='display: block;'] select",
                    ".select-image-size-modal", 1
                );

                preview_on_wall.updateOptons(
                    "div.frame-style-div[style='display: block;'] select.frame-style",
                    ".frame-style-modal"
                );

                preview_on_wall.updateOptons(
                    "div.mattecolor-div[style='display: block;'] select.mattecolor",
                    ".mattecolor-modal"
                );

                preview_on_wall.updateOptons(
                    "div.frame-color-div[style='display: block;'] select.frame-color",
                    ".frame-color-modal"
                );


            }, 200);

        },


        updateOptons: function (to_clone, container) {
            var current = $(to_clone);

            if (!current) {
                return;
            }





            var cloned = current.clone();

            cloned.val(current.val());

            cloned.change(function () {
                current.val($(this).val());
                current.change();
                preview_on_wall.clone_main_frame();
            });

            $(container).html(cloned);

        }


    };


    $(function () {


        preview_on_wall.init();

    });


})(jQuery);