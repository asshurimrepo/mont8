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
        gapHorizontal: 1,
        gapVertical: 1,
        gridAdjustment: 'responsive',

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
