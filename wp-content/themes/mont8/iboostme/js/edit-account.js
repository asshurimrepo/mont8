function renderMediaUploader($, item) {

    var file_frame, image_data;


    if (undefined !== file_frame) {

        file_frame.open();
        return;

    }


    file_frame = wp.media.frames.file_frame = wp.media({
        // Set the title of the modal.
        title: 'Select Profile Picture',
        button: {
            text: 'Select',
        },
        multiple: false
    });


    file_frame.on('select', function () {

        selection = file_frame.state().get('selection');

        selection.map(function (attachment) {

            attachment = attachment.toJSON();
            //console.log(attachment);

            var image = attachment.sizes.thumbnail.url;

            $(".avatar.photo").prop('src', image);
            $(".avatar-field").val(attachment.id);
        });


    });

    // Now display the actual file_frame
    file_frame.open();

}

var selection;

(function ($) {


    $(function () {
        $('.uploader').on('click', function (evt) {

            // Stop the anchor's default behavior
            evt.preventDefault();

            var item = $(this);

            // Display the media uploader
            renderMediaUploader($, item);

        });


    });

})(jQuery);