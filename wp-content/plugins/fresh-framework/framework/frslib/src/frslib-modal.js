(function($){
	frslib.provide('frslib.modal');

	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	// CONDITIONAL LOGIC - MODAL WINDOW
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################

	frslib.provide('frslib.modal.conditional_logic');

	frslib.modal.conditional_logic.current_input = null;

	frslib.modal.conditional_logic.show = function() {
		$('.ff-modal-conditions').css('display','block');
	};

	frslib.modal.conditional_logic.hide = function() {
		$('.ff-modal-conditions').css('display','none');
	};



	frslib.modal.conditional_logic.set_content = function( content ) {
		//var val = content
		frslib.modal.conditional_logic.show ();
		var specification =  	{
		 							'managerClass' : 'ffModalWindowManagerConditions',
		 							'modalClass' : 'ffModalWindowConditions',
		 							'viewClass' : 'ffModalWindowConditionsViewDefault'
								};
		if( true ) {
			$('.media-frame-content-inner').html('');
			frslib.ajax.frameworkRequest( 'ffModalWindow', specification, content, function( response ) {
				$('.media-frame-content-inner').html( response);
		 			frslib.options.select_content_type.init();
		 			frslib.conditional_logic.disable_options( $('.media-frame-content-inner').find('.ff-conditional-logic-checkbox') );
		 	});
		 }
	};

	$(document).on('click', '.ff-conditional-submit', function(){
		frslib.modal.conditional_logic.hide();
		var $form = frslib.options.template.functions.normalize( $(this).parents('.ff-modal-conditions').find('form'));
		frslib.modal.conditional_logic.current_input.val( $form.serialize() );
		frslib.callbacks.doCallback('ff-logic-form-submitted', frslib.modal.conditional_logic.current_input);
		return false;
	});

	$(document).on('click', '.media-modal-close, .media-modal-backdrop', function(){
		frslib.modal.conditional_logic.hide();
		return false;
	});


	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	// COLOR LIBRARY - MODAL WINDOW
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################

	(function(){
		frslib.provide('frslib.modal.library.color.picker');
		frslib.provide('frslib.modal.library.color.picker.sidebar');
		frslib.modal.library.color.picker.$currentActiveItem = null;

		//##############################################################################
		//# OPEN & CLOSE
		//##############################################################################

		frslib.modal.library.color.picker.$window = $('#ff-modal-library-color-picker');

		frslib.modal.library.color.picker.open = function() {
			// frslib.modal.library.color.picker.$window.css('display', 'block');
			frslib.modal.library.color.picker.$window.show();
			frslib.modal.library.color.picker.$window.addClass('ff-modal-opened');;
		};

		frslib.modal.library.color.picker.close = function() {
			// frslib.modal.library.color.picker.$window.css('display', 'none');
			frslib.modal.library.color.picker.$window.hide();
			frslib.modal.library.color.picker.$window.removeClass('ff-modal-opened');;
		};

		//##############################################################################
		//# SIDEBAR VIEW
		//##############################################################################

		frslib.modal.library.color.picker.sidebar.$sidebar = $('.media-sidebar .attachment-details');

		frslib.modal.library.color.picker.sidebar.show = function() {
			frslib.modal.library.color.picker.sidebar.$sidebar.css('display', 'block');
		}

		frslib.modal.library.color.picker.sidebar.hide = function() {
			frslib.modal.library.color.picker.sidebar.$sidebar.css('display', 'none');
		}

		frslib.modal.library.color.picker.sidebar.setData = function( colorJSON ) {
			console.log( colorJSON );
			var $sidebar = frslib.modal.library.color.picker.sidebar.$sidebar;
			var colorCreationDate = new Date(colorJSON.timestamp * 1000);
			var colorCreationDateString = (colorCreationDate.getDate() ) + '.' + ( colorCreationDate.getMonth() + 1 ) + '.' + colorCreationDate.getFullYear();
			var colorRGBAString = 'rgba(' + colorJSON.r + ', ' + colorJSON.g + ', ' + colorJSON.b + ', ' + colorJSON.a + ')';

			$sidebar.find('.uploaded').html( colorCreationDateString );
			$sidebar.find('.title').val( colorJSON.title  );
			$sidebar.find('.tags').val( colorJSON.tags );

			$sidebar.find('.thumbnail').css('background-color', colorRGBAString);

			$sidebar.find('.id').val( colorJSON.id );
		}

		frslib.modal.library.color.picker.sidebar.$sidebar.find('.delete-attachment').click(function() {
			var colorId = frslib.modal.library.color.picker.sidebar.$sidebar.find('.id').val();

			frslib.modal.library.color.picker.sidebar.ajaxDeleteColor( colorId );

		});

		frslib.modal.library.color.picker.sidebar.ajaxDeleteColor = function( id ) {
			var specification  =
				{
						'managerClass' : 'ffModalWindowManagerLibraryColorPicker',
						'modalClass' : 'ffModalWindowLibraryColorPicker',
						'viewClass' : 'ffModalWindowLibraryColorPickerViewDefault'
				};

			var data = {
					'colorId' : id
			}

			frslib.ajax.frameworkRequest( 'ffModalWindow', specification, data, function( response ) {
				console.log( response );
				if( response == '1' ) {
					frslib.modal.library.color.picker.$currentActiveItem.remove();
					frslib.modal.library.color.picker.$currentActiveItem = null;
				}
		 	});
		}

		//##############################################################################
		//# Initialization
		//##############################################################################

		$('body').on( 'click', '.ff-open-library-color-button', function(){
			frslib.modal.library.color.picker.open();
		});

		$('body').on( 'click', '.ff-one-color-item', function( e ) {
			var activeClass = 'ff-one-color-item-active';
			var colorItem = $.parseJSON($(this).find('.json_data').html());

			$('.ff-one-color-item').removeClass( activeClass );
			$(this).addClass( activeClass );
			frslib.modal.library.color.picker.$currentActiveItem = $(this);

			frslib.modal.library.color.picker.sidebar.setData(colorItem);
			frslib.modal.library.color.picker.sidebar.show();
		});


		$(document).keyup(function(e) {
			if (e.keyCode == 27) {
				frslib.modal.library.color.picker.close();
			}
		});



		
		$('.edit-attachment').click(function() {
			$('#ff-modal-library-color-editor').css('display', 'block');
			return false;
		});

	})();

	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	// FIXED-LIKE HEADERS
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################
	//##############################################################################

	frslib.modal.library.fixed_like_headers = (function(){
		var _fixed_like_headers = this;

		_fixed_like_headers.init = function(){
			$('.ff-modal-library-items-groups-titles-container').each(function(){
				if( $(this).hasClass('ff-fixed-like-headers-initialized') ){
					return;
				}

				$(this).css('z-index',9999);
				// apply to all non - initialized headers
				$(this).parents('.ff-modal-library-items-container').scroll(function(){
					document.title = $(this).scrollTop() + 'px';
					$(this).find('.ff-modal-library-items-groups-titles-container').css( 'margin-top', $(this).scrollTop() + 'px' );
				});

				$(this).addClass('ff-fixed-like-headers-initialized');
			});
		}


		return _fixed_like_headers;
	})();

	// $(document).ready(function(){
	$(window).load(function(){
		frslib.modal.library.fixed_like_headers.init();
	})

})(jQuery);












