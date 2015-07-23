/**
 * Responsible for Framing the Artwork
 *
 * @package iBoostme
 * @package iBoostme - 2014.1.10
 */
var el;


(function ($) {

    // Elements
    el = {
        frame_this_div: $(".frame-this-print-div"),
        framing_check_input: $("input.frame-this-print"),
        art_frame: $("#tmcp_choice_0_0_1").parent(),
        art_frame_input: $("#tmcp_choice_0_0_1"),
        art_frame_radio: $("input[name=tmcp_radio_0]:radio"),
        product_image: $(".woocommerce-main-image"),
        images: $(".images"),
        product_cont: $(".product.type-product"),

        options_cont: $(".tm-extra-product-options"),

        // add to wishlist
        add_to_wishlist: $("a.add_to_wishlist"),
        add_to_wishlist_btn: $("a.add_to_wishlist_btn"),

        // Framing inputs
        size_input: $("select.select-image-size"),
        frame_style_input: $("select.frame-style"),
        mattecolor_input: $("select.mattecolor"),
        frame_color_input: $("select.frame-color"),

        // Preview on the wall
        preview_wall_btn: $(".preview-wall-btn"),
        preview_wall: $("#modal-product"),
        preview_wall_form: $("#modal-product .modal-cart-form"),
        preview_close_btn: $(".modal-close-wrapper")
    };


    // $(".modal-body").append($(".images"));


    // Framign Options DTO
    var framing_options = {
        sizes: [
            {
                ref: 'A1 - 84.1 x 59 cm_0',
                class: 'a1'
            },

            {
                ref: 'A2 - 59.4 x 42 cm_1',
                class: 'a2'
            },

            {
                ref: 'A3 - 42 x 29.7 cm_2',
                class: 'a3'

            },

            {
                ref: 'A4 - 29.7 x 21 cm_3',
                class: 'a4'
            },

            {
                ref: 'A5 - 21 x 14.8 cm_4',
                class: 'a5'
            },
            {
                ref: '60cm x 60cm_0',
                class: 'a1'
            },

            {
                ref: '50cm x 50cm_1',
                class: 'a2'
            },

            {
                ref: '40cm x 40cm_2',
                class: 'a3'

            },

            {
                ref: '30cm x 30cm_3',
                class: 'a4'
            },
        ],


        frame_styles: [
            {
                ref: 'Flat Frame_0',
                class: 'flat-frame'
            },

            {
                ref: 'Box Frame_1',
                class: 'box-frame'
            },

            {
                ref: 'Floater Frame_2',
                class: 'floater-frame'
            }
        ],


        mattecolors: [
            {
                ref: 'No-Matt_0',
                class: 'no-matt'
            },

            {
                ref: 'Matt - Black_1',
                class: 'matt-black'
            },

            {
                ref: 'Matt - White_2',
                class: 'matt-white'
            },

            {
                ref: 'Matt - Off White_3',
                class: 'matt-offwhite'
            }
        ],

        frame_colors: [
            {
                ref: 'Brown_0',
                class: 'frame-brown'
            },

            {
                ref: 'White_1',
                class: 'frame-white'
            },

            {
                ref: 'Black_2',
                class: 'frame-black'
            }
        ],

        artwork_type: [
            {
                ref: 'Framed Art_0',
                class: ''
            },

            {
                ref: 'Fine Art Print_1',
                class: 'art-print'
            },

            {
                ref: 'Photo Print_2',
                class: 'photo-print'
            },

            {
                ref: 'Canvas_3',
                class: 'canvas-print'
            },

            {
                ref: 'Poster_4',
                class: 'poster-print'
            }
        ],

        final_frame_class: ''
    };


    // Framing Methods
    var framing = {

        init: function () {

            // Add Frame button on the fly
            $(".frame-this-print-div").append('<button class="btn-block frame-this-print-btn" type="button">Frame this Print</button>');

            el.framing_btn = $(".frame-this-print-btn");
            el.framing_btn.click(framing.enable_framing);

            // Hide Art frame by default
            el.art_frame.hide();

            //Hide add to wishlist acter
            $(".yith-wcwl-add-to-wishlist").hide();

            // Add class image circle to the avatar
            $("img.avatar").addClass('img-circle');

            $('[data-toggle="tooltip"]').tooltip();

            // $(".product-description").addClass('collapsed');

            $(document).ready(function () {

                // Add readmore to product description
                $('.product-description').readmore({
                    lessLink: '<a href="#" class="readmore"><b>READ LESS <i class="fa fa-angle-double-left"></i><b></a>',
                    moreLink: '<a href="#" class="readmore"><b>READ MORE <i class="fa fa-angle-double-right"></i></b></a>',
                    embedCSS: false,
                    collapsedHeight: 85,
                    heightMargin: 5
                }).removeClass('collapsed');

                //addtowishlist event
                el.add_to_wishlist_btn.click(framing.add_to_wishlist);

                el.framing_check_input.change();
                $("input[name=tmcp_radio_0]:radio:checked").change();

                el.size_input.change();

            });

            // Event Declaration
            el.framing_check_input.change(framing.when_frame_is_print_enabled);
            el.art_frame_radio.change(framing.when_frame_art_is_change);

            // Frame option events
            el.size_input.change(framing.update_frame);
            el.frame_style_input.change(framing.update_frame);
            el.mattecolor_input.change(framing.update_frame);
            el.frame_color_input.change(framing.update_frame);

            // Default unapply frame
            framing.unapply();

        },


        add_to_wishlist: function () {

            el.add_to_wishlist.click();

        },


        when_frame_is_print_enabled: function () {

            el.frame_this_div.show();

            el.size_input.change();

            if (!$(this).prop('checked')) {
                return;
            }


            el.size_input.change();
            el.frame_this_div.hide();
            //el.art_frame_input.click();
            framing.apply();
            product_bullets.update(el.frame_style_input.val());


            var this_art_frame = $('input.artwork-style:checked').val();

            //Hide optons section
            $(".frame-style option").show();

            if (this_art_frame == 'Fine Art Print_1' || this_art_frame == 'Photo Print_2') {
                $(".frame-style option:nth-child(3)").hide();
                el.frame_style_input.val('Flat Frame_0');
            }

            if (this_art_frame == 'Canvas_3') {
                $(".frame-style option:nth-child(1), .frame-style option:nth-child(2)").hide();
                el.frame_style_input.val('Floater Frame_2');
            }

            el.size_input.change();


        },

        when_frame_art_is_change: function () {

            product_bullets.update($(this).val());

            el.framing_btn.show();

            //Hide if poster
            if ($(this).val() == 'Poster_4') {
                el.framing_btn.hide();
            }

            // Get artwork class
            var artwork_class = framing.get_frame_opt_class($(this), framing_options.artwork_type);

            el.product_image.removeClass(el.product_image.attr('data-class'))
                .addClass(artwork_class);

            el.product_image.attr('data-class', artwork_class);


            applyZoomEffect($);


            if (!el.art_frame_input.prop('checked') && el.framing_check_input.prop('checked')) {

                framing.enable_framing();
                framing.unapply();

                return;
            }


        },

        enable_framing: function () {
            el.framing_check_input.click();
        },

        apply: function () {
            $('.artwork-thumbnail').show();
            el.product_image.addClass('framed-art');
            el.product_image.removeClass('canvas-style');

        },

        unapply: function () {
            $('.artwork-thumbnail').hide();
            el.product_image.removeClass('framed-art');
            el.product_image.addClass('canvas-style');
        },

        update_frame: function () {



            //Apply Zoom Effect
            applyZoomEffect($);


            // update multiple instances of select image size input
            if ($(this).hasClass('select-image-size')) {

                el.size_input = $(this);

                /*$("select.select-image-size").each(function () {
                 $(this).val(el.size_input.val());
                 });*/

            }

            // remove previous class
            el.product_image.removeClass(framing_options.final_frame_class);
            //el.options_cont.removeClass(framing_options.final_frame_class);

            // get size class
            var size_class = framing.get_frame_opt_class(el.size_input, framing_options.sizes);
            // get frame style class
            var frame_style_class = framing.get_frame_opt_class(el.frame_style_input, framing_options.frame_styles);
            // get mattecolor class
            var mattecolor_class = framing.get_frame_opt_class(el.mattecolor_input, framing_options.mattecolors);
            // get frame color class
            var frame_color_class = framing.get_frame_opt_class(el.frame_color_input, framing_options.frame_colors);
            // get artwork type class

            // set frame class
            framing_options.final_frame_class = size_class + ' ' + frame_style_class + ' ' + mattecolor_class + ' ' + frame_color_class;

            el.product_image.addClass(framing_options.final_frame_class);
            //el.options_cont.addClass(framing_options.final_frame_class);

            if (el.framing_check_input.prop('checked'))
                product_bullets.update(el.frame_style_input.val());

            artwork.update();

            //preview_on_wall.clone_main_frame();

        },


        // Get Framing Class
        get_frame_opt_class: function (input_obj, options) {

            var ref = input_obj.val();

            for (i in options) {
                var v = options[i].ref;
                var this_class = options[i].class;
                if (v == ref) return this_class;
            }

        }

    };


    // Initialized
    framing.init();

    // update wishlist count
    $(document).ajaxComplete(function (event, request) {
        var response = request.responseJSON;
        if (response.user_wishlists) {
            if (response.result == "true") {
                var current_count = $(".favorite-count").html();
                $(".favorite-count").html(parseInt(current_count) + 1);
            }
        }
    });


    // Product Bullet Points
    var product_bullets = {

        init: function () {

            this.el.lists_div.html(this.el.lists);
            this.update('default');

        },

        el: {
            lists: $("<ul class='product-options-list'>"),
            lists_div: $(".product-bullet-points")
        },

        data: [

            {
                ref: 'Fine Art Print_1',

                options: [
                    'Printed on 300 gsm heavyweight Cotton paper',
                    'Giclée printing using Epson archival inks',
                    '0.5 cm additional border to assist you in framing'
                ]

            },

            {
                ref: 'Photo Print_2',

                options: [
                    'Printed on 250 gsm heavyweight Photo paper',
                    'Giclée printing using Epson archival inks',
                    '0.5 cm additional border to assist you in framing'
                ]
            },

            {
                ref: 'Canvas_3',

                options: [
                    'Printed on 380 gsm heavyweight Canvas Paper ',
                    'Poly-Cotton blend for best color combinations ',
                    'Hand stretched over 4cm solid wood bar',
                    'Giclée printing using Epson archival inks',
                    'Made ready to hang, easy to handle and lightweight'
                ]
            },

            {
                ref: 'Poster_4',

                options: [
                    'Printed on 250 gsm photo paper',
                    'Semi glossy paper finish',
                    'Giclée printing using Epson archival inks',
                    '0.5 cm additional border to assist you in framing'
                ]
            },


            {
                ref: 'Flat Frame_0',

                options: [
                    'Gallery quality, custom made solid polystyrene frame',
                    'Flat frame style 4cm wide and 1.7cm deep',
                    'Crystal clear and shatterproof 3mm acrylic',
                    'Optional 1” or 2” Matt with color finishing',
                    'Made ready to hang, easy to handle and lightweight'
                ]
            },

            {
                ref: 'Box Frame_1',

                options: [
                    'Gallery quality, custom made solid polystyrene frame',
                    'Box frame style 2.5cm wide and 4cm deep',
                    'Crystal clear and shatterproof 3mm acrylic',
                    'Optional 1” or 2” Matt with color finishing',
                    'Made ready to hang, easy to handle and lightweight',
                ]
            },

            {
                ref: 'Floater Frame_2',

                options: [
                    'Gallery quality, custom made solid polystyrene frame',
                    'Floater frame style 1.3cm wide and 4cm deep',
                    //'Crystal clear and shatterproof 3mm acrylic',
                    '0.5 cm spacing between frame and stretched canvas',
                    'Made ready to hang, easy to handle and lightweight',
                ]
            }


        ],

        update: function (ref) {

            var options = [];

            // get specific data
            for (i in this.data) {
                if (ref == 'default') {
                    options = this.data[0].options;
                    break;
                }

                if (ref == this.data[i].ref) {
                    options = this.data[i].options;
                }
            }


            // Update Lists
            this.el.lists.empty();

            for (i in options) {
                this.el.lists.append('<li>' + options[i]);
            }


        }


    };
    // Initialized product_bullets
    product_bullets.init();


    /*
     *
     * Artwork Thumbnail Behavior
     *
     */

    var artwork = {
        init: function () {
            $(document).ready(function () {

                $(".images").append($(".artwork-thumbnail"));
                $(".images>.image-grey>a").after($(".preview-wall-container"));

                var main_image_url = $(".woocommerce-main-image").prop('href');

                $(".mo-artwork").prop('href', main_image_url);

            });

        },


        update: function () {
            var dir = $('.mo-frame').data('dir'),
                frame_style_class = framing.get_frame_opt_class(el.frame_style_input, framing_options.frame_styles),
                frame_color_class = framing.get_frame_opt_class(el.frame_color_input, framing_options.frame_colors),
                thumb = dir + frame_style_class + frame_color_class + '.jpg',
                big = dir + frame_style_class + frame_color_class + '-big.jpg';

            // alert(thumb);
            $('.mo-frame').prop('href', big)
                .find('img')
                .prop('src', thumb);
        }
    };

    artwork.init();


    // Social Share
    var social_share = {
        init: function () {
            $("#share-button").click(this.open_sharer);

            $('.share-overlay').click(this.close_sharer);

            $(".button-wrap>button").click(this.share);
        },

        share: function () {
            window.open($(this).data('request-path'));
            $('.share-overlay').removeClass('hide');
        },

        open_sharer: function () {
            $('.share-overlay').removeClass('hide');
        },

        close_sharer: function () {
            $('.share-overlay').addClass('hide');
        }
    }

    social_share.init();


    /*// Preview On the Wall
     var preview_on_wall = {
     init: function () {
     // Show Wall
     el.preview_wall_btn.click(this.show_wall);
     // Hide Wall
     el.preview_close_btn.click(this.hide_wall);
     // Generate Artwork Type

     this.clone_artwork_type();

     this.populate_size_input();

     },

     show_wall: function () {

     preview_on_wall.clone_main_frame();
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

     populate_size_input: function () {
     var options = $("select.base-image-size > option").clone();
     $('select.wall.select-image-size').append(options).change(framing.update_frame);
     }
     };

     preview_on_wall.init();*/


})(jQuery);


function applyZoomEffect($) {
    $('.image-grey .woocommerce-main-image>img').addimagezoom({ // single image zoom
        zoomrange: [2, 5],
        magnifiersize: [$(".entry-summary").width(), $('.image-grey').height()],
        magnifierpos: 'right',
        cursorshade: true,
        zIndex: 99,
        largeimage: $('.woocommerce-page div.product div.images img').prop('src')//<-- No comma after last option!
    });
}


jQuery(document).ready(function ($) {

    var ptype = getParameterByName('ptype');

    setTimeout(function () {

        $("div.select-image-size:not([style='display: none;'])").find("select").change();
        $("div.select-image-size-div:not([style='display: none;'])").find("select").change();

        switch (ptype) {
            case 'framed-art':
                $("input.frame-this-print").click();

                break;
            case 'photography':
                $("#tmcp_choice_0_2_3").click();
                break;
            case 'stretched-canvases':
                $("#tmcp_choice_0_3_4").click();
                break;
            case 'posters':
                if (window.is_square !== undefined) {
                    return;
                }
                $("#tmcp_choice_0_4_5").click();
                break;
        }
    }, 1000);


    setTimeout(function () {
        $(".overlay-preloader").hide();
    }, 500);


    /*Sync sizes*/
    //art-print
    sync_sizes_inputs("select.art-print-sizes");
    sync_sizes_inputs("select.art-sq-print-sizes");

    //photo-print
    sync_sizes_inputs("select.photo-print-sizes");
    sync_sizes_inputs("select.photo-sq-print-sizes");

    //canvas
    sync_sizes_inputs("select.canvas-print-sizes");
    sync_sizes_inputs("select.canvas-sq-print-sizes");

});


function sync_sizes_inputs(ref) {

    var $ = jQuery;

    $(ref).change(function () {
        var v = $(this).val();
        $(ref).each(function () {
            $(this).val(v);
        });
    });
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


/*hide sizes by minimum*/
jQuery(document).ready(function ($) {
    var w = window.image_data.width,
        h = window.image_data.height;

    var is_square = w == h;

    //If landscape
    if (w > h) {
        w = window.image_data.height;
        h = window.image_data.width;
    }

    var a5 = w >= 874 && h >= 1240,
        a4 = w >= 1240 && h >= 1754,
        a3 = w >= 1754 && h >= 2480,
        a2 = w >= 2480 && h >= 3508,
        a1 = w >= 3508 && h >= 4967,
        small = w >= 1772,
        medium = w >= 2362,
        large = w >= 2953,
        xlarge = w >= 3543;

    //console.log($("select.select-image-size "));


    if (is_square) {
        if (!small) {
            $("select.select-image-size>option:nth-child(4)").hide();
        }

        if (!medium) {
            $("select.select-image-size>option:nth-child(3)").hide();
        }

        if (!large) {
            $("select.select-image-size>option:nth-child(2)").hide();
        }

        if (!xlarge) {
            $("select.select-image-size>option:nth-child(1)").hide();
        }

        return;
    }


    if (!a5) {
        $("select.select-image-size>option:nth-child(5)").hide();
    }

    if (!a4) {
        $("select.select-image-size>option:nth-child(4)").hide();
    }

    if (!a3) {
        $("select.select-image-size>option:nth-child(3)").hide();
        $(".artwork-style-ul>li:nth-child(4)").hide();
    }

    if (!a2) {
        $("select.select-image-size>option:nth-child(2)").hide();
        $(".artwork-style-ul>li:nth-child(5)").hide();
    }

    if (!a1) {
        $("select.select-image-size>option:nth-child(1)").hide();
    }


});





