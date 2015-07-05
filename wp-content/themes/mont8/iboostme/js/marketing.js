(function ($) {


    $(document).ready(function () {

        $(".azm-btn").click(function () {
            var w = 548, h = 325;
            var left = (screen.width / 2) - (w / 2);
            var top = (screen.height / 2) - (h / 2);

            var social_info = $(".social-info");
            var title = social_info.data('social-share-title'),
                image = social_info.data('social-share-image'),
                link = social_info.data('social-share-link');


            if ($(this).hasClass('azm-facebook'))
                window.open('https://www.facebook.com/dialog/feed?display=popup&redirect_uri=' + link + '&link=' + link + '&name=' + title + '&picture=' + image, 'sharer', 'toolbar=0,status=0,width=548,height=325,top=' + top + ',left=' + left);

            if ($(this).hasClass('azm-twitter'))
                window.open('https://twitter.com/intent/tweet?url=' + link + '&text=' + title + '&via=mont8&hashtags=mont8%2Cart%2C', 'sharer', 'toolbar=0,status=0,width=548,height=325,top=' + top + ',left=' + left);

            if ($(this).hasClass('azm-pinterest'))
                window.open('https://www.pinterest.com/pin/create/button/?url=' + link + '&description=' + title + '&media=' + image, 'sharer', 'toolbar=0,status=0,width=548,height=325,top=' + top + ',left=' + left);

            if ($(this).hasClass('azm-google-plus'))
                window.open('https://plus.google.com/share?url=' + link, 'sharer', 'toolbar=0,status=0,width=548,height=325,top=' + top + ',left=' + left);


        });

    });

})(jQuery);