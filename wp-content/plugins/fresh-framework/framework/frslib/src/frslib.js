/******************************************************************************/
/** Global fresh library object, used across all our plugins and shit. Here we
/** assign sub-libraries, important for other our stuff. It also cooperates with
/** jquery
/******************************************************************************/
"use strict";

var frslib = frslib || {};
////////////////////////////////////////////////////////////////////////////////
// FROM GOOGle CLOSURE
////////////////////////////////////////////////////////////////////////////////
frslib.global = this;
frslib.isDef = function(val) {
	  return val !== undefined;
	};
frslib.exportPath_ = function(name, opt_object, opt_objectToExportTo) {
	  var parts = name.split('.');
	  var cur = opt_objectToExportTo || frslib.global;

	  // Internet Explorer exhibits strange behavior when throwing errors from
	  // methods externed in this manner.  See the testExportSymbolExceptions in
	  // base_test.html for an example.
	  if (!(parts[0] in cur) && cur.execScript) {
	    cur.execScript('var ' + parts[0]);
	  }

	  // Certain browsers cannot parse code in the form for((a in b); c;);
	  // This pattern is produced by the JSCompiler when it collapses the
	  // statement above into the conditional loop below. To prevent this from
	  // happening, use a for-loop and reserve the init logic as below.

	  // Parentheses added to eliminate strict JS warning in Firefox.
	  for (var part; parts.length && (part = parts.shift());) {
	    if (!parts.length && frslib.isDef(opt_object)) {
	      // last part and we have an object; use it
	      cur[part] = opt_object;
	    } else if (cur[part]) {
	      cur = cur[part];
	    } else {
	      cur = cur[part] = {};
	    }
	  }
};

frslib.provide = function( name ) {
	return frslib.exportPath_(name);
};
////////////////////////////////////////////////////////////////////////////////
// HTML FORMS
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.htmlforms');
(function($){
	frslib.htmlforms.writeValueToCode = function( $selector ) {
		$selector.find('input').each(function(){
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
	}
})(jQuery);
////////////////////////////////////////////////////////////////////////////////
// CALLBACKS
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.callbacks');

(function($){
	//console.log(frslib['htmlforms']['writeValueToCode']);
	frslib.callbacks.functions = Array();
	frslib.callbacks.addCallback = function( eventName, callback ) {
		frslib.provide('frslib.callbacks.functions.'+eventName);
		frslib.callbacks.functions[eventName] = new Array();
		frslib.callbacks.functions[eventName].push(callback);
	}
	
	frslib.callbacks.doCallback = function( eventName ) {
		
		if( !(eventName in frslib.callbacks.functions) ) {
			return false;
		}
		
		var newArguments = Array();
		
		for( var argumentsKey in arguments ) {
			if( !Number.isNaN(argumentsKey) && argumentsKey > 0 ){
				newArguments[ argumentsKey-1 ] = arguments[ argumentsKey ];
			}
		}
		
		for( var key in frslib.callbacks.functions[eventName] ) {
			frslib.callbacks.functions[eventName][key].apply( this,newArguments);
		}
	}
})(jQuery);

////////////////////////////////////////////////////////////////////////////////
//COLORS
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.colors');
frslib.provide('frslib.colors.convert');

(function($){
	frslib.colors.convert.hexToRgb = function(hex) {
	    var result = /^#?([a-f\d]{2})([a-f\d]{2})([a-f\d]{2})$/i.exec(hex);
	    return result ? {
	        r: parseInt(result[1], 16),
	        g: parseInt(result[2], 16),
	        b: parseInt(result[3], 16)
	    } : null;
	};
	
	frslib.colors.convert.rgbToHsl = function (r, g, b){
	    r /= 255, g /= 255, b /= 255;
	    var max = Math.max(r, g, b), min = Math.min(r, g, b);
	    var h, s, l = (max + min) / 2;

	    if(max == min){
	        h = s = 0; // achromatic
	    }else{
	        var d = max - min;
	        s = l > 0.5 ? d / (2 - max - min) : d / (max + min);
	        switch(max){
	            case r: h = (g - b) / d + (g < b ? 6 : 0); break;
	            case g: h = (b - r) / d + 2; break;
	            case b: h = (r - g) / d + 4; break;
	        }
	        h /= 6;
	    }

	    return  { h:Math.floor(h * 360), s:Math.floor(s * 100), b:Math.floor(l * 100) };
	};
	
	
	frslib.colors.convert.rgbToHex = function (r,g,b)
	{
	  return '#' + r.toString(16) + g.toString(16) + b.toString(16);
	}
})(jQuery);
////////////////////////////////////////////////////////////////////////////////
//AJAX
////////////////////////////////////////////////////////////////////////////////
frslib.provide('frslib.ajax');

(function($){
	frslib.ajax.frameworkRequest = function( owner, specification, data, callback ) {
		$.post(
				ajaxurl,
				{
					'action':'ff_ajax',
					'owner': owner,
					'specification':specification,
					'data':data
				},
				callback
		);
	};
	
	frslib.ajax.adminScreenRequest = function( specification, data, callback ) {
		
		// ff-view-identification admin-screen-name admin-view-name
		var adminScreenName = $('.ff-view-identification').find('.admin-screen-name').html();
		var adminViewName =$('.ff-view-identification').find('.admin-view-name').html(); 
		
		var data = {
				'adminScreenName' : adminScreenName,
				'adminViewName' : adminViewName,
				'specification' : specification,
				'action' : 'ff_ajax_admin',
				'data' : data
		}
		
		$.post(
				ajaxurl,
				data,
				callback
		);
	}
})(jQuery);