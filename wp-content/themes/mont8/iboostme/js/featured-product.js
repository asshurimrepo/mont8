/**
 * Created by asshurimjoylarita on 7/3/15.
 */
function renderMediaUploader($, item) {

    var file_frame, image_data;


    if (undefined !== file_frame) {

        file_frame.open();
        return;

    }


    file_frame = wp.media.frames.file_frame = wp.media({
        // Set the title of the modal.
        title: 'Upload your art (Press shift/ctrl/cmd to select multiple artwork)',
        button: {
            text: 'Select Artwork',
        },
        multiple: false
    });


    file_frame.on('select', function () {

        selection = file_frame.state().get('selection');

        var image = item.find('img');
        var image_cont = item.find('.featured');
        var fa_cloud = item.find('.fa-cloud-upload');
        var input = item.find('input');


        image.addClass('img-responsive');

        selection.map(function (attachment) {

            attachment = attachment.toJSON();

            console.log(attachment);

            image.prop('src', attachment.sizes.shop_single.url);
            image_cont.show();

            input.val(attachment.id);

            fa_cloud.hide();

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


        $('.uploader').each(function(){
            var item = $(this);
            var image = item.find('img');
            var image_cont = item.find('.featured');
            var fa_cloud = item.find('.fa-cloud-upload');

            var image_src = image.attr('src');

            if(image_src){
                image_cont.show();
                image.addClass('img-responsive');
                fa_cloud.hide();
            }
        });


    });

})(jQuery);
