(function($){
frslib.provide('frslib.options');
frslib.provide('frslib.options.template');


//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// TEMPLATING SYSTEM
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// here we manage all the templating stuff, like add, duplicate, formate
// delete, get ready for sending and other things

/******************************************************************************/
/** SELECTORS
/******************************************************************************/
frslib.provide('frslib.options.template.selectors');
frslib.provide('frslib.options.template.callbacks');
frslib.provide('frslib.options.template.functions');
// - BUTTONS
frslib.options.template.selectors.repeatable_button_add_above              = '.ff-repeatable-add-above';
frslib.options.template.selectors.repeatable_button_add_below              = '.ff-repeatable-add-below';
frslib.options.template.selectors.repeatable_button_duplicate_above        = '.ff-repeatable-duplicate-above';
frslib.options.template.selectors.repeatable_button_duplicate_below        = '.ff-repeatable-duplicate-below';
frslib.options.template.selectors.repeatable_button_remove                 = '.ff-repeatable-remove';
frslib.options.template.selectors.repeatable_button_handle                 = '.ff-repeatable-handle';
frslib.options.template.selectors.repeatable_button_settings               = '.ff-repeatable-settings';
frslib.options.template.selectors.repeatable_button_settings_overlay       = '.ff-popup-overlay';
frslib.options.template.selectors.repeatable_button_drag                   = '.ff-repeatable-drag';
// - BUTTONS END

// - CLASSES
frslib.options.template.selectors.repeatable_parent_ul                     = '.ff-repeatable';
frslib.options.template.selectors.repeatable_parent_ul_first               = '.ff-repeatable:first';
frslib.options.template.selectors.repeatable_template                      = '.ff-repeatable-template';
frslib.options.template.selectors.repeatable_item                          = '.ff-repeatable-item';
frslib.options.template.selectors.repeatable_item_first                    = '.ff-repeatable-item:first';
frslib.options.template.selectors.repeatable_item_popup_opened             = '.ff-repeatable-item-popup-opened'
frslib.options.template.selectors.repeatable_item_hover                    = '.ff-repeatable-item-hover'
frslib.options.template.selectors.repeatable_item_opened                   = '.ff-repeatable-item-opened';
frslib.options.template.selectors.repeatable_item_closed                   = '.ff-repeatable-item-closed';
frslib.options.template.selectors.repeatable_content_first                 = '.ff-repeatable-content:first';
frslib.options.template.selectors.repeatable_header                        = '.ff-repeatable-header';
// - CLASSES END

// - POPUP MENU ON COGWHEEL
frslib.options.template.selectors.repeatable_popup_menu                    = '.ff-popup';
frslib.options.template.selectors.repeatable_popup_menu_open               = '.ff-popup-open';
// - POPUP MENU ON COGWHEEL END

// - HOVERS
frslib.options.template.selectors.repeatable_button_remove_hover           = '.ff-repeatable-remove-hover';
frslib.options.template.selectors.repeatable_button_add_above_hover        = '.ff-repeatable-add-above-hover';
frslib.options.template.selectors.repeatable_button_add_below_hover        = '.ff-repeatable-add-below-hover';
frslib.options.template.selectors.repeatable_button_duplicate_above_hover  = '.ff-repeatable-duplicate-above-hover ff-repeatable-duplicate-hover';
frslib.options.template.selectors.repeatable_button_duplicate_below_hover  = '.ff-repeatable-duplicate-below-hover ff-repeatable-duplicate-hover';
frslib.options.template.selectors.repeatable_button_handle_hover           = '.ff-repeatable-handle-hover';
frslib.options.template.selectors.ff_repeatable_top_hover                  = '.ff-repeatable-top-hover';
frslib.options.template.selectors.ff_repeatable_bottom_hover               = '.ff-repeatable-bottom-hover';
frslib.options.template.divider 										   = '--||--';
// - HOVERS END

frslib.options.template.callbacks.duplicate_before_clone                   = '.duplicate_before_clone';
frslib.options.template.callbacks.duplicate_after_clone                    = '.duplicate_after_clone';

/******************************************************************************/
/** INITIALIZATION
/******************************************************************************/
// all things
frslib.options.template.init = function() {
	$(document).on('mousedown', frslib.options.template.selectors.repeatable_button_settings, function( e ){
		$(this).mouseup();
	});

	$(document).on('mousedown', frslib.options.template.selectors.repeatable_button_handle+'>'+frslib.options.template.selectors.repeatable_button_handle, function( e ){
		$(this).mouseup();
	});

	// $(document).on('mousedown', '.ff-repeatable-handle', function( e ){
	// 	var $parent = $(this).parent('.' + frslib.options.template.selectors.repeatable_item_opened.replace('.',''));
	// 	$parent.children(frslib.options.template.selectors.repeatable_content_first).slideUp(1, function() {
	// 		$parent.removeClass( frslib.options.template.selectors.repeatable_item_opened.replace('.','') );
	// 		$parent.addClass( frslib.options.template.selectors.repeatable_item_closed.replace('.','') );
	// 	});		
	// 	return false;
	// });

	$(document).on('mousedown', frslib.options.template.selectors.repeatable_popup_menu_open, function( e ){
		$(this).mouseup();
	});

	$(document).on('click', frslib.options.template.selectors.repeatable_button_settings, function( e ){
		var $settings_popup = $( this ).siblings(frslib.options.template.selectors.repeatable_popup_menu);
		$settings_popup.css('top',  'auto' );
		$settings_popup.css('left', 'auto' );

		var menu_width = $(this).siblings(frslib.options.template.selectors.repeatable_popup_menu).width();
		var menu_height = $(this).siblings(frslib.options.template.selectors.repeatable_popup_menu).height();

		var window_width = $(window).width();
		var window_height = $(window).height() + $(window).scrollTop();;

		var window_padding_left = 10;
		var window_padding_bottom = 10;

		var parentOffset = $(this).parent().offset(); 

		var relX = 0;
		if( e.pageX > window_width - menu_width - window_padding_left){
			relX = 1 * e.pageX - 1 * parentOffset.left - menu_width - 1;
		}else{
			relX = 1 * e.pageX - 1 * parentOffset.left;
		}

		var relY = 0;
		if( e.pageY > window_height - menu_height - window_padding_bottom){
			relY = 1 * e.pageY - 1 * parentOffset.top - menu_height - 1;
		}else{
			relY = 1 * e.pageY - 1 * parentOffset.top + 1;
		}

		$settings_popup.css('top',  relY + 'px' );
		$settings_popup.css('left', relX + 'px' );

		$settings_popup.addClass(frslib.options.template.selectors.repeatable_popup_menu_open.replace('.',''));

		if( 0 == $( frslib.options.template.selectors.repeatable_button_settings_overlay ).size() ){
			$( 'body' ).append('<div class="'+frslib.options.template.selectors.repeatable_button_settings_overlay.replace('.','')+'"></div>');
		}
		$( frslib.options.template.selectors.repeatable_button_settings_overlay ).show();

		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( 'ff-repeatable-item-popup-opened' );
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( 'ff-repeatable-item-hover' );

		return false;
	});

	$(document).on('click', frslib.options.template.selectors.repeatable_button_settings_overlay, function( e ){
		$( this ).hide();
		$(frslib.options.template.selectors.repeatable_popup_menu_open).removeClass(frslib.options.template.selectors.repeatable_popup_menu_open.replace('.',''));

		$( '.ff-repeatable-item-popup-opened' ).removeClass( 'ff-repeatable-item-popup-opened' )
		$( '.ff-repeatable-item-hover' ).removeClass( 'ff-repeatable-item-hover' )
		//$( frslib.options.template.selectors.repeatable_item_hover ).removeClass( frslib.options.template.selectors.repeatable_item_hover.replace('.','') );
	});


	// REMOVE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_remove, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_remove_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_remove, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_remove_hover.replace('.','') );
	});
	
	// ADD ABOVE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_add_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_add_above_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_add_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_add_above_hover.replace('.','') );
	});
	
	// ADD BELOW
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_add_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_add_below_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_add_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_add_below_hover.replace('.','') );
	});
	
	//DUPLICATE ABOVE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_duplicate_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_duplicate_above_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_duplicate_above, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_duplicate_above_hover.replace('.','') );
	});
	
	//DUPLICATE BELOW
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	});
	
	//HANDLE
	$(document).on('mouseenter', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).addClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	}).on('mouseleave', frslib.options.template.selectors.repeatable_button_duplicate_below, function(){
		$(this).parents( frslib.options.template.selectors.repeatable_item_first ).removeClass( frslib.options.template.selectors.repeatable_button_duplicate_below_hover.replace('.','') );
	});

	// TEXT TITLE

	$(document).on("change", ".edit-repeatable-item-title", function() {
		var _val = $(this).val();
		if( '' == _val ){
			if( $(this).attr('placeholder') ){
				_val = $(this).attr('placeholder');
			}
 		}
		$(this).parents( '.ff-repeatable-item:first' ).children( '.ff-repeatable-header' ).find('.ff-repeatable-title').html(
			_val
		);
	});
	$(document).on("keypress", ".edit-repeatable-item-title", function(event) { $(this).change(); });
	$(document).on("keydown", ".edit-repeatable-item-title", function(event) { $(this).change(); });
	$(document).on("keyup", ".edit-repeatable-item-title", function(event) { $(this).change(); });

	// TEXT DESCRIPTION

	$(document).on("change", ".edit-repeatable-item-description", function() {
		var _val = $(this).val();
		if( '' == _val ){
			if( $(this).attr('placeholder') ){
				_val = $(this).attr('placeholder');
			}
		}
		$(this).parents( '.ff-repeatable-item:first' ).children( '.ff-repeatable-header' ).find('.ff-repeatable-description').html(
			_val
		);
	});
	$(document).on("keypress", ".edit-repeatable-item-description", function(event) { $(this).change(); });
	$(document).on("keydown", ".edit-repeatable-item-description", function(event) { $(this).change(); });
	$(document).on("keyup", ".edit-repeatable-item-description", function(event) { $(this).change(); });

	// INIT SORTABLES
	$(document).ready(function(){
		frslib.options.template.init_sortable();
		$('.edit-repeatable-item-title').change();
		$('.edit-repeatable-item-description').change();
	});

};

// sortable
frslib.options.template.init_sortable = function() {
	$(frslib.options.template.selectors.repeatable_parent_ul).each(function(){
		$(this).sortable({
			handle:frslib.options.template.selectors.repeatable_button_handle
		});
	});
};
frslib.options.template.init();

/******************************************************************************/
/** TEMPLATING FUNCTIONS - DUPLICATE
/******************************************************************************/
/*
 * Add a new section before / after the header. It's feeded from the template
 * selector
 */
$(document).on('click', frslib.options.template.selectors.repeatable_button_duplicate_above + ',' + frslib.options.template.selectors.repeatable_button_duplicate_below, function(){

	// Click on menu background overlay -> hides menu
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();

	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_before_clone.replace('.',''), $parent );
	
	frslib.htmlforms.writeValueToCode( $parent );
	var $newItem = $parent.clone(true);
	$newItem.removeClass('ff-repeatable-item-opened').addClass('ff-repeatable-item-closed').find('.ff-repeatable-content').css('display','none');
	
	// ADD ABOVE
	if( $(this).hasClass( frslib.options.template.selectors.repeatable_button_duplicate_above.replace('.','') ) ) {
		$parent.before( $newItem );
		
	// ADD BELOW
	} else {
		$parent.after( $newItem );	
	}
	
	frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_after_clone.replace('.',''), $newItem, $parent );
	
	$newItem.hide();

	$newItem.addClass('ff-repeatable-duplicate-animation').animate({ height: 'show', opacity: 'show' }, 400, 'swing', function(){
		$(this).removeClass('ff-repeatable-duplicate-animation');
	});
	//frslib.htmlforms.writeValueToCode
	frslib.options.template.init_sortable();
	return false;
});

/******************************************************************************/
/** TEMPLATING FUNCTIONS - ADD
/******************************************************************************/
/*
 * Add a new section before / after the header. It's feeded from the template
 * selector
 */
$(document).on('click', frslib.options.template.selectors.repeatable_button_add_above + ',' + frslib.options.template.selectors.repeatable_button_add_below, function(){

	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	if( $parent.attr('data-section-id') != undefined ) {
		var template_name = $parent.attr('data-section-id');

		var $template = $parent_ul.children('.ff-repeatable-template-holder').children(frslib.options.template.selectors.repeatable_template+'[data-section-id="'+template_name+'"]:first');
	} else {
		var $template = $parent_ul.find(frslib.options.template.selectors.repeatable_template);
	}
	frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_before_clone.replace('.',''), $template );
	
	var $newItem = $($template.html());
	$newItem.hide();
	
	// ADD ABOVE
	if( $(this).hasClass( frslib.options.template.selectors.repeatable_button_add_above.replace('.','') ) ) {
		$parent.before( $newItem );
		
	// ADD BELOW
	} else {
		$parent.after( $newItem );	
	}
	frslib.callbacks.doCallback( frslib.options.template.callbacks.duplicate_after_clone.replace('.',''), $newItem, $template );
	$newItem.addClass('ff-repeatable-add-animation').animate({ height: 'toggle' }, 300, 'swing', function(){
		$(this).removeClass('ff-repeatable-add-animation');
	});
	frslib.options.template.init_sortable();
	return false;
});


/******************************************************************************/
/** TEMPLATING FUNCTIONS - REMOVE
/******************************************************************************/
/*
 * remove the clicked option
 */
$(document).on('click',frslib.options.template.selectors.repeatable_button_remove, function(){
	
	// Click on menu background overlay -> hides menu
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();
	$( frslib.options.template.selectors.repeatable_button_settings_overlay ).click();

	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	var number_of_siblings_li = $parent_ul.children(frslib.options.template.selectors.repeatable_item).length;

	var enable_delete_all_repeatable_items = $(this).parents('.ff-repeatable:first').hasClass('enable-delete-all-repeatable-items');

	if( ( number_of_siblings_li == 1 ) && ! enable_delete_all_repeatable_items ) {
		$parent.animate({ left:-10},200).animate({ left:10},200).animate({ left:0},200);
		return false;
	}

	$parent.animate({ height: 'toggle', opacity: 'toggle' }, 400, function(){
		$parent.remove();
	});

	return false;
});

/* REPEATABLE LOGIC remove */
$(document).on('click','.ff-repeatable-logic-button-remove', function(){

	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	var number_of_siblings_li = $parent_ul.children(frslib.options.template.selectors.repeatable_item).length;
	
	if( number_of_siblings_li == 1 ) {
		var $main_parent = $(this).parents(frslib.options.template.selectors.repeatable_item+':eq(1)');//.remove();
		var length = $main_parent.siblings(frslib.options.template.selectors.repeatable_item).length;
		if( length > 0 ) {
			$main_parent.animate({ height: 'toggle', opacity: 'toggle' }, 300, function(){
				$main_parent.remove();
			});
		} else {
			$parent.animate({ left:-10},200).animate({ left:10},200).animate({ left:0},200);
		}
		//console.log( $main_parent);
		//alert( $main_parent.siblings('.ff-repeatable-item').length);
		//$parent.animate({ left:-10},200).animate({ left:10},200).animate({ left:0},200);
		return;
	}
	
	$parent.animate({ height: 'toggle', opacity: 'toggle' }, 300, function(){
		$parent.remove();
	});
	
	return false;
});


/******************************************************************************/
/** TEMPLATING FUNCTIONS - OPEN & CLOSE
/******************************************************************************/
/*
 * Open/close clicked handle and close all the siblings
 */
$(document).on('click',frslib.options.template.selectors.repeatable_button_handle, function(){
	var $parent = $(this).parents(frslib.options.template.selectors.repeatable_item_first);
	
	var $parent_ul = $parent.parents( frslib.options.template.selectors.repeatable_parent_ul_first );
	
	$parent_ul.children('li').css({opacity:1});
	var speed = 200;
	if( $parent.hasClass(frslib.options.template.selectors.repeatable_item_opened.replace('.','')) ) {
		$parent.children(frslib.options.template.selectors.repeatable_content_first).slideUp(speed, function() {
			$parent.removeClass( frslib.options.template.selectors.repeatable_item_opened.replace('.','') );
			$parent.addClass( frslib.options.template.selectors.repeatable_item_closed.replace('.','') );
		});
	} else {
		
		
		
		$parent.children(frslib.options.template.selectors.repeatable_content_first).slideDown(speed, function() {
			$parent.removeClass(frslib.options.template.selectors.repeatable_item_closed.replace('.',''));
			$parent.addClass(frslib.options.template.selectors.repeatable_item_opened.replace('.',''));
		});

		var $siblings = $parent.siblings( );
		$siblings.each(function(i,o){
			$(o).children(frslib.options.template.selectors.repeatable_content_first).slideUp(speed, function() {
				$(this).parents(frslib.options.template.selectors.repeatable_item_first).removeClass(frslib.options.template.selectors.repeatable_item_opened.replace('.',''));
				$(this).parents(frslib.options.template.selectors.repeatable_item_first).addClass(frslib.options.template.selectors.repeatable_item_closed.replace('.',''));
			});
		});
	}
	return false;	
});

/******************************************************************************/
/** TEMPLATING FUNCTIONS - NORMALIZE
/******************************************************************************/

frslib.options.template.functions.normalize = function( $form, submit ) {
	// first write the values directly to the attributes, so it get copied also.
	// frslib.options.template.selectors.repeatable_parent_ul  
	
	// NORMALIZING THE CONDITIONAL LOGIC FORMS 
	$form.find('.ff-option-conditional-logic').each(function(i,o) {
		var $normalizedConditionalLogic = frslib.options.template.functions.normalize( $(this) );
		//var $normalizedConditionalLogic = $normalizedConditionalLogic.wrap('<form></form>');
		
		var serialised = $('<form>').append( $normalizedConditionalLogic ).serialize()
		$(this).parent().find('.ff-hidden-input').val( serialised );
	});
	

	
	// NORMALIZING THE INPUT VALUES
	//$form.find( frslib.options.template.selectors.repeatable_parent_ul ).find('input, select, textarea').each(function(i, o){
	$form.find('input, select, textarea').each(function(i, o){
		
		
		// DONT normalize SELECT2 - we will do it in other loop, it gaves us lot of problems
		if( $(this).parents('.ff-select2-real-wrapper').length > 0 ) {
			return;
		}
		
		
		
		// important for clonning the values
		var val = $(this).val();
		$(this).attr('value', val);
		
		// NORMALIZING INPUTS
		if( $(this).is('input') ) {
			
			// CHECKBOXES
			if( $(this).attr('type') == 'checkbox' ) {
				var checked = $(this).is(':checked');
				
				if( checked ) {
					$(this).attr('checked', 'checked');
				}
				else {
					$(this).prop('checked', false);
					$(this).removeAttr('checked');
				}
				
			} 
		}
		// NORMALIZING SELECTS
		else if( $(this).is('select') ) {
			
			// MULTIPLE
			if( $(this).attr('multiple') == 'multiple' ) {
				
			} 
			// SINGULAR
			else {
				var currentValue =  $(this).val();
				
				$(this).find('option').removeAttr('selected');
				$(this).find('option').each(function(){
					if( $(this).attr('value') == currentValue ) {
						$(this).attr('selected', 'selected');
						$(this).prop('selected', 'selected');
					}
				});
			}
		}
	});
	// SELECT 2
	$form.find('.ff-select2').each(function(i,o){
		if( $(o).parents('.ff-select2-real-wrapper').length > 0 && $(o).hasClass('select2-container') ) {
			var selectedValues = $(o).select2('val');
			var $inputHidden = $(o).parents('.ff-select2-wrapper:first').find('.ff-select2-value-wrapper').find('input');
			var $parent =  $(o).parents('.ff-select2-wrapper:first');
			
			$inputHidden.val(selectedValues.join( frslib.options.template.divider  ));
			$inputHidden.attr('value', $inputHidden.val() );
		}
	});
	

	
	// NORMALIZING THE NAME VALUES
	var $formClonned = $form.clone(true,true);
	var number_of_sections = $formClonned.find('.ff-repeatable').size();
	
	$formClonned.find('.ff-repeatable-template-holder').remove();
	$formClonned.find('.ff-select2').remove();
	$formClonned.find('.ff-option-conditional-logic').remove();
	$formClonned.find('.ff-select2-value-wrapper').css('display', 'block');

	for( var i = 0; i < number_of_sections; i++) {
		var $repeat = $formClonned.find('.ff-repeatable:eq('+i+')');
		
		var currentLevel = $repeat.attr('data-current-level');
		
		var toReplace = '-_-'+currentLevel+'-TEMPLATE-_-';
		
		var indexCounter = 0;
		
		$repeat.children('.ff-repeatable-item').each(function(){
			
			var replaced = $(this).clone().outerHtml().replace( new RegExp( toReplace,'g'), indexCounter);
			$(this).outerHtml( replaced );
			indexCounter++;
		});
	}
	$formClonned.find('input[type="submit"]').remove();
	//$form.submit();
	if( submit == true ) {
		$formClonned.css('display','none').appendTo('body');
		$formClonned.submit();
	} else {
		return $formClonned
	}
};


$(document).ready(function(){


/*	$('.ff-testing-option-form').submit(function(){
		var $form = frslib.options.template.functions.normalize( $('.ff-testing-option-form') );
		
		$form.appendTo('body');
		
		return false;
	});*/
	
	$('.ff-form-submit').click(function(){
		var form = frslib.options.template.functions.normalize( $(this).parents('form:first'), true );
		
		//form.appendTo('body');
		return false;
	});

	
$('.fftestform').find('.sbmt').click(function(){;

	var form = frslib.options.template.functions.normalize( $(this).parents('form:first') );
	//console.log( form.serialize() );
	return false;
	
});

});
/*
$('#xxxxxxxx').click(function(){
		$(this).parents('form:first').find('.ff-repeatable-template').remove();
		//$(this).parents('form:first').find('.ff-repeatable-item')
		//console.log($(this).parents('form:first').serialize());
		//return false;
		//return false;
		
		var $form = $('.ff-repeatable').parents('form:first');
		
		
		var number_of_sections = $form.find('.ff-repeatable').size();
		
		$('.ff-repeatable').find('input').each(function(){
			var val = $(this).val();
			$(this).attr('value', val);
			
			if( $(this).attr('type') == 'checkbox' ) {
				var checked = $(this).is(':checked');
				
				if( checked ) {
					$(this).attr('checked', 'checked');
				}
				else {
					$(this).prop('checked', false);
					$(this).removeAttr('checked');
				}
				
			}
		});
		
		
		for( var i = 0; i < number_of_sections; i++) {
			var $repeat = $form.find('.ff-repeatable:eq('+i+')');
			
			var currentLevel = $repeat.attr('data-current-level');
			
			var toReplace = '-_-'+currentLevel+'-TEMPLATE-_-';
			
			var indexCounter = 0;
			
			$repeat.children('.ff-repeatable-item').each(function(){
				var replaced = $(this).clone().outerHtml().replace( new RegExp( toReplace,'g'), indexCounter);
				$(this).outerHtml( replaced );
				indexCounter++;
			});
		}
		
		if( $('.ffsend').is(':checked')) {
			
		} else {
			return false;
		}
	});
});
*/
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// SELECT 2
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################

frslib.provide('frslib.options.select2');
frslib.provide('frslib.options.select2.selectors');

frslib.options.select2.selectors.main_wrapper = '.ff-select2-wrapper';
frslib.options.select2.selectors.real_wrapper = '.ff-select2-real-wrapper';
frslib.options.select2.selectors.shadow_wrapper = '.ff-select2-shadow-wrapper';
frslib.options.select2.selectors.select2_class = '.ff-select2';

/******************************************************************************/
/** INITIALIZE SELECT2
/******************************************************************************/
frslib.options.select2.init = function() {
	$(document).ready(function(){
		
		$('.ff-select2-wrapper').each(function(){
		
			var value = $(this).find('.ff-select2-value-wrapper').find('input').val();
			var valueSplitted = value.split('--||--');
			
			frslib.options.select2.create( $(this).find('.ff-select2-real-wrapper').find('.ff-select2'), valueSplitted );
			
			//console.log( valueSplitted );
			 //$(this).find('.ff-select2-real-wrapper').find('.ff-select2').select2('val', 'sidebar-1');
			 //$(this).find('.ff-select2-real-wrapper').find('.ff-select2').css('opacity',0.1);
		});
	});
}
frslib.options.select2.init();
/******************************************************************************/
/** CREATE OPTION
/******************************************************************************/
/**
 * Initialize select 2 on a SELECT option. Here we also have needed classes to
 * perform this action.
 */
frslib.options.select2.create = function( $selector, value ) {
	$(document).ready(function(){
		if( value == undefined ) {
			value = '';
		}
		$selector.each(function(){
			$(this).select2({
			containerCssClass	: frslib.options.select2.selectors.select2_class.replace('.',''),
			dropdownCssClass	: frslib.options.select2.selectors.select2_class.replace('.','')+' select2-hidden',
			placeholder : 'All',

		});
		
		});
	});
};


/******************************************************************************/
/** CALLBACK - DUPLICATE - BEFORE CLONE
/******************************************************************************/
frslib.callbacks.addCallback( frslib.options.template.callbacks.duplicate_before_clone.replace('.',''), function( $parent ) {
	$parent.find( frslib.options.select2.selectors.main_wrapper ).each(function(i,o){
		var data = $(o).find(frslib.options.select2.selectors.real_wrapper).find( frslib.options.select2.selectors.select2_class ).select2('data');
		$(o).find(frslib.options.select2.selectors.real_wrapper).data('select2-data', data);
	});
});

/******************************************************************************/
/** CALLBACK - DUPLICATE - AFTER CLONE
/******************************************************************************/
frslib.callbacks.addCallback( frslib.options.template.callbacks.duplicate_after_clone.replace('.',''), function( $newItem, $parent ){
	$newItem.find( frslib.options.select2.selectors.main_wrapper ).each(function(i,o){
		var data = $(o).find(frslib.options.select2.selectors.real_wrapper).data('select2-data');
		
		var newHtml = $(o).find(frslib.options.select2.selectors.shadow_wrapper).html();
		$(o).find(frslib.options.select2.selectors.real_wrapper).html(newHtml);
		frslib.options.select2.create( $(o).find(frslib.options.select2.selectors.real_wrapper).find('select') );
		
		if( data == null ) {
			return;
		}
		
		if( data.length == null ) {
			$(o).find(frslib.options.select2.selectors.real_wrapper).find( frslib.options.select2.selectors.select2_class ).select2('val',data.id);
		} else {
			var newValues = new Array();
			
			for( var key in data ) {
				newValues.push(data[ key ].id);
			}
			
			$(o).find(frslib.options.select2.selectors.real_wrapper).find( frslib.options.select2.selectors.select2_class ).select2('val',newValues);
		}
	});
});

/******************************************************************************/
/** ADD VALUES
/******************************************************************************/

/**
 * Add realtime values to the select2 by destryoing it, adding values and
 * creating again.
 * 
 * format of values is HTML options
 * 
 * The selector mus thave class main_wrappers
 */
frslib.options.select2.setValuesHtml = function( $select2_main_wrapper, values ) {
	if( !$select2_main_wrapper.hasClass( frslib.options.select2.selectors.main_wrapper.replace('.','') ) ) {
		console.log('ERROR - frslib.options.select2.addValues SELECTOR MUST HAVE CLASS "'+frslib.options.select2.selectors.main_wrapper+'"');
		return;
	}
	// destroy the select 2 ( otherwise we cant add data )
	$select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( frslib.options.select2.selectors.select2_class ).select2('destroy');
	// add data to both selects
	$select2_main_wrapper.find( frslib.options.select2.selectors.select2_class ).html( values );
	// find the select which should be select 2 and then set the values
	var $select2_to_initialize = $select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( 'select' );
	frslib.options.select2.create( $select2_to_initialize );
};

/**
 * Add realtime values to the select2 by destryoing it, adding values and
 * creating again.
 * 
 * format of values is array
 * values [ name ] = value
 * 
 * The selector mus thave class main_wrappers
 */
frslib.options.select2.setValuesArray = function( $select2_main_wrapper, values ) {
	if( !$select2_main_wrapper.hasClass( frslib.options.select2.selectors.main_wrapper.replace('.','') ) ) {
		console.log('ERROR - frslib.options.select2.addValues SELECTOR MUST HAVE CLASS "'+frslib.options.select2.selectors.main_wrapper+'"');
		return;
	}
	// destroy the select 2 ( otherwise we cant add data )
	$select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( frslib.options.select2.selectors.select2_class ).select2('destroy');
	// add data to both selects
	
	var newValues = '';
	for( var key in values ) {
		newValues += '<option value="'+values[key]+'">'+key+'</option>';
	}
	$select2_main_wrapper.find( frslib.options.select2.selectors.select2_class ).html( newValues );
	// find the select which should be select 2 and then set the values
	var $select2_to_initialize = $select2_main_wrapper.find( frslib.options.select2.selectors.real_wrapper ).find( frslib.options.select2.selectors.select2_class );
	frslib.options.select2.initialize( $select2_to_initialize );
};

frslib.options.select2.hasValue = function( $select2_main_wrapper, value ) {
	if( !$select2_main_wrapper.hasClass( frslib.options.select2.selectors.main_wrapper.replace('.','') ) ) {
		console.log('ERROR - frslib.options.select2.addValues SELECTOR MUST HAVE CLASS "'+frslib.options.select2.selectors.main_wrapper+'"');
		return;
	}
	
	$select2_main_wrapper.find( frslib.options.sleect2.selectors.shadow_wrapper).find('option').each(function(){
		//console.log( 'shit ');
	});
};

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//SELECT CONTENT TYPE
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
frslib.provide('frslib.options.select_content_type');
frslib.provide('frslib.options.select_content_type.selectors');
frslib.provide('frslib.options.select_content_type.fetched_data');

frslib.options.select_content_type.selectors.ff_select_content_type = '.ff-select-content-type';
frslib.options.select_content_type.selectors.ff_select_content_type_data = '.ff-select-content-type-data';

frslib.options.select_content_type.init = function() {
	$(document).ready(function(){
		var data = $(frslib.options.select_content_type.selectors.ff_select_content_type_data).html();
		
		$('.ff-select-content-type').each(function(){
		
			//var value = $(this).attr('data-value');
			var $select = $(this);
			$(frslib.options.select_content_type.selectors.ff_select_content_type).html( data );
			
			
		});
		
		$('.ff-select-content-type').each(function(){
			var value = $(this).attr('data-value');
			
			if( value != undefined && value != '' ) {
				 $(this).attr('data-value', '');
				var $select = $(this);
				$(this).find('option').each(function(i,o){
				
				    if( $(this).attr('value') == value ) {
				         $(this).attr('selected','selected');   
				         //$(o).remove();
				         
				         $select.val( value );
				    }
				});
			}
		});

		
		
		
		$(frslib.options.select_content_type.selectors.ff_select_content_type).trigger('change');
		
	});
	
};
//ffOptionsPrinterDataBoxGenerator
$(document).on('change', frslib.options.select_content_type.selectors.ff_select_content_type, function(){

	var current_value = $(this).val();
	var $changed_select = $(this);
	
	
	$changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2').hide();
	var $spinner=  $('<div class="spinner"></div>').css('display','block');
	$changed_select.parents('table:first').find('.ff-select2-wrapper').parent().before( $spinner );
	
	
	var continue_with_change = function() {
		var new_values = frslib.options.select_content_type.fetched_data[ current_value ];
		
		frslib.options.select2.setValuesHtml($changed_select.parents('table:first').find('.ff-select2-wrapper'), new_values);
		$spinner.remove();
		$changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2').show();
		
		var selected_value = $changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2-value-wrapper input').val();
		
		
		if( selected_value != undefined && selected_value != '' ) {
			var value_new = ( selected_value.split('--||--'));
			$changed_select.parents('table:first').find('.ff-select2-real-wrapper').find('.ff-select2').val( value_new );
			$changed_select.parents('table:first').find('.ff-select2-real-wrapper').find('.ff-select2').select2('val', value_new);
			$changed_select.parents('table:first').find('.ff-select2-wrapper').find('.ff-select2-value-wrapper input').val('');
			//}, 500);
		}
	};
	
	if( frslib.options.select_content_type.fetched_data[ current_value ] == undefined ) {
		frslib.ajax.frameworkRequest( 'ffOptionsPrinterDataBoxGenerator', {'type':'select_content_type'}, { 'select_value' : current_value }, function( response ){
			frslib.options.select_content_type.fetched_data[ current_value ] = response;
			continue_with_change();
		});
	} else {
		continue_with_change();
	}
});


frslib.options.select_content_type.init();



//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// CONDITIONAL LOGIC
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
frslib.provide( 'frslib.conditional_logic');
$(document).on('click','.ff-logic',function(){
	
	frslib.modal.conditional_logic.set_content( $(this).val() );
	frslib.modal.conditional_logic.current_input = $(this);

});

// enabling / disabling the custom logic
$(document).on('click', '.ff-conditional-logic-checkbox', function(){
	//1$(this).parent().parent().find('.ff-conditional-logic-options').;
	 //ff-repeatable-logic-disabled
	
	frslib.conditional_logic.disable_options( $(this ) );
});

frslib.conditional_logic.disable_options = function( $checkbox ) {
	if( $checkbox.attr('checked') == 'checked' ) {
		$checkbox.parent().parent().find('.ff-conditional-logic-options').removeClass('ff-repeatable-logic-disabled');
	} else {
		$checkbox.parent().parent().find('.ff-conditional-logic-options').addClass('ff-repeatable-logic-disabled');
	}
};
$(document).ready(function(){
	$('.ff-conditional-logic-checkbox').each(function(){
		frslib.conditional_logic.disable_options( $(this ) );
	});
});

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//IMAGE
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
(function(){

	$(document).on('click','.ff-open-image-library-button',function(e){

		$('.ff-open-image-library-button-opened').removeClass('ff-open-image-library-button-opened');
		$(this).addClass('ff-open-image-library-button-opened');

		e.preventDefault();

		// http://codecanyon.net/forums/thread/wordpress-35-media-uploader-api/83117

		var custom_uploader = wp.media({
			title: 'Custom Title',
			button: { text: 'Custom Button Text' },
			library : { type : 'image'},
			// id: 103,
			multiple: false  // Set this to true to allow multiple files to be selected
		});


		// Multiple
		// custom_uploader.on('open',function() {
		// 	var selection = custom_uploader.state().get('selection');
		// 	ids = jQuery('#my_field_id').val().split(',');
		// 	ids.forEach(function(id) {
		// 		attachment = wp.media.attachment(id);
		// 		attachment.fetch();
		// 		selection.add( attachment ? [ attachment ] : [] );
		// 	});
		// });

		// Single
		custom_uploader.on('open',function() {
			var selection = custom_uploader.state().get('selection');
			var jsoned_value = $('.ff-open-image-library-button-opened').find('input').val();
			if( jsoned_value ){ ; } else { return; }

			obj = JSON.parse( jsoned_value );
			if( obj ){ ; } else { return; }
			var id = obj.id;

			var attachment = wp.media.attachment(id);
			attachment.fetch();
			selection.add( attachment ? [ attachment ] : [] );
		});

		custom_uploader.on('select', function() {
			var attachment = custom_uploader.state().get('selection').first().toJSON();
			$('.ff-open-image-library-button-opened').find('.custom_media_image').attr('src', attachment.url);

			// $('.ff-open-image-library-button-opened').find('.custom_media_url').val(attachment.url);
			// $('.ff-open-image-library-button-opened').find('.custom_media_id').val(attachment.id);

			j = { "id":attachment.id, "url":attachment.url };

			$('.ff-open-image-library-button-opened').find('input').val( JSON.stringify( j ) );

			$('.ff-open-image-library-button-opened').find('.ff-open-library-button-preview-image').css('background-image', 'url(' + attachment.url + ')');
		})
		.open();

	});

	$(document).on('click','.ff-open-library-remove',function(e){
		var $button = $(this).parents('.ff-open-image-library-button-wrapper').find('.ff-open-image-library-button');
		if( $button ){
			$button.find('input').val( '' );
			$button.find('.ff-open-library-button-preview-image').css('background-image', 'none');
		}
	});


	return;


	// wp.media.freshfaceLib = {

	// 		library: { type : 'image'},

	// 		frame: function() {
	// 		    if ( this._frame )
	// 		        return this._frame;

	// 		    this._frame = wp.media({
	// 		        id:         'my-frame',
	// 		        frame:      'post',
	// 		        state:      'gallery-edit',
	// 		        title:      wp.media.view.l10n.editGalleryTitle,
	// 		        editing:    true,
	// 		        multiple:   true
	// 		    });
	// 		    return this._frame;
	// 		},

	// 		init: function() {
	// 		    $('.ff-open-image-library-button').click( function( event ) {
	// 		        event.preventDefault();

	// 				// Set the post ID to what we want
	// 				// file_frame.uploader.uploader.param( 'post_id', set_to_post_id );

	// 		        wp.media.freshfaceLib.frame().open();

	// 		    });
	// 		}
	// 	};

	// 	$(document).ready(function(){
	// 	    $( wp.media.freshfaceLib.init );
	// 	});


/*	var sendAttachmentBackup = wp.media.editor.send.attachment;
	var firedFromUs = false;
	
	
	$(document).on('click','.ff-open-image-library-button',function(){
		firedFromUs = true;
		
		 wp.media.editor.send.attachment = function(props, attachment){
			    /* //	console.log( attachment );
			      if ( _custom_media ) {
			        $("#"+id).val(attachment.url);
			      } else {
			        return _orig_send_attachment.apply( this, [props, attachment] );
			      };* /
		 }
		 
		 wp.media.editor.open('x');
	});*/
})();


/*
var _custom_media = true,
_orig_send_attachment = wp.media.editor.send.attachment;
$(document).on('click','.ff-test-button',function(){
	 var send_attachment_bkp = wp.media.editor.send.attachment;
	    var button = $(this);
	    var id = button.attr('id').replace('_button', '');
	    _custom_media = true;
	    wp.media.editor.send.attachment = function(props, attachment){
	    //	console.log( attachment );
	      if ( _custom_media ) {
	        $("#"+id).val(attachment.url);
	      } else {
	        return _orig_send_attachment.apply( this, [props, attachment] );
	      };
	    }

	    wp.media.editor.open(button);
	    
	    window.send_to_editor = function(a, b, c, d ) {
	    	console.log( 'xx' );
	    	//console.log( a );
	    	//console.log( b );
	    	console.log( c );
	    }
	    
	 
	    
	    frame = wp.media({
	        title : 'My Gallery Title',
	        multiple : true,
	        library : { type : 'image'},
	        button : { text : 'Insert' },
	      });
	    
	    frame.on('open',function() {
	    	  var selection = frame.state().get('selection');
	    	  ids = jQuery('#my_field_id').val().split(',');
	    	    ids.forEach(function(id) {
	    	  attachment = wp.media.attachment(id);
	    	  attachment.fetch();
	    	  selection.add( attachment ? [ attachment ] : [] );
	    	});
	    	});
	    
	    return false;
}); */

// console.log( window.send_to_editor + 'x');

//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
// HELPERs
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################
//##############################################################################


(function($) {
	  'use strict';
	  
	  
	  var hasNativeOuterHTML = !!('outerHTML' in $('<div></div>').get(0));
	  
	  // Prefer the native `outerHTML` property when possible
	  var getterFn = function() {
	    var target = this.get(0);

	    // If the browser supports the `outerHTML` property on elements AND if `target` is an element node
	    if (hasNativeOuterHTML && target.nodeType === 1) {
	      return target.outerHTML;
	    }
	    else {
	      return $('<div></div>').append(this.eq(0).clone()).html();
	    }
	  };
	  
	  var setterFn = function(value) {
	    // Do not attempt to replace anything using the native `outerHTML` property setter
	    // even if it exists: it is riddled with bugs!
	    return $('<div id="jquery-outerHtml-transformer"></div>').append(value).contents().replaceAll(this);
	  };

	  // Detect jQuery 1.8.x bug (for which the value here is `false`)
	  var doesNotLeaveTempParentOnDetachedDomElement = true;

	  $.fn.outerHtml = function(value) {
	    if (arguments.length) {
	      if (doesNotLeaveTempParentOnDetachedDomElement) {
	        return setterFn.call(this, value);
	      }
	      else {
	        // Fix for jQuery 1.8.x bug: https://github.com/JamesMGreene/jquery.outerHtml/issues/1
	        var parentsOfThis = (function() {
	          var parents = new Array(this.length);
	          this.each(function(i) {
	            parents[i] = this.parentNode || null;
	          });
	          return parents;
	        }).call(this);
	        
	        return setterFn.call(this, value).map(function(i) {
	          if (!parentsOfThis[i]) {
	            if (this.parentNode) {
	              return this.parentNode.removeChild(this);
	            }
	          }
	          else if (parentsOfThis[i] !== this.parentNode) {
	            // Appending to the end: this doesn't seem right but it should cover the detached DOM scenarios
	            return parentsOfThis[i].appendChild(this);
	          }
	          return this;
	        });
	      }
	    }
	    else {
	      return getterFn.call(this);
	    }
	  };
	  
	  // Detect jQuery 1.8.x bug (for which the value here is `false`)
	  doesNotLeaveTempParentOnDetachedDomElement = (function() {
	    var parent = $('<s>bad</s>').outerHtml('<div>good</div>').get(0).parentNode;
	    return (parent.nodeName === '#document-fragment' && parent.nodeType === 11);
	  })();

	}(jQuery));














return;
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


})(jQuery);