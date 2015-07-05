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


    });

})(jQuery);


function addFormEvent($) {
    // Submit form via Ajax
    $("form").on("submit", function (e) {
        event.preventDefault();

        var form = $(this);

        form.addClass('is-updating');

        $.post($(this).prop('action'), $(this).serialize(), 'json').success(function (data) {

            // alert(1);
            $(".errors").empty().html('');

            var succes_div = $("<div>").prop('class', 'dokan-alert dokan-alert-success');

            if(is_printshop){
                window.location.href = '?page_id='+data;

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

            if(is_printshop){
                window.location.href = '?page_id='+data;
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


    if(is_printshop){
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

