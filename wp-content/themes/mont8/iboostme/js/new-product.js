/**
 * Callback function for the 'click' event of the 'Set Footer Image'
 * anchor in its meta box.
 *
 * Displays the media uploader for selecting an image.
 *
 * @since 0.1.0
 */
function renderMediaUploader($) {

    var file_frame, image_data;

    window.is_printshop = $("[name=is_printshop]").attr('content');

    var multiple = is_printshop ? false : true;

    /**
     * If an instance of file_frame already exists, then we can open it
     * rather than creating a new instance.
     */
    if (undefined !== file_frame) {

        file_frame.open();
        return;

    }

    /**
     * If we're this far, then an instance does not exist, so we need to
     * create our own.
     *
     * Here, use the wp.media library to define the settings of the Media
     * Uploader. We're opting to use the 'post' frame which is a template
     * defined in WordPress core and are initializing the file frame
     * with the 'insert' state.
     *
     * We're also not allowing the user to select more than one image.
     */
    file_frame = wp.media.frames.file_frame = wp.media({
        // Set the title of the modal.
        title: 'Upload your art (Press shift/ctrl/cmd to select multiple artwork)',
        button: {
            text: 'Select Artwork',
        },
        multiple: multiple
    });

    /**
     * Setup an event handler for what to do when an image has been
     * selected.
     *
     * Since we're using the 'view' state when initializing
     * the file_frame, we need to make sure that the handler is attached
     * to the insert event.
     */
    file_frame.on('select', function () {

        selection = file_frame.state().get('selection');

        var source = $("#entry-template").html();
        var template = Handlebars.compile(source);


        $("#selection").empty();
        $('#new-product-form').empty();


        selection.map(function (attachment) {

            attachment = attachment.toJSON();

            var html = template(attachment);
            var thumb = $("<img>");
            var thumb_link = $("<a>");


            thumb.prop('src', attachment.sizes.thumbnail.url)
                .prop('class', 'img-thumbnail');

            thumb_link.attr('data-show', "form.art-" + attachment.id).append(thumb);

            thumb_link.click(function () {

                var to_show = $(this).data('show');

                $(this).addClass('active').siblings().removeClass('active');

                $(to_show).show()
                    .siblings()
                    .hide();


            });

            $("#selection>a:first-child").addClass('active');


            $("#selection").append(thumb_link);
            $('#new-product-form').append(html);

            filter_products(attachment.id, attachment.width, attachment.height);

            //Pricing Tags Event
            pricingTagsInit($("form.art-" + attachment.id));


            console.log(attachment);


        });

        $(".chosen").chosen();

        setTimeout(function () {
            $("#selection>a:first-child").click();

        }, 700);


        // Show Product Pricing
        $(".change-product-pricing-btn").click(function () {

            $(".product-pricing").fadeToggle();

        });

        addFormEvent($);

        // Hide unwanted table
        $("table tbody>tr").addClass('hide');
        $("table tbody>tr input").attr('disabled', true);


    });

    // Now display the actual file_frame
    file_frame.open();

}

var selection;

(function ($) {

    $(function () {
        $('#add-new-artwork').on('click', function (evt) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            // Display the media uploader
            renderMediaUploader($);


        });

        var error_message = null, new_error_message;

        setInterval(function () {
            error_message = $(".upload-error-message").html();

            var link = $(".upload-guideline-link").prop('href');

            if (error_message) {
                new_error_message = error_message.replace('click here for more information about uploading guidelines', '<a target="_blank" style="color: #21759b !important" href="' + link + '">click here</a> for more information about uploading guidelines');
                $(".upload-error-message").html(new_error_message);
            }

        }, 1000);


    });

})(jQuery);


function addFormEvent($) {
    // Submit form via Ajax
    $("form").on("submit", function (e) {
        e.preventDefault();

        var form = $(this);

        form.addClass('is-updating');
        /*
         console.log($(this).serialize());

         return;*/

        $.post($(this).prop('action'), $(this).serialize(), 'json').success(function (data) {

            // alert(1);
            $(".errors").empty().html('');

            var succes_div = $("<div>").prop('class', 'dokan-alert dokan-alert-success');

            if (is_printshop) {
                window.location.href = '?page_id=' + data;

                succes_div.html('Waiting for the process to be completed.')
                form.html(succes_div);

                return;
            }

            var edit_link = $("<a>")
                .prop('target', '_blank')
                .prop('href', data);

            edit_link.html('This Artwork Successfully Saved. <b>Click here</b> to edit this artwork');

            succes_div.append(edit_link);

            form.html(succes_div);

            form.removeClass('is-updating');

            if (is_printshop) {
                window.location.href = '?page_id=' + data;
                return;
            }


        }).error(function (data) {

            $(".errors").empty();

            data = $.parseJSON(data.responseText);

            console.log(data);

            for (i in data) {
                var error_div = $("<div>").prop('class', 'dokan-alert dokan-alert-danger');
                error_div.append(data[i]);
                error_div.fadeIn(500);
                $(".errors").append(error_div);
            }

            setTimeout(function () {
                $(".errors").empty();
            }, 5000);

            form.removeClass('is-updating');
        });
    });


    if (is_printshop) {
        $("input.dokan-btn").click();
    }


}


function pricingTagsInit(form) {
    var $ = jQuery;

    form.find("input[data-slug]").change(function () {


        var ref = $(this).data('slug');
        var target = form.find('#pricing-' + ref);
        var is_disabled = target.find('input').prop('disabled');


        target.toggleClass('hide')
            .find('input')
            .prop('disabled', !is_disabled)
    });

}


function filter_products(id, w, h) {
    var $ = jQuery;
    var item = $(".art-" + id);

    var is_square = w == h;

    //If landscape
    if (w > h) {
        w = h;
        h = w;
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

    if (is_square) {
        item.find('[data-slug=posters]').parent().remove();

        if (!small) {
            item.find('[data-slug=framed-art]').parent().remove();
            item.find('[data-slug=art-print]').parent().remove();
            item.find('[data-slug=photography]').parent().remove();
            item.find('[data-slug=stretched-canvases]').parent().remove();
        }

        return;
    }


    if (!a5) {
        item.find('[data-slug=framed-art]').parent().remove();
        item.find('[data-slug=art-print]').parent().remove();
        item.find('[data-slug=photography]').parent().remove();
    }

    if (!a3) {
        item.find('[data-slug=stretched-canvases]').parent().remove();
    }

    if (!a2) {
        item.find('[data-slug=posters]').parent().remove();
    }


}