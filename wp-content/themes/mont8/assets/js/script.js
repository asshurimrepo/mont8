jQuery(function ($) {
    var base_url = $("[name=base_url]").prop('content');
    // $('button.single_add_to_cart_button').removeClass('button').addClass('btn btn-danger');
    // $('a.button').removeClass('button').addClass('btn btn-danger');

    $('ul.dropdown-menu li.dropdown').hover(function () {
        $(this).addClass('open');
    }, function () {
        $(this).removeClass('open');
    });


    $("#menu-item-193 .mega_dropdown").append(
        '<div class="row" style="clear: both">' +
        '<a href="' + base_url + '/store-listing" class="more-artists-btn">MORE ARTISTS <i class="fa fa-angle-double-right"></i></a>' +
        '</div>'
    );


    // set dashboard menu height
    var dashboardMenu = $('ul.dokan-dashboard-menu'),
        contentArea = $('#content article');

    if (contentArea.height() > dashboardMenu.height()) {
        if ($(window).width() > 767) {
            dashboardMenu.css({height: contentArea.height()});
        }
    }

    // cat drop stack, disable parent anchors if has children
    if ($(window).width() < 767) {
        $('#cat-drop-stack li.has-children').on('click', '> a', function (e) {
            e.preventDefault();

            $(this).siblings('.sub-category').slideToggle('fast');
        });
    } else {
        $('#cat-drop-stack li.has-children > .sub-category').each(function (index, el) {
            var sub_cat = $(el);
            var length = sub_cat.find('.sub-block').length;

            if (length == 3) {
                sub_cat.css('width', '260%');
            } else if (length > 3) {
                sub_cat.css('width', '340%');
            }
        });
    }

    // tiny helper function to add breakpoints
    function getGridSize() {
        return (window.innerWidth < 600) ? 2 : (window.innerWidth < 900) ? 3 : 4;
    }

    $('.product-sliders').flexslider({
        animation: "slide",
        animationLoop: false,
        itemWidth: 190,
        itemMargin: 10,
        controlNav: false,
        minItems: getGridSize(),
        maxItems: getGridSize()
    });

    // Date Pickers
    $('.datepicker').datepicker();

});


function onLike(v) {
    var $ = jQuery;

    if (v.type == 'likebtn.like' || v.type == 'likebtn.unlike') {
        var this_btn = jQuery(v.wrapper);

        if (this_btn.attr('data-user-logged-in') == 'false') {
            this_btn.find('.likebtn-button>span').click();
            window.location.href = jQuery(".login_panel>a").prop('href');
            return;
        }
    }


    if(v.type == 'likebtn.like'){
        var data = v.settings;
        $.get($("[name=base_url]").prop('content'), {action: 'notify_user_liked_artwork', prod_id: data.identifier});
    }
}