;(function($){

	$(document).ready(function(){
		$('form.dokan-form-container').on('click', '.dokan-feat-image-btn', function() {
			var self = $(this);
			self.closest( '.product-edit-container' ).siblings( '.row-button' ).removeClass('dokan-hide');
		});	

		$( 'form.dokan-form-container' ).on( 'click', '.dokan-remove-feat-image', function() {
			var self = $(this);
			self.closest( '.product-edit-container' ).siblings( '.row-button' ).addClass('dokan-hide');
		});	

		$('form.dokan-form-container').on( 'click', 'div.next-button', function(e) {
			e.preventDefault();
			var self = $(this);

			var featured_image = self.closest('form.dokan-form-container').find('.product-edit-container').first().find('.image-wrap').clone();
			var featured_image_big = self.closest('form.dokan-form-container').find('.product-edit-container').find('img.dokan-small-featured-image').clone();

			featured_image.insertAfter( self );
			self.closest('form.dokan-form-container').find('.dokan-large-product-image-wrapper').html(featured_image_big);
			self.closest('form.dokan-form-container').find('.row-1').addClass('dokan-hide');
			self.closest('form.dokan-form-container').find('.row-button').addClass('dokan-hide');
			self.closest('form.dokan-form-container').find('.continue-button').addClass('dokan-hide');
			
			self.closest('form.dokan-form-container').find('.dokan-another-container').removeClass('dokan-hide');

			$('select.product_tags').chosen();

		});

		$('form.dokan-form-container').on('click', 'a.show-product-arrt', function(e) {
			e.preventDefault();
			$( '.row-3' ).toggleClass('dokan-hide');
		});
	});	
})(jQuery);
