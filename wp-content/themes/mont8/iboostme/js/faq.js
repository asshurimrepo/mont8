(function ($) {


    var methods = {

        show_topic: function (e) {

            e.preventDefault();

            var target = $($(this).attr('href'));

            $(this).parent().addClass('active').siblings().removeClass('active');

            target.removeClass('hide').show().siblings().hide();

            return false;
        }


    };


    $(".faq-topic > a").click(methods.show_topic);


})(jQuery);