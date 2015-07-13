jQuery(document).ready(function ($) {

    var popup = $("<div class='after-cart-popup'>");
    popup.css('position', 'fixed');
    popup.css('top', '0');
    popup.css('bottom', '0');
    popup.css('left', '0');
    popup.css('right', '0');
    popup.css('background', 'rgba(0,0,0,.5)');
    popup.css('z-index', '9999');


    var box = $("<div class='boxed'>");
    box.css('background', 'rgb(82, 82, 82)');
    box.css('margin', '70px auto');
    box.css('width', '535px');
    //box.css('min-height', '200px');
    box.css('padding', '1px 16px');

    var content = $(
        '<a href="#!" style="font-size: 26px;" class="btn pull-right close-after-cart"><i class="fa fa-times"></i></a>' +
        '<h2 style="color: #FFF;">Successfully Added to your Cart!</h2>' +
        '<div class="row" style="padding: 10px; background: #FFF; margin: 2px; margin-bottom: 15px;">' +
        '<div class="col-md-4 cart-img"></div>' +
        '<div class="col-md-8 cart-info"></div>' +
        '<div class="col-md-12"><hr></div>' +
        '<div class="col-md-5"><a style="margin-top: 0; background: rgb(243, 243, 21); color: #222" href="#!" class="cart-sidebar-btn-checkout btn-continue-shop btn btn-primary btn-block">Continue Shopping</a></div>' +
        '<div class="col-md-2" style="text-align: center">- or -</div>' +
        '<div class="col-md-5"><a style="margin-top: 0;" href="'+ checkout_url +'" class="cart-sidebar-btn-checkout btn btn-primary btn-block">Proceed to Checkout</a></div>' +
        '</div>'
    );



    box.append(content);
    popup.append(box);

    $('body').prepend(popup);


    $(".close-after-cart, .btn-continue-shop").click(function(){
        $(".after-cart-popup").fadeOut(400);
    });


    setTimeout(function () {
        $(".woocommerce-message").hide();
        var list = $("<ul class='list-unstyled'>");
        var img = $("<img>").prop('src', $(".product .woocommerce-main-image img").prop('src')).addClass('img-responsive');
        //var img = $(".product .images").clone;

        list.append('<li><h3 style="margin-top: 0;">' + last_cart_added.data.post.post_title + '</h3></li>');

        var framed_text = '';

        last_cart_added.tmcartepo.map(function(v){
            if(v.section_label == 'Frame this print'){
                framed_text = 'Framed ';
            }
        });

        last_cart_added.tmcartepo.map(function (v) {

            var _framed_text = v.section_label == 'Artwork Style' ? framed_text : '';

            if (v.value != "Yes") {
                list.append('<li><b>' + v.name + ': </b>' + _framed_text + v.value + '</li>');
            }
        });

        list.append('<li><h3>' + last_cart_added.line_total + '</h3></li>');

        $(".cart-info").append(list);
        $(".cart-img").append(img);
    }, 200);

});