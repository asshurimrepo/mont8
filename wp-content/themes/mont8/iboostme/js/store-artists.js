(function ($, window, document, undefined) {
    'use strict';

    var gridContainer = $('#grid-container'),
        filtersContainer = $('#filters-container'),
        wrap, filtersCallback;


    /*********************************
     init cubeportfolio
     *********************************/
    gridContainer.cubeportfolio({
        defaultFilter: '*',
        animationType: 'unfold',
        gapHorizontal: 10,
        gapVertical: 10,
        gridAdjustment: 'responsive',
        mediaQueries: [{
            width: 1600,
            cols: 4
        }, {
            width: 1200,
            cols: 4
        }, {
            width: 800,
            cols: 4
        }, {
            width: 500,
            cols: 2
        }, {
            width: 320,
            cols: 1
        }],
        caption: 'overlayBottom',
        displayType: 'lazyLoading',
        displayTypeSpeed: 100,

        lightboxGallery: false,


        // singlePageInline
        singlePageInlineDelegate: '.cbp-singlePageInline',
        singlePageInlinePosition: 'above',
        singlePageInlineInFocus: true,
        singlePageInlineCallback: function (url, element) {
            this.updateSinglePageInline('asshurim');
        }
    });


    // when the height of grid is changed
    gridContainer.on('filterComplete.cbp', function () {
        loadMoreObject.window.trigger('scroll.loadMoreObject');
    });

})(jQuery, window, document);
